<?php
include "includes/db.php";

if(!isset($_GET['id']) || !isset($_GET['status'])){
    die("Invalid request");
}

$id = intval($_GET['id']);
$status = $_GET['status'];

$allowed = ['pending','processing','shipped','delivered','cancelled'];

if(!in_array($status, $allowed)){
    die("Invalid status");
}

$conn->query("UPDATE orders SET status='$status' WHERE id=$id");

header("Location: admin.php#orders");
exit();