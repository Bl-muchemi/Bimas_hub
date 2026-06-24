<?php

include "includes/db.php";

$id = $_GET['id'];

$sql = "DELETE FROM products WHERE id='$id'";

mysqli_query($conn,$sql);

header("Location: admin.php");

?>