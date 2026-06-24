<?php
session_start();
include "includes/db.php"; // Database connection

// --- PRICES ARRAY ---
$prices = [
    "Cement"=>1, "Sand"=>300, "Ballast"=>400, "Timber"=>1200, "Paints"=>800,
    "Plumbing materials"=>600, "Electrical supplies"=>700, "Desks"=>1500,
    "Office chairs"=>1200, "Filing cabinets"=>1000, "Printers"=>8000,
    "Photocopiers"=>15000, "Stationery"=>200, "School uniforms"=>1500,
    "Hospital uniforms"=>2000, "Corporate uniforms"=>1800, "Protective wear"=>1200,
    "Laptops"=>45000, "Desktops"=>40000, "Monitors"=>12000, "Keyboards"=>1500,
    "Networking devices"=>5000, "Maize"=>100, "Beans"=>120, "Rice"=>150,
    "Fruits"=>200, "Vegetables"=>150, "Milk"=>100,
    "Office cleaning"=>1000, "Home cleaning"=>1200, "Sanitization"=>1500,
    "Cleaning detergents supply"=>800,
    "Residential buildings"=>100000, "Commercial buildings"=>150000,
    "School construction"=>200000, "Hospital construction"=>250000,
    "Road construction"=>300000, "Road marking"=>50000,
    "Painting services"=>40000,
    "Solar panels"=>120000, "Installation"=>20000, "Maintenance"=>15000,
    "Inverters"=>35000, "Battery systems"=>25000, "Goods transport"=>5000,
    "Construction materials transport"=>7000, "Logistics services"=>6000,

    // ---------------- ROOFING FIX ----------------
    "SRT 880 Tile 2.5mm" => 1100,
    "SRT 880 Tile 3.0mm" => 1200,
    "ACT 920 Tile 2.5mm" => 1250,
    "ACT 920 Tile 2.8mm" => 1350,
    "ACT 920 Tile 3.0mm" => 1450,
    "S-ACT 1028 Tile 2.0mm" => 1000,
    "S-ACT 1028 Tile 2.5mm" => 1150,
    "S-ACT 1028 Tile 2.8mm" => 1300,
    "S-ACT 1028 Tile 3.0mm" => 1500,

    "Ridge Cap" => 500,
    "Hips" => 450,
    "Valleys" => 600,
    "Eaves" => 400,
    "Wall Flashing" => 550,
    "End Cap Ridge" => 300,
    "End Cap Hips" => 300,
    "Screws & Waterproof Caps" => 200,
];

// --- HANDLE UPDATE QUANTITIES ---
if(isset($_POST['update'])){
    foreach($_POST['quantities'] as $item_name => $qty){
        $qty = max(1, intval($qty));
        $_SESSION['cart'][$item_name] = $qty;
    }
}

// --- HANDLE REMOVE ITEM ---
if(isset($_POST['remove'])){
    $item_name = $_POST['remove'];
    unset($_SESSION['cart'][$item_name]);
}

// --- GET CART ---
$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Cart</title>
<style>
body{font-family:Arial;background:#f5f5f5;margin:0;}
.container{width:90%;margin:auto;padding:30px;}
h2{text-align:center;margin-bottom:30px;}
table{width:100%;border-collapse:collapse;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
th,td{padding:15px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#ff6f00;color:#fff;}
button{padding:6px 12px;background:#ff6f00;color:#fff;border:none;border-radius:5px;cursor:pointer;}
input[type=number]{width:50px;text-align:center;}
input[type=text]{padding:5px;width:200px;}
.top-bar{display:flex;justify-content:space-between;margin-bottom:20px;}
a{text-decoration:none;color:#ff6f00;font-weight:bold;}
.total-row td{font-weight:bold;font-size:18px;}
.checkout-btn{display:inline-block;margin-top:20px;padding:10px 20px;background:green;color:#fff;border-radius:5px;text-decoration:none;font-weight:bold;}
.qty-controls{display:flex;align-items:center;gap:5px;}
</style>
</head>
<body>
<div class="container">

<div class="top-bar">
    <a href="services.php">← Continue Shopping</a>
</div>

<h2>Your Shopping Cart</h2>

<?php if(count($cart) > 0): ?>
<form method="POST">
<table>
    <tr>
        <th>Item</th>
        <th>Quantity</th>
        <th>Unit Price (KES)</th>
        <th>Subtotal (KES)</th>
        <th>Remove</th>
    </tr>

    <?php 
    $total = 0;
    foreach($cart as $item_name => $qty): 
        $item_name = trim($item_name); // safety fix
        $price = $prices[$item_name] ?? 0;

        $qty = (int)$qty;
        $subtotal = $price * $qty;
        $total += $subtotal;
    ?>
    <tr>
        <td><?php echo htmlspecialchars($item_name); ?></td>
        <td>
            <div class="qty-controls">
                <button type="button" onclick="decrementQty('<?php echo $item_name; ?>')">-</button>
                <input type="number" name="quantities[<?php echo $item_name; ?>]" id="qty-<?php echo $item_name; ?>" value="<?php echo $qty; ?>" min="1">
                <button type="button" onclick="incrementQty('<?php echo $item_name; ?>')">+</button>
            </div>
        </td>
        <td><?php echo number_format($price); ?></td>
        <td><?php echo number_format($subtotal); ?></td>
        <td><button type="submit" name="remove" value="<?php echo $item_name; ?>">Remove</button></td>
    </tr>
    <?php endforeach; ?>

    <tr class="total-row">
        <td colspan="3">Total</td>
        <td colspan="2">KES <?php echo number_format($total); ?></td>
    </tr>
</table>

<div style="margin-top:20px;">
    <button type="submit" name="update">Update Quantities</button>
</div>
</form>

<h3>Proceed to Payment</h3>
<form action="checkout.php" method="POST">
    <input type="hidden" name="amount" value="<?php echo $total; ?>">
    <label>Enter your phone number (e.g., 2547XXXXXXXX): </label>
    <input type="text" name="phone" required>
    <button type="submit" class="checkout-btn">Pay KES <?php echo number_format($total); ?> via M-PESA</button>
</form>

<?php else: ?>
<p>Your cart is empty. <a href="services.php">Go shop!</a></p>
<?php endif; ?>

</div>

<script>
function incrementQty(item){
    let input = document.getElementById('qty-' + item);
    input.value = parseInt(input.value) + 1;
}
function decrementQty(item){
    let input = document.getElementById('qty-' + item);
    if(parseInt(input.value) > 1){
        input.value = parseInt(input.value) - 1;
    }
}
</script>

</body>
</html>