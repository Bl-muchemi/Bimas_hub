<?php
include "includes/db.php";

if(isset($_POST['submit'])){

$company = $_POST['company'];
$person = $_POST['person'];
$phone = $_POST['phone'];
$product = $_POST['product'];
$quantity = $_POST['quantity'];
$location = $_POST['location'];

$sql = "INSERT INTO supply_requests 
(company_name, contact_person, phone, product, quantity, delivery_location)
VALUES ('$company','$person','$phone','$product','$quantity','$location')";

if(mysqli_query($conn,$sql)){
    $message = "Request sent successfully!";
}else{
    $message = "Error sending request.";
}

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Employer Dashboard | Bimas Hub</title>

<style>

body{
font-family:Arial;
background:#f5f5f5;
margin:0;
}

header{
background:#fff;
padding:15px 40px;
box-shadow:0 2px 8px rgba(0,0,0,.1);
display:flex;
justify-content:space-between;
}

.logo{
font-size:24px;
font-weight:bold;
color:#ff6f00;
}

.container{
max-width:600px;
margin:40px auto;
background:#fff;
padding:30px;
border-radius:10px;
box-shadow:0 5px 10px rgba(0,0,0,0.1);
}

h2{
text-align:center;
margin-bottom:20px;
}

input,textarea{
width:100%;
padding:12px;
margin-bottom:15px;
border:1px solid #ccc;
border-radius:5px;
}

button{
background:#ff6f00;
color:white;
border:none;
padding:12px;
width:100%;
font-size:16px;
border-radius:5px;
cursor:pointer;
}

button:hover{
background:#e65c00;
}

.success{
background:#d4edda;
padding:10px;
margin-bottom:15px;
color:#155724;
border-radius:5px;
}

</style>

</head>

<body>

<header>
<div class="logo">Bimas Hub</div>
<a href="index.php">Home</a>
</header>

<div class="container">

<h2>Request Supplies</h2>

<?php
if(isset($message)){
echo "<div class='success'>$message</div>";
}
?>

<form method="POST">

<label>Company Name</label>
<input type="text" name="company" required>

<label>Contact Person</label>
<input type="text" name="person" required>

<label>Phone Number</label>
<input type="text" name="phone" required>

<label>Product Needed</label>
<input type="text" name="product" required>

<label>Quantity</label>
<input type="number" name="quantity" required>

<label>Delivery Location</label>
<textarea name="location" required></textarea>

<button name="submit">Submit Request</button>

</form>

</div>

</body>
</html>