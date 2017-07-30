<?php

/**
 * Created by IntelliJ IDEA.
 * User: Lucas
 * Date: 02/07/2016
 * Time: 11:18
 */
class Deposito implements Gateway
{

    public function getName()
    {
        return "Deposito (Em Breve)";
    }

    public function getURLPayment($data)
    {
        // TODO: Implement getURLPayment() method.
    }

    public function getStatus($status)
    {
        // TODO: Implement getStatus() method.
    }

    public function getURLSignature()
    {
        return "assets/img/gateways/none.png";
    }


    public function isEnabled()
    {
        return false;
    }
}