<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "includes/db.php"; // 🔥 IMPORTANT FIX

// --- CART PRICES ---
$prices = [
    "Cement"=>1, "Sand"=>300, "Ballast"=>400, "Timber"=>1200, "Paints"=>800,
    "Plumbing materials"=>600, "Electrical supplies"=>700, "Desks"=>1500,
    "Office chairs"=>1200, "Filing cabinets"=>1000, "Printers"=>8000,
    "Photocopiers"=>15000, "Stationery"=>200, "School uniforms"=>1500,
    "Hospital uniforms"=>2000, "Corporate uniforms"=>1800, "Protective wear"=>1200,
    "Laptops"=>45000, "Desktops"=>40000, "Monitors"=>12000, "Keyboards"=>1500,
    "Networking devices"=>5000, "Maize"=>100, "Beans"=>120, "Rice"=>150,
    "Fruits"=>200, "Vegetables"=>150, "Milk"=>100
];

$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    die("<h2 style='text-align:center'>Your cart is empty</h2>");
}

$user_id = $_SESSION['user_id'] ?? 0;

$total = 0;

// =========================
// 1. CALCULATE TOTAL
// =========================
foreach($cart as $product_id => $qty){

    $qty = (int)$qty;

    $res = $conn->query("SELECT price FROM products WHERE id=$product_id");
    $row = $res->fetch_assoc();

    $price = $row['price'] ?? 0;
    $total += $price * $qty;
}

// =========================
// 2. PHONE FORMAT
// =========================
$userPhone = preg_replace('/\D/', '', $_POST['phone'] ?? '');

if (strlen($userPhone) == 10 && $userPhone[0] == "0") {
    $phoneNumber = "254" . substr($userPhone, 1);
} elseif (strlen($userPhone) == 9 && $userPhone[0] == "7") {
    $phoneNumber = "254" . $userPhone;
} else {
    $phoneNumber = $userPhone;
}

// =========================
// 3. SAVE ORDER BEFORE PAYMENT
// =========================
$order_ids = [];

foreach($cart as $product_id => $qty){

    $qty = (int)$qty;

    $res = $conn->query("SELECT price FROM products WHERE id=$product_id");
    $row = $res->fetch_assoc();

    $price = $row['price'] ?? 0;
    $total_item = $price * $qty;

    $conn->query("
        INSERT INTO orders (
            user_id,
            product_id,
            quantity,
            total_price,
            status
        ) VALUES (
            $user_id,
            $product_id,
            $qty,
            $total_item,
            'pending'
        )
    ");

    $order_ids[] = $conn->insert_id;
}

// =========================
// 4. M-PESA CREDENTIALS
// =========================
$consumerKey = 'YOUR_KEY';
$consumerSecret = 'YOUR_SECRET';
$shortCode = '174379';
$passkey = 'YOUR_PASSKEY';
$callbackURL = 'https://yourdomain.com/callback.php';

// AUTH
$credentials = base64_encode($consumerKey . ":" . $consumerSecret);

$ch = curl_init("https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic $credentials"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$tokenData = json_decode($response, true);
$accessToken = $tokenData['access_token'] ?? '';

// =========================
// 5. STK PUSH
// =========================
$timestamp = date('YmdHis');
$password = base64_encode($shortCode . $passkey . $timestamp);

$stkData = [
    "BusinessShortCode" => $shortCode,
    "Password" => $password,
    "Timestamp" => $timestamp,
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => $total,
    "PartyA" => $phoneNumber,
    "PartyB" => $shortCode,
    "PhoneNumber" => $phoneNumber,
    "CallBackURL" => $callbackURL,
    "AccountReference" => "BimasHub",
    "TransactionDesc" => "Order Payment"
];

$ch = curl_init("https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $accessToken"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($stkData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$stkResponse = curl_exec($ch);
$stkResponseData = json_decode($stkResponse, true);

// clear cart after saving
unset($_SESSION['cart']);
?>

<!-- =========================
UI PART (UNCHANGED STYLE)
========================= -->
<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<style>
body{font-family:Arial;background:#f5f5f5;display:flex;justify-content:center;align-items:center;height:100vh}
.box{background:white;padding:30px;border-radius:10px;text-align:center;width:400px}
.success{color:green;font-size:40px}
.fail{color:red;font-size:40px}
</style>
</head>
<body>

<div class="box">

<?php if(isset($stkResponseData['ResponseCode']) && $stkResponseData['ResponseCode']=="0"): ?>

<div class="success">✔</div>
<h2>Payment Sent</h2>
<p>M-Pesa prompt sent to <?= htmlspecialchars($phoneNumber) ?></p>
<h3>Total: KES <?= number_format($total) ?></h3>

<?php else: ?>

<div class="fail">✖</div>
<h2>Payment Failed</h2>
<p><?= $stkResponseData['errorMessage'] ?? 'Try again' ?></p>

<?php endif; ?>

<a href="services.php">Back</a>

</div>

</body>
</html>