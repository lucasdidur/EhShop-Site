<?
include "loader.php";

if(isset($_REQUEST['action']))
{
    $action = $_REQUEST['action'];

    switch ($action)
    {
        case 'process_order':

            $data = array();
            $nome = @$_REQUEST['name'];
            $email = @$_REQUEST['email'];
            $birthday = @$_REQUEST['birthday'];
            $gateway =@$_REQUEST['gateway'];

            if(!$nome)
            {
                showError('Digite o seu nome.');
            }
            else if(!$email)
            {
                showError('É necessário preencher o campo email para contatarmos caso necessário.');
            }

            $user['name'] = $nome;
            $user['email'] = $email;
            $user['birthday'] = $birthday;

            $payment = new PaymentRequest();


            $payment->setOrder($_REQUEST['oid']);
            $payment->setGateway($gateway);
            $payment->setUser($user);

            if($payment->process())
            {
                $data['type'] = 'success';
                $data['data'] = $payment->getUrl();
            }
            else
            {
                $data['type'] = 'error';
                $data['message'] = $payment->getError();
            }

            echo json_encode($data);

            break;
    }
}

function showError($error)
{
    $data['type'] = 'error';
    $data['message'] = $error;

    echo json_encode($data);
    exit();
}

?>