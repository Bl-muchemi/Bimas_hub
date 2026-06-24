<?php
include "includes/db.php";

if(isset($_POST['submit'])){

$name = $_POST['name'];
$price = $_POST['price'];

$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

move_uploaded_file($tmp,"images/".$image);

$sql = "INSERT INTO products (name,price,image)
VALUES ('$name','$price','$image')";

if(mysqli_query($conn,$sql)){
echo "<script>alert('Product added successfully')</script>";
}
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Product | Bimas Hub</title>

<style>

body{
font-family:Arial;
background:#f5f5f5;
padding:40px;
}

.box{
background:white;
max-width:500px;
margin:auto;
padding:30px;
border-radius:8px;
}

input{
width:100%;
padding:12px;
margin-bottom:15px;
border:1px solid #ccc;
}

button{
background:#ff6f00;
color:white;
border:none;
padding:12px;
width:100%;
}

</style>

</head>

<body>

<div class="box">

<h2>Add Product</h2>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="name" placeholder="Product Name" required>

<input type="number" name="price" placeholder="Price" required>

<input type="file" name="image" required>

<button name="submit">Add Product</button>

</form>

</div>

</body>
</html>