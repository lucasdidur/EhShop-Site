<?php

/**
 * Created by IntelliJ IDEA.
 * User: Lucas
 * Date: 26/06/2016
 * Time: 09:22
 */
class PaymentRequest
{
    var $order_id;

    var $gateway;

    var $user;
    var $url;

    function setOrder($order_id)
    {
        $this->order_id = $order_id;
    }

    function setGateway($gateway)
    {
        $this->gateway = getGatewayFromString($gateway);
    }


    function setUser($user)
    {
        $this->user = new User();

        $this->user->setIdOrder($this->order_id);
        $this->user->setName($user['name']);
        $this->user->setEmail($user['email']);
        $this->user->setBirthday($user['birthday']);
        $this->user->save();
    }

    function process()
    {
        // Check if the Gateway isn't null to avoid internal error
        if (is_null($this->gateway))
            return false;

        $data = array();

        $data['id_order'] = $this->order_id;
        $data['name'] = $this->user->name;
        $data['email'] = $this->user->email;
        $data['username'] = get_nick($this->order_id);

        $data['cart'][1]['description'] = get_product_name($this->order_id) . " (Nick: " . get_nick($this->order_id) . ")";
        $data['cart'][1]['amount'] = get_price($this->order_id);
        $data['cart'][1]['quantity'] = 1;

        $this->url = $this->gateway->getURLPayment($data);

        if (isset($this->url))
            return true;

        return false;
    }

    function getUrl()
    {
        return $this->url;
    }

    function getError()
    {
        return "Erro ao obter URL";
    }

}
