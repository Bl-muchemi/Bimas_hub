<?php
session_start();
include "includes/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$page = $_GET['page'] ?? 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard | Bimas Hub</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{margin:0;font-family:Arial;background:#f5f5f5;}

.topbar{
background:#000;color:#fff;padding:10px 30px;
display:flex;justify-content:space-between;
}

header{
background:#fff;padding:15px 30px;
display:flex;justify-content:space-between;
box-shadow:0 2px 8px #0001;
}

.logo{color:#ff6f00;font-size:22px;font-weight:bold;}

.dashboard{display:flex;}

.sidebar{
width:220px;background:#333;min-height:100vh;
}

.sidebar a{
display:block;padding:15px;color:#fff;text-decoration:none;
}

.sidebar a:hover,.active{background:#ff6f00;}

.main{flex:1;padding:30px;}

.card{
background:#fff;padding:15px;margin-bottom:15px;
border-radius:8px;box-shadow:0 2px 10px #0001;
}

h2{color:#ff6f00;}

table{
width:100%;border-collapse:collapse;background:#fff;
}

th,td{
padding:10px;border-bottom:1px solid #ddd;text-align:left;
}

th{background:#eee;}

/* TIMELINE */
.timeline{
border-left:3px solid #ddd;
padding-left:15px;
margin-top:10px;
}

.step{
margin:10px 0;
color:#999;
font-size:14px;
}

.step.active{
color:#ff6f00;
font-weight:bold;
}
</style>
</head>

<body>

<div class="topbar">
<span>🚚 Bimas Hub User Panel</span>
<span>📞 +254 722 613 150</span>
</div>

<header>
<div class="logo">Bimas Hub</div>
<a href="logout.php" style="color:red;font-weight:bold;">Logout</a>
</header>

<div class="dashboard">

<!-- SIDEBAR -->
<div class="sidebar">

<a href="users.php?page=dashboard" class="<?= $page=='dashboard'?'active':'' ?>">
<i class="fa fa-home"></i> Dashboard
</a>

<a href="users.php?page=products" class="<?= $page=='products'?'active':'' ?>">
<i class="fa fa-box"></i> Products
</a>

<a href="users.php?page=messages" class="<?= $page=='messages'?'active':'' ?>">
<i class="fa fa-envelope"></i> Messages
</a>

<a href="users.php?page=orders" class="<?= $page=='orders'?'active':'' ?>">
<i class="fa fa-shopping-cart"></i> My Orders
</a>

</div>

<!-- MAIN -->
<div class="main">

<?php

/* ================= DASHBOARD ================= */
if($page == 'dashboard'){

    $orders = $conn->query("SELECT COUNT(*) as total FROM orders WHERE user_id=$user_id");
    $orderCount = ($orders) ? $orders->fetch_assoc()['total'] : 0;
?>

<h2>Dashboard</h2>
<div class="card">Welcome back 👋 to your ecommerce hub</div>
<div class="card">Total Orders: <b><?= $orderCount ?></b></div>

<?php
}

/* ================= PRODUCTS ================= */
elseif($page == 'products'){
?>

<h2>Products</h2>

<table>
<tr><th>Name</th><th>Price</th></tr>

<?php
$res = $conn->query("SELECT * FROM products ORDER BY id DESC");
if($res){
while($row = $res->fetch_assoc()){
?>
<tr>
<td><?= htmlspecialchars($row['name']) ?></td>
<td>KES <?= number_format($row['price']) ?></td>
</tr>
<?php }} ?>
</table>

<?php
}

/* ================= MESSAGES ================= */
elseif($page == 'messages'){
?>

<h2>Messages</h2>

<table>
<tr><th>Message</th><th>Date</th></tr>

<?php
$res = $conn->query("SELECT * FROM messages WHERE user_id=$user_id ORDER BY id DESC");

if($res && $res->num_rows > 0){
while($row = $res->fetch_assoc()){
?>
<tr>
<td><?= htmlspecialchars($row['message']) ?></td>
<td><?= $row['created_at'] ?></td>
</tr>
<?php }} else { ?>
<tr><td colspan="2">No messages yet</td></tr>
<?php } ?>
</table>

<?php
}

/* ================= ORDERS + LIVE TRACKING ================= */
elseif($page == 'orders'){
?>

<h2>My Orders Tracking </h2>

<?php
$res = $conn->query("SELECT * FROM orders WHERE user_id=$user_id ORDER BY id DESC");

if($res && $res->num_rows > 0){
while($row = $res->fetch_assoc()){
$status = $row['status'] ?? 'pending';
?>

<div class="card">
    <h3>Order #<?= $row['id'] ?></h3>

    <p>Status: <b><?= ucfirst($status) ?></b></p>

    <div class="timeline">

        <div class="step active">✔ Order Placed</div>

        <div class="step <?= in_array($status, ['processing','shipped','delivered']) ? 'active' : '' ?>">
            ⚙ Processing
        </div>

        <div class="step <?= in_array($status, ['shipped','delivered']) ? 'active' : '' ?>">
            🚚 Shipped
        </div>

        <div class="step <?= $status=='delivered' ? 'active' : '' ?>">
            📦 Delivered
        </div>

    </div>
</div>

<?php }} else { ?>
<div class="card">No orders yet</div>
<?php } ?>

<?php } ?>

</div>
</div>

</body>
</html>