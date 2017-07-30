<?php
include ("../../../loader.php");

ini_set('error_log', '../../../ipn_errors_paypal.log');
include ('../paypal/ipnlistener.php');

file_put_contents("file.txt",serialize($_REQUEST));

$listener = new IpnListener();

if (API_PAYPAL_SANDBOX) 
    $listener->use_sandbox = true;
else 
    $listener->use_sandbox = false;
    
try
{
    $listener->requirePostMethod();
    $verified = $listener->processIpn();
}

catch(Exception $e)
{
    error_log($e->getMessage());
    exit(0);
}

if ($verified)
{
    $errmsg = '';
    if ($_POST['payment_status'] != 'Completed') exit(0);
    if ($_POST['receiver_email'] != API_EMAIL_PAYMENT)
    {
        $errmsg.= "'receiver_email' does not match: ";
        $errmsg.= $_POST['receiver_email'] . "\n";
    }

    if ($_POST['payer_status'] == 'unverified')
    {
        $errmsg.= "'payer_status' is inverified\n";
        $errmsg.= "id: " . $_POST['txn_id'] . "\n";
        $errmsg.= "value: " . ($_POST['mc_gross'] - $_POST['mc_fee']) . "\n";
        $errmsg.= "\nhttp://vip.ehaqui.com/administration/pedido/confirmar/" . $_POST['custom'] . "  Clique aqui para confirmar";
    }

    if (!empty($errmsg) && ($_POST['mc_gross'] > ACCEPT_UNFERIFIED_LIMIT && ACCEPT_UNFERIFIED))
    {
        $body = "Item nº " . $_POST['custom'] . " IPN failed fraud checks: \n$errmsg\n\n";
        $body.= $listener->getTextReport();
        mail(API_EMAIL_PAYMENT, 'PayPal ERROR - IPN Fraud Warning', $body);
    }
    else
    {
        addPagamento("paypal", $_POST['custom'], $_POST['txn_id'], $_POST['mc_gross'] - $_POST['mc_fee']);
        
        setToAtive($_POST['custom']);
    }
}
else
{
    mail(API_EMAIL_PAYMENT, 'PayPal ERROR - Invalid IPN', $listener->getTextReport());
}
