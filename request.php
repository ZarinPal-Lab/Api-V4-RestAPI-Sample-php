
<?php

$data = array(
    'MerchantID' => '4c2f1680-036c-4057-b6a8-06fdae8e8897', // Your Merchant Id | Required
    'Amount' => 100,  //Amount in Toman | Required
    'CallbackURL' => 'http://www.YourSite.com/', // Required
           'Description' => 'خرید تست',  // Required
    'Mobile' => '09375065007',  // Optional
    'Email' => 'test@yourDomian.com'  // Optional
);

$jsonData = json_encode($data);
$ch = curl_init('https://next.zarinpal.com/api/payment/request.json');
curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
));

$result = curl_exec($ch);
$err = curl_error($ch);
$result = json_decode($result, true);
curl_close($ch);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    if ($result["Status"] == 100) { //Request is ok and redirect user to ipg
        header('Location: https://next.zarinpal.com/payment/' . $result["Authority"] . '/zarinGate');
    } else { 
        echo 'Status: ' . $result["Status"];
        echo 'Message: ' . $result["Message"];
    }
}
?>
