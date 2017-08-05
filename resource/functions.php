<?php

/**
 *
 */
if (!function_exists("include_all_php"))
{

    function include_all_php($folder)
    {
        global $gateways;
        foreach (glob("{$folder}/*gateway.class.php") as $filename)
        {
            include_once $filename;

            $name = basename($filename, ".gateway.class.php");
            $gateways[] = new $name();
        }

        foreach (glob("{$folder}/*.php") as $filename)
        {
            include_once $filename;
        }
    }

}

function porcentagem_nx($valor, $total)
{
    return ($valor * 100) / $total;
}

function get_arrecadado()
{
    global $db;

    $stmt = $db->prepare("SELECT truncate(sum(value), 2) as `total` FROM `ea_transation`
                            WHERE MONTH(`date`) = MONTH(CURDATE()) AND YEAR(`date`) = YEAR(CURDATE())");
    $stmt->execute();

    $last = $stmt->fetch(PDO::FETCH_ASSOC);

    return $last['total'];
}

function getCategorias()
{
    global $db;

    $stmt = $db->prepare("SELECT * FROM `ea_categories` ORDER BY name");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getServidores()
{
    global $db;

    $stmt = $db->prepare("SELECT * FROM `ea_servers` ORDER BY name;");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}


function get_percent_arrecadacao()
{
    $value = porcentagem_nx(get_arrecadado(), OBJETIVO_ARRECADACAO);

    return round($value, 2);
}

function get_price($oid, $default = false, $quantity = 1)
{
    global $db;

    $stmt = $db->prepare('SELECT price FROM ea_orders eo JOIN ea_packages ep ON eo.id_package = ep.id_package WHERE id_order = ?')
    $stmt->execute(array($oid));
    $package = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $price = $package['price'];

    if ($default)
        $price = $price;
    else
        $price = $price;

    return formatar_numero($price * $quantity, true);
}

function get_product_name($oid)
{
    global $db;

    $stmt = $db->prepare('SELECT name FROM ea_orders eo JOIN ea_packages ep ON eo.id_package = ep.id_package WHERE id_order = ? LIMIT 1')
    $stmt->execute(array($oid));
    $package = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $package['name'];
}

function get_nick($oid)
{
    global $db;

    $stmt = $db->prepare('SELECT nick FROM ea_orders eo JOIN ea_packages ep ON eo.id_package = ep.id_package WHERE id_order = ? LIMIT 1');
    $stmt->execute(array($oid));
    $package = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $package['nick'];
}

function get_cart_size()
{
    return count(@$_SESSION['cart']);
}

function remove_product($pid)
{
    $pid = intval($pid);
    $max = count($_SESSION['cart']);

    for ($i = 0; $i < $max; $i++)
    {
        if ($pid == $_SESSION['cart'][$i]['productid'])
        {
            unset($_SESSION['cart'][$i]);
            break;
        }
    }

    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

function get_order_total()
{
    $max = count(@$_SESSION['cart']);
    $sum = 0;

    for ($i = 0; $i < $max; $i++)
    {
        $pid = $_SESSION['cart'][$i]['productid'];
        $q = $_SESSION['cart'][$i]['qty'];
        $price = get_price($pid);
        $sum += $price * $q;
    }

    return formatar_numero($sum);
}

function addtocart($pid, $q)
{
    if ($pid < 1 or $q < 1)
        return;

    if (isset($_SESSION['cart']) && is_array($_SESSION['cart']))
    {
        $max = count($_SESSION['cart']);
        $_SESSION['cart'][$max]['productid'] = $pid;
        $_SESSION['cart'][$max]['qty'] = $q;
    } else
    {
        $_SESSION['cart'] = array();
        $_SESSION['cart'][0]['productid'] = $pid;
        $_SESSION['cart'][0]['qty'] = $q;
    }
}


function is_session_started()
{
    if (php_sapi_name() !== 'cli')
    {
        if (version_compare(phpversion(), '5.4.0', '>='))
        {
            return session_status() === PHP_SESSION_ACTIVE && isset($_SESSION["username"]) ? TRUE : FALSE;
        } else
        {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}


function getRecentOrders($limit = 5)
{
    global $db;

    $stmt = $db->prepare("SELECT * FROM `ea_orders` o
                            JOIN ea_packages p ON o.id_package = p.id_package
                          WHERE (o.status = :status1 OR o.status = :status2)
                            AND p.price_type = 'MONEY'
                          ORDER BY date_created DESC
                          LIMIT 0, :limit");

    $stmt->bindValue("status1", Status::ACTIVE);
    $stmt->bindValue("status2", Status::WAITING_ACTIVATION);
    $stmt->bindValue("limit", $limit);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Gera uma string aleatoria
 *
 * @return string
 */
function rand_string()
{
    return md5(current_time());
}

/**
 * @param $start
 * @param $end
 * @param $source
 *
 * @return string
 */
function between($start, $end, $source)
{
    $s = strpos($source, $start) + strlen($start);

    return substr($source, $s, strpos($source, $end, $s) - $s);
}

/**
 * @param      $string
 * @param bool $exit
 * @param bool $varDump
 */
function printR($string, $exit = false, $varDump = false)
{
    echo "<pre style='font-family: Courier New, Courier; font-size: 12px'>";
    if ($varDump)
    {
        var_dump($string);
    } else
    {
        print_r($string);
    }
    echo "</pre>";
    if ($exit)
    {
        exit();
    }
}

/**
 * @param      $numero
 * @param bool $bruto
 *
 * @return string
 */
function formatar_numero($numero, $bruto = false)
{
    if ($bruto)
        $numero = str_replace(",", ".", $numero);

    $separador = ',';

    if ($bruto)
        $separador = '.';

    return number_format($numero, 2, $separador, '.');
}

/**
 * @param      $valor
 * @param      $desconto
 * @param bool $desconto_todos
 * @param int $mes
 * @param int $tipo
 *
 * @return mixed
 */
function eh_get_desconto($valor, $desconto, $desconto_todos = false, $mes = 1, $tipo = 1)
{

    $valor = $valor * $mes;

    $desconto = (($valor * $desconto) / 100);

    $ativar = false;

    if ($desconto_todos && $mes == 1 || $mes > 1)
        $ativar = true;

    if ($ativar)
        $valor_final = $valor - $desconto;
    else
        $valor_final = $valor;

    return $valor_final;
}

//
// Calcular a Data Final
//
////////////////////////////////////////////////////////////////////////////////////////////////////

function current_time($type = 'timestamp', $date = "")
{
    switch ($type)
    {
        case 'mysql':
            return date('Y-m-d H:i:s', time());

        case 'timestamp':
            return time();

        case 'date':
            return date('d/m/Y', strtotime($date)) . ' às ' . date('H:i', strtotime($date));
    }
}


function setToAtive($id_order)
{
    global $db;

    $stmt = $db->prepare("UPDATE `ea_orders` SET `status` = :status WHERE `id_order` = :id_order;");
    $stmt->bindValue(':status', Status::WAITING_ACTIVATION);
    $stmt->bindValue(':id_order', $id_order);
    $stmt->execute();
}

function addPagamento($gateway, $id_order, $id_transation, $amount)
{
    global $db;

    $stmt = $db->prepare("INSERT INTO `ea_transation` (`gateway`, `id_order`, `id_transation`, `value`)
                          VALUES (:gateway, :id_order, :id_transation, :value);");

    $stmt->bindValue(':gateway', $gateway);
    $stmt->bindValue(':id_order', $id_order);
    $stmt->bindValue(':id_transation', $id_transation);
    $stmt->bindValue(':value', $amount);

    $stmt->execute();
}

function gerarCode($total_caracteres)
{
    $caracteres = 'abcdefghijklmnopqrstuwxyz';

    $max = strlen($caracteres) - 1;
    $senha = null;

    for ($i = 0; $i < $total_caracteres; $i++)
    {
        $senha .= $caracteres{mt_rand(0, $max)};
    }

    return $senha;
}

function redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    } else
        echo '<META http-equiv="refresh" content="0;URL=' . $url . '">';
    exit();
}

function getStatus($id_order)
{
    global $db;

    $stmt = $db->prepare("SELECT status FROM ea_orders eo JOIN ea_packages ep ON eo.id_package = ep.id_package WHERE id_order = ? LIMIT 1");
    $stmt->execute(array($id_order));

    $package = $stmt->fetch();
    return $package['status'];

}

function isPaid($id_order)
{
    return getStatus($id_order) != Status::WAITING_PAYMENT;
}

function getStatusName($status)
{
    switch ($status)
    {
        case Status::WAITING_ACTIVATION;
            return "Aguardando Ativação";

        case Status::ACTIVE;
            return "Ativo";

        case Status::WAITING_DESACTIVATION;
            return "Aguardando Desativação";

        case Status::EXPIRED;
            return "Expirado";

        case Status::WAITING_PAYMENT;
            return "Aguardando Pagamento";
    }
}

/**
 * Convert a String to a Gateway instance.
 *
 * @param $gateway
 *      String with the name of the instance.
 *
 * @return A gateway instance if valid and a null if not.
 */
function getGatewayFromString($gateway) {
    
    switch ($gateway) {
        case "pagseguro":
            return new PagSeguro();
        case "paypal":
            return new PayPal();
    }

    return null;
}

abstract class Status
{
    const WAITING_ACTIVATION = 1;
    const ACTIVE = 2;
    const WAITING_DESACTIVATION = 3;
    const EXPIRED = 4;
    const WAITING_PAYMENT = 5;
}