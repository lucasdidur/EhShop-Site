<?

$pingback = new Paymentwall_Pingback($_GET, $_SERVER['REMOTE_ADDR']);
if ($pingback->validate()) {
    $productId = $pingback->getProduct()->getId();
    if ($pingback->isDeliverable()) {
        // deliver the product
    } else if ($pingback->isCancelable()) {
        // withdraw the product
    }
    echo 'OK';
} else {
    echo $pingback->getErrorSummary();
}