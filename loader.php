<?php
session_start();

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

define("ROOT", dirname(__FILE__) . "/");

include ROOT . "resource/config.php";
include ROOT . "resource/MinecraftColor.php";
include ROOT . "resource/functions.php";

include ROOT . "resource/modulos/Gateway.php";

include_all_php(ROOT . "resource/class/");
include_all_php(ROOT . "resource/modulos/");


include ROOT . "resource/user.class.php";
include ROOT . "resource/PaymentRequest.php";

$inc_header = false;

if ($inc_header)
    include(ROOT . "themes/header.php");

?>