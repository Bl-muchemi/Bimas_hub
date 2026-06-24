<?php
session_start();
include "includes/db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: login.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard | Bimas Hub</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{margin:0;font-family:Arial;background:#f5f5f5}

.topbar{background:#000;color:#fff;padding:10px 30px;display:flex;justify-content:space-between}

header{background:#fff;padding:15px 30px;display:flex;justify-content:space-between;box-shadow:0 2px 8px #0001}

.logo{color:#ff6f00;font-size:22px;font-weight:bold}

.dashboard{display:flex}

.sidebar{width:220px;background:#333;color:#fff;min-height:100vh}

.sidebar a{display:block;padding:15px;color:#fff;text-decoration:none}

.sidebar a:hover{background:#ff6f00}

.main{flex:1;padding:30px}

.cards{display:grid;grid-template-columns:repeat(4,1fr);gap:15px;margin-bottom:25px}

.card{background:#fff;padding:20px;border-radius:8px;text-align:center;box-shadow:0 2px 10px #0001}
.card h3{color:#ff6f00;margin:0}

table{width:100%;background:#fff;border-collapse:collapse;margin-top:15px}

th,td{padding:10px;border-bottom:1px solid #ddd;text-align:left}
th{background:#f0f0f0}

h2{color:#ff6f00;margin-top:40px}

.status-paid{color:green;font-weight:bold}
.status-pending{color:orange;font-weight:bold}
.status-shipped{color:blue;font-weight:bold}

.btn{
padding:5px 10px;
border-radius:5px;
text-decoration:none;
font-size:12px;
margin-right:5px;
}

.btn-process{background:#ff9800;color:#fff}
.btn-ship{background:#2196F3;color:#fff}
.btn-deliver{background:#4CAF50;color:#fff}
</style>
</head>

<body>

<div class="topbar">
<span>🚚 Bimas Hub Admin</span>
<span>📞 +254 722 613 150</span>
</div>

<header>
<div class="logo">Bimas Hub</div>
<div>
<a href="index.php">Website</a> |
<a href="logout.php" style="color:red">Logout</a>
</div>
</header>

<div class="dashboard">

<!-- SIDEBAR -->
<div class="sidebar">
<a href="#dashboard"><i class="fa fa-home"></i> Dashboard</a>
<a href="#users"><i class="fa fa-users"></i> Users</a>
<a href="#products"><i class="fa fa-box"></i> Products</a>
<a href="#orders"><i class="fa fa-shopping-cart"></i> Orders</a>
<a href="#requests"><i class="fa fa-truck"></i> Requests</a>
</div>

<div class="main">

<?php
$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'] ?? 0;
$products = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'] ?? 0;
$orders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'] ?? 0;
$requests = $conn->query("SELECT COUNT(*) as total FROM supply_requests")->fetch_assoc()['total'] ?? 0;

$revenueData = $conn->query("SELECT SUM(total_price) as total FROM orders");
$revenue = $revenueData ? $revenueData->fetch_assoc()['total'] : 0;
?>

<!-- CARDS -->
<div class="cards">
<div class="card"><h3><?= $users ?></h3><p>Users</p></div>
<div class="card"><h3><?= $products ?></h3><p>Products</p></div>
<div class="card"><h3><?= $orders ?></h3><p>Orders</p></div>
<div class="card"><h3>KES <?= number_format($revenue ?? 0) ?></h3><p>Revenue</p></div>
</div>

<!-- USERS -->
<h2 id="users">Users</h2>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th></tr>

<?php
$res = $conn->query("SELECT * FROM users ORDER BY id DESC");
if($res){
while($row = $res->fetch_assoc()){
?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
</tr>
<?php }} ?>
</table>

<!-- PRODUCTS -->
<h2 id="products">Products</h2>
<table>
<tr><th>ID</th><th>Name</th><th>Price</th></tr>

<?php
$res = $conn->query("SELECT * FROM products ORDER BY id DESC");
if($res){
while($row = $res->fetch_assoc()){
?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['name']) ?></td>
<td>KES <?= number_format($row['price']) ?></td>
</tr>
<?php }} ?>
</table>

<!-- ORDERS -->
<h2 id="orders">Orders Management</h2>

<table>
<tr>
<th>Order ID</th>
<th>User</th>
<th>Product</th>
<th>Qty</th>
<th>Total</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$res = $conn->query("
SELECT o.*, u.name AS user_name, p.name AS product_name
FROM orders o
LEFT JOIN users u ON o.user_id = u.id
LEFT JOIN products p ON o.product_id = p.id
ORDER BY o.id DESC
");

if($res && $res->num_rows > 0){
while($row = $res->fetch_assoc()){
$status = $row['status'] ?? 'pending';
?>

<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['user_name'] ?? 'Unknown') ?></td>
<td><?= htmlspecialchars($row['product_name'] ?? 'N/A') ?></td>
<td><?= $row['quantity'] ?></td>
<td>KES <?= number_format($row['total_price']) ?></td>

<td>
<span class="
<?= $status=='paid'?'status-paid':'' ?>
<?= $status=='pending'?'status-pending':'' ?>
<?= $status=='shipped'?'status-shipped':'' ?>
">
<?= ucfirst($status) ?>
</span>
</td>

<td>
<a class="btn btn-process" href="update_order.php?id=<?= $row['id'] ?>&status=processing">Process</a>
<a class="btn btn-ship" href="update_order.php?id=<?= $row['id'] ?>&status=shipped">Ship</a>
<a class="btn btn-deliver" href="update_order.php?id=<?= $row['id'] ?>&status=delivered">Deliver</a>
</td>
</tr>

<?php }} else { ?>
<tr><td colspan="7">No orders yet</td></tr>
<?php } ?>
</table>

<!-- REQUESTS -->
<h2 id="requests">Supply Requests</h2>
<table>
<tr><th>Company</th><th>Phone</th><th>Product</th><th>Qty</th></tr>

<?php
$res = $conn->query("SELECT * FROM supply_requests ORDER BY id DESC");
if($res){
while($row = $res->fetch_assoc()){
?>
<tr>
<td><?= htmlspecialchars($row['company_name']) ?></td>
<td><?= htmlspecialchars($row['phone']) ?></td>
<td><?= htmlspecialchars($row['product']) ?></td>
<td><?= $row['quantity'] ?></td>
</tr>
<?php }} ?>
</table>

</div>
</div>

</body>
</html>