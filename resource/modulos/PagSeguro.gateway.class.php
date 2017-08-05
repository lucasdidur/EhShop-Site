<?

class PagSeguro implements Gateway
{
    public function getName()
    {
        return "PagSeguro";
    }
/*            $data = array(
                      itemDescription1'    =>'Descricao',
                      itemAmount1'         =>'40.00',
                      reference'           =>'ID Pedido',
                      extraAmount'         =>'2.50',
                      senderEmail'         =>'comprador@uol.com.br');*/
    public function getURLPayment($order_details)
    {
        $data = array();

        $url = "https://ws.pagseguro.uol.com.br/v2/checkout/";
        $payament_url  =  "https://pagseguro.uol.com.br";
        $data['token'] = API_PAGSEGURO_TOKEN;
        $data['email'] = API_EMAIL_PAYMENT;

        if(API_PAGSEGURO_SANDBOX)
        {
            $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/checkout/";
            $payament_url = "https://sandbox.pagseguro.uol.com.br";
            $data['token'] = API_PAGSEGURO_SANDBOX_TOKEN;
            $data['email'] = API_PAGSEGURO_SANDBOX_EMAIL;
        }

        foreach($order_details['cart'] as $key => $products)
        {
            $data['itemId' . ($key)] = ($key);
            $data['itemDescription' . ($key)] = $products['description'];
            $data['itemAmount' . ($key)] = $products['amount'];
            $data['itemQuantity' . ($key)] = $products['quantity'];
        }

        $data['reference'] = $order_details['id_order'];
        $data['name'] = $order_details['name'];
        $data['senderEmail'] = $order_details['email'];


        $data['notificationURL'] = API_PAGSEGURO_CALLBACK;
        $data['redirectURL'] = API_RETURN_URL_COMPLETED;

        $data['currency']   = "BRL";

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ),
        );


        $result = file_get_contents($url, false, stream_context_create($options));

        $code = between("<code>","</code>", $result);

        return $payament_url . "/v2/checkout/payment.html?code=". $code;
    }

    public function getURLPayment2($order_details)
    {
        $paymentRequest = new PagSeguroPaymentRequest();

        // Set the currency
        $paymentRequest->setCurrency("BRL");

        foreach($order_details['cart'] as $key => $products)
        {
            // Add an item for this payment request
            $paymentRequest->addItem($key, $products['description'], $products['quantity'], $products['amount']);
        }

        // Set a reference code for this payment request. It is useful to identify this payment
        // in future notifications.
        $paymentRequest->setReference($order_details['id_order']);

        // Set your customer information.
        $paymentRequest->setSender(
            $order_details['name'],
            $order_details['email']
        );

        // Set the url used by PagSeguro to redirect user after checkout process ends
        $paymentRequest->setRedirectUrl(API_RETURN_URL_COMPLETED);
        $paymentRequest->addParameter('notificationURL', API_PAGSEGURO_CALLBACK);

        $paymentRequest->addMetadata('GAME_NAME', $order_details['username']);

        try {

            /*
             * #### Credentials #####
             * Replace the parameters below with your credentials
             * You can also get your credentials from a config file. See an example:
             * $credentials = PagSeguroConfig::getAccountCredentials();
            //  */

            // seller authentication
            $credentials = new PagSeguroAccountCredentials(API_EMAIL_PAYMENT, API_PAGSEGURO_TOKEN);

            // application authentication
            //$credentials = PagSeguroConfig::getApplicationCredentials();

            //$credentials->setAuthorizationCode("E231B2C9BCC8474DA2E260B6C8CF60D3");

            // Register this payment request in PagSeguro to obtain the payment URL to redirect your customer.
            $url = $paymentRequest->register($credentials);

            return $url;

        } catch (PagSeguroServiceException $e) {
            die($e->getMessage());
        }
    }

    public function getURLSignature()
    {
        return "assets/img/gateways/pagseguro.png";
    }

    public function getStatus($id)
    {
        if($id == 1)
            $id = 'Aguardando Pagamento';
        elseif($id == 2)
            $id = 'Em análise';
        elseif($id == 3)
            $id = 'Pago';
        elseif($id == 4)
            $id = 'Pago';
        elseif($id == 5)
            $id = 'Em disputa';
        elseif($id == 6)
            $id = 'Devolvida';
        elseif($id == 7)
            $id = 'Pagamento Cancelado';
        elseif($id == 8)
            $id = 'Fazer Pagamento';

        return $id;
    }


    public function isEnabled()
    {
        return true;
    }

    /**
     *  Check if the Gatways as received the payment.
     *  
     *  @return If the user as payed then return true otherwise false
     */
    public function isPayed($id_transacao) {
        //TODO: Create the function to validate if the payment is completed
        return false;
    }
}
?>