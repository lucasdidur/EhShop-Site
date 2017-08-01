<?

interface Gateway
{
    public function getName();

    public function getURLPayment($data);

    public function getURLSignature();

    public function getStatus($status);

    public function isEnabled();

    /**
     *	Check if the Gatways as received the payment.
     *	
     *	@return If the user as payed then return true otherwise false
     */
	public function isPayed($id_transacao);

}

?>