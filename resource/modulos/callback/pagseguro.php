<?php
include("../../../loader.php");

ini_set('error_log', '../../../ipn_errors_pagseguro.log');

if (isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction')
{
    $email = API_EMAIL_PAYMENT;
    $token = API_PAGSEGURO_TOKEN;
    $host = "https://ws.pagseguro.uol.com.br";

    if (API_PAGSEGURO_SANDBOX)
    {
        $email = API_PAGSEGURO_SANDBOX_EMAIL;
        $token = API_PAGSEGURO_SANDBOX_TOKEN;
        $host = "https://ws.sandbox.pagseguro.uol.com.br";
    }

    $transaction = file_get_contents($host . "/v2/transactions/notifications/" . $_POST['notificationCode'] . "?email=" . $email . "&token=" . $token);

    if ($transaction == 'Unauthorized')
        die("Unauthorized");

    $infos = simplexml_load_string($transaction);

    switch($infos->status)
    {
        // Pago
        case '3':
            $id_order = $infos->reference;
            $trscao_id = $infos->code;
            $value = $infos->netAmount;

            addPagamento("pagseguro", $id_order, $trscao_id, $value);

            setToAtive($id_order);

            break;

        // Disputa
        case '5':
            break;

        // Retenção Temporaria
        case '9':
            break;

    }
}
else
{
    echo "Funciona";
}