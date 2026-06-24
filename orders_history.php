<?php
session_start();
include "includes/db.php";

$phone = $_GET['phone'] ?? '';
?>

<h2>My Orders</h2>

<form method="GET">
    <input type="text" name="phone" placeholder="Enter phone number">
    <button type="submit">View</button>
</form>

<?php
if($phone){

    $stmt = $conn->prepare("SELECT * FROM orders WHERE phone=? ORDER BY created_at DESC");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $orders = $stmt->get_result();

    while($order = $orders->fetch_assoc()){
        echo "<h3>Order #{$order['id']} - KES {$order['total_amount']} - {$order['status']}</h3>";

        $stmt2 = $conn->prepare("SELECT * FROM order_items WHERE order_id=?");
        $stmt2->bind_param("i", $order['id']);
        $stmt2->execute();
        $items = $stmt2->get_result();

        echo "<ul>";
        while($row = $items->fetch_assoc()){
            echo "<li>{$row['item_name']} x {$row['quantity']} (KES {$row['price']})</li>";
        }
        echo "</ul>";
    }
}
?>