<?php
// ==========================
// SAFARICOM SANDBOX CREDENTIALS
// ==========================
$consumerKey = 'YOUR_CONSUMER_KEY';      // Replace with your sandbox Consumer Key
$consumerSecret = 'YOUR_CONSUMER_SECRET'; // Replace with your sandbox Consumer Secret

// ==========================
// GENERATE ACCESS TOKEN
// ==========================
$credentials = base64_encode($consumerKey . ":" . $consumerSecret);
$token_url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Basic $credentials"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Optional: disable SSL verification for local testing (XAMPP)
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$response = curl_exec($ch);

if(curl_errno($ch)){
    die("cURL Error: ".curl_error($ch));
}

curl_close($ch);

// ==========================
// DISPLAY RAW RESPONSE
// ==========================
echo "<h2>Raw Response from Safaricom Sandbox</h2>";
echo "<pre>$response</pre>";

// ==========================
// DECODE AND SHOW ACCESS TOKEN
// ==========================
$data = json_decode($response, true);

if(isset($data['access_token'])){
    echo "<h2>Access Token:</h2>";
    echo "<pre>".$data['access_token']."</pre>";
} else {
    echo "<h2>Error:</h2>";
    echo "<pre>".print_r($data,true)."</pre>";
}
?>