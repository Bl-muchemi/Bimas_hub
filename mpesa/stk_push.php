<?php
// 1. Force error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Check if cURL is installed
if (!extension_loaded('curl')) {
    die("❌ Error: cURL extension is not enabled. Please enable it in php.ini and restart Apache.");
}

include '../includes/db.php'; // Database connection

// --------------------------
// M-PESA Credentials
// --------------------------
define('CONSUMER_KEY', '');
define('CONSUMER_SECRET', '0D5hOsIp2alMuJHEXX3uJuNZojKcPF3ROstAlanbVaczZVGxOmJGVJK7CO1GVyC0');
define('BUSINESS_SHORTCODE', '174379'); 
define('PASSKEY', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'); 
define('CALLBACK_URL', 'https://yourdomain.com/callback.php'); 
define('ENVIRONMENT', 'sandbox');

if(isset($_POST['pay'])) {
    $amount = intval($_POST['amount'] ?? 0);
    $userPhone = preg_replace('/\D/', '', $_POST['phone'] ?? ''); 
    $service = $_POST['service'] ?? 'Bimas Hub';

    // Phone formatting (2547XXXXXXXX)
    if (strlen($userPhone) == 10 && substr($userPhone, 0, 1) == "0") {
        $phone = "254" . substr($userPhone, 1);
    } elseif (strlen($userPhone) == 9 && substr($userPhone, 0, 1) == "7") {
        $phone = "254" . $userPhone;
    } else {
        $phone = $userPhone;
    }

    if($amount <= 0 || strlen($phone) < 12) {
        die("Invalid amount or phone number format.");
    }

    $timestamp = date('YmdHis');
    $password = base64_encode(BUSINESS_SHORTCODE . PASSKEY . $timestamp);

    // --------------------------
    // Step 1: Generate Access Token
    // --------------------------
    $token_url = ENVIRONMENT === 'sandbox' 
        ? "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials"
        : "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

    // Using trim to ensure no white spaces exist in the keys
    $credentials = base64_encode(trim(CONSUMER_KEY) . ":" . trim(CONSUMER_SECRET));

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Basic $credentials"]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    $result = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    $token_data = json_decode($result, true);

    if(!isset($token_data['access_token'])){
        echo "<h3>Token Generation Failed</h3>";
        echo "Raw Response: " . $result;
        die();
    }
    
    // TRICK: Trim the token to prevent 404.001.03 errors
    $access_token = trim($token_data['access_token']);

    // --------------------------
    // Step 2: Prepare STK Push
    // --------------------------
    $stk_url = ENVIRONMENT === 'sandbox'
        ? "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest"
        : "https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

    $postData = [
        "BusinessShortCode" => BUSINESS_SHORTCODE,
        "Password" => $password,
        "Timestamp" => $timestamp,
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => $amount,
        "PartyA" => $phone,
        "PartyB" => BUSINESS_SHORTCODE,
        "PhoneNumber" => $phone,
        "CallBackURL" => CALLBACK_URL,
        "AccountReference" => substr($service, 0, 12), 
        "TransactionDesc" => "Payment for " . substr($service, 0, 10)
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $stk_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $access_token 
    ]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($curl);
    curl_close($curl);

    $res = json_decode($response, true);

    // --------------------------
    // Step 3: Save to DB
    // --------------------------
    if(isset($res['CheckoutRequestID'])){
        $checkoutRequestID = $res['CheckoutRequestID'];
        $stmt = $conn->prepare(
            "INSERT INTO mpesa_transactions (phone, service, amount, checkout_request_id, status) VALUES (?, ?, ?, ?, ?)"
        );
        $status = 'pending';
        $stmt->bind_param('ssiss', $phone, $service, $amount, $checkoutRequestID, $status);
        $stmt->execute();
        $stmt->close();
        
        echo "✅ Success! STK Push initiated. Check phone $phone for the PIN prompt.";
    } else {
        echo "<h3>M-Pesa STK Push Error</h3>";
        echo "<strong>Error Code:</strong> " . ($res['errorCode'] ?? 'N/A') . "<br>";
        echo "<strong>Message:</strong> " . ($res['errorMessage'] ?? 'Unknown Error') . "<br>";
        echo "<pre>"; print_r($res); echo "</pre>";
        
        if (($res['errorCode'] ?? '') == '404.001.03') {
            echo "<p><em>Tip: If this persists with new keys, ensure your App on Daraja has 'Lipa Na M-Pesa Sandbox' enabled under Products.</em></p>";
        }
    }
}
?>