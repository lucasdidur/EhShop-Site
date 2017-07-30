<?

interface Gateway
{
    public function getName();

    public function getURLPayment($data);

    public function getURLSignature();

    public function getStatus($status);

    public function isEnabled();
}

?>