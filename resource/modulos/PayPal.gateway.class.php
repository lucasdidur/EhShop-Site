<?

class PayPal implements Gateway
{
    public function getName()
    {
        return "PayPal";
    }

    /*            $data = array(
                          item_name'    =>'Descricao',
                          itemAmount1'  =>'40.00',
                          item_number   =>
                          custom'       =>'ID Pedido',
                          tax'          =>'2.50',
                          senderEmail'         =>'comprador@uol.com.br');*/
    public function getURLPayment($order_details)
    {
        if (API_PAYPAL_SANDBOX)
        {
            $url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
            $email = "acc.paypal@ehaqui.com";
        } else
        {
            $url = "https://www.paypal.com/cgi-bin/webscr";
            $email = API_EMAIL_PAYMENT;
        }

        $data = array();

        $data['cmd'] = "_cart";
        $data['upload'] = 1;

        $data['cbt'] = "Return to webstore";
        $data['business'] = $email;
        $data['currency_code'] = "BRL";
        $data['charset'] = "utf-8";

        $data['custom'] = $order_details['id_order'];

        foreach ($order_details['cart'] as $key => $products)
        {
            $data['item_name_' . $key] = $products['description'];
            $data['amount_' . $key] = $products['amount'];
            $data['quantity_' . $key] = $products['quantity'];
        }

        $data['no_shipping'] = 0;

        $data['return'] = API_RETURN_URL_COMPLETED;
        $data['cancel_return'] = API_RETURN_URL;
        $data['notify_url'] = API_PAYPAL_CALLBACK;

        $data['lc'] = 'BR';
        $data['bn'] = 'PP-BuyNowBF';
        $data['email'] = $order_details['email'];

        $payment_url = $url . "?" . http_build_query($data);
        return $payment_url;
    }

    public function getURLSignature()
    {
        return "assets/img/gateways/paypal.png";
    }

    public function getStatus($id)
    {
        if ($id == 1)
            $id = 'Aguardando Pagamento';
        elseif ($id == 2)
            $id = 'Em análise';
        elseif ($id == 3)
            $id = 'Pago';
        elseif ($id == 4)
            $id = 'Pago';
        elseif ($id == 5)
            $id = 'Em disputa';
        elseif ($id == 6)
            $id = 'Devolvida';
        elseif ($id == 7)
            $id = 'Pagamento Cancelado';
        elseif ($id == 8)
            $id = 'Fazer Pagamento';

        return $id;
    }

    public function isEnabled()
    {
        return true;
    }
}

?>