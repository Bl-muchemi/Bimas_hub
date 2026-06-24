<?php
include 'includes/db.php';

if(isset($_GET['checkout_id'])){
    $checkoutID = $_GET['checkout_id'];
    $res = mysqli_query($conn,"SELECT * FROM mpesa_transactions WHERE checkout_request_id='$checkoutID'");
    $row = mysqli_fetch_assoc($res);
    echo "Service: ".$row['service']."<br>";
    echo "Amount: ".$row['amount']."<br>";
    echo "Phone: ".$row['phone']."<br>";
    echo "Status: ".$row['status']."<br>";
    echo "Receipt: ".$row['receipt'];
}
?>