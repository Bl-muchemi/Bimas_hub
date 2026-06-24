<?php
session_start();

// INIT
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// PRICES
$prices = [
"Cement"=>1,"Sand"=>300,"Ballast"=>400,"Timber"=>1200,"Paints"=>800,
"Plumbing materials"=>600,"Electrical supplies"=>700,
"Desks"=>1500,"Office chairs"=>1200,"Filing cabinets"=>1000,
"Printers"=>8000,"Photocopiers"=>15000,"Stationery"=>200,
"School uniforms"=>1500,"Hospital uniforms"=>2000,"Corporate uniforms"=>1800,"Protective wear"=>1200,
"Laptops"=>45000,"Desktops"=>40000,"Monitors"=>12000,"Keyboards"=>1500,"Networking devices"=>5000,
"Maize"=>100,"Beans"=>120,"Rice"=>150,"Fruits"=>200,"Vegetables"=>150,"Milk"=>100,
"Office cleaning"=>1000,"Home cleaning"=>1200,"Sanitization"=>1500,"Cleaning detergents supply"=>800,
"Residential buildings"=>100000,"Commercial buildings"=>150000,
"School construction"=>200000,"Hospital construction"=>250000,
"Road construction"=>300000,"Road marking"=>50000,"Painting services"=>40000,
"Solar panels"=>120000,"Installation"=>20000,"Maintenance"=>15000,"Inverters"=>35000,"Battery systems"=>25000,
"Goods transport"=>5000,"Construction materials transport"=>7000,"Logistics services"=>6000,

"SRT 880 Tile 2.5mm"=>1150,"SRT 880 Tile 3.0mm"=>1500,
"ACT 920 Tile 2.5mm"=>1150,"ACT 920 Tile 2.8mm"=>1500,"ACT 920 Tile 3.0mm"=>1800,
"S-ACT 1028 Tile 2.0mm"=>1050,"S-ACT 1028 Tile 2.5mm"=>1500,
"S-ACT 1028 Tile 2.8mm"=>1900,"S-ACT 1028 Tile 3.0mm"=>2200,
"Ridge Cap"=>742,"Hips"=>650,"Valleys"=>650,"Eaves"=>504,
"Wall Flashing"=>650,"End Cap Ridge"=>540,"End Cap Hips"=>540,"Screws & Waterproof Caps"=>15
];

// REMOVE
if(isset($_POST['remove'])){
    $item = trim($_POST['remove']);
    unset($_SESSION['cart'][$item]);
    header("Location: add_to_cart.php");
    exit;
}

// UPDATE
if(isset($_POST['update'])){
    foreach($_POST['qty'] as $item=>$qty){
        $item = trim($item);
        $_SESSION['cart'][$item] = max(1,(int)$qty);
    }
    header("Location: add_to_cart.php");
    exit;
}

$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Cart</title>
<style>
body{font-family:Arial;background:#f5f5f5;}
.container{width:90%;margin:auto;}
table{width:100%;background:#fff;border-collapse:collapse;}
th,td{padding:10px;border-bottom:1px solid #ddd;}
th{background:#ff6f00;color:#fff;}
input{width:60px;}
button{cursor:pointer;}
</style>
</head>

<body>

<div class="container">
<h2>Your Shopping Cart</h2>

<?php if($cart): ?>
<form method="POST">
<table>
<tr>
<th>Item</th>
<th>Qty</th>
<th>Unit Price (KES)</th>
<th>Subtotal (KES)</th>
<th>Remove</th>
</tr>

<?php
$total=0;

foreach($cart as $item=>$qty):

$item = trim($item);

if(!isset($prices[$item])) continue;

$price=$prices[$item];
$sub=$price*$qty;
$total+=$sub;
?>

<tr>
<td><?php echo htmlspecialchars($item); ?></td>
<td>
<input type="number" name="qty[<?php echo htmlspecialchars($item); ?>]" value="<?php echo $qty; ?>" min="1">
</td>
<td><?php echo number_format($price); ?></td>
<td><?php echo number_format($sub); ?></td>
<td>
<button name="remove" value="<?php echo htmlspecialchars($item); ?>">X</button>
</td>
</tr>

<?php endforeach; ?>

<tr>
<th colspan="3">Total</th>
<th colspan="2">KES <?php echo number_format($total); ?></th>
</tr>

</table>

<br>
<button name="update">Update Cart</button>
</form>

<?php else: ?>
<p>Cart is empty</p>
<?php endif; ?>

</div>

</body>
</html>