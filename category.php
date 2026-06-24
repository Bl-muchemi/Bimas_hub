<?php
session_start();
include "includes/db.php";

// GET CATEGORY KEY FROM URL
$cat_key = isset($_GET['cat']) ? $_GET['cat'] : '';

// YOUR SERVICES ARRAY (same as in services.php)
$services = [
    "building_materials" => [
        "name"=>"Building Materials",
        "items"=>["Cement","Sand","Ballast","Timber","Paints","Plumbing materials","Electrical supplies"]
    ],
    "office_equipment" => [
        "name"=>"Office Equipment",
        "items"=>["Desks","Office chairs","Filing cabinets","Printers","Photocopiers","Stationery"]
    ],
    "uniforms" => [
        "name"=>"Uniforms",
        "items"=>["School uniforms","Hospital uniforms","Corporate uniforms","Protective wear"]
    ],
    "electronics" => [
        "name"=>"Electronics",
        "items"=>["Laptops","Desktops","Monitors","Keyboards","Networking devices"]
    ],
    "food_supplies" => [
        "name"=>"Food Supplies",
        "items"=>["Maize","Beans","Rice","Fruits","Vegetables","Milk"]
    ],
    "cleaning_services" => [
        "name"=>"Cleaning Services",
        "items"=>["Office cleaning","Home cleaning","Sanitization","Cleaning detergents supply"]
    ],
    "construction_building_works" => [
        "name"=>"Construction – Building Works",
        "items"=>["Residential buildings","Commercial buildings","School construction","Hospital construction"]
    ],
    "construction_road_works" => [
        "name"=>"Construction – Road Works",
        "items"=>["Road construction","Road marking","Painting services"]
    ],
    "construction_solar" => [
        "name"=>"Construction – Solar",
        "items"=>["Solar panels","Installation","Maintenance","Inverters","Battery systems"]
    ],
    "transport_services" => [
        "name"=>"Transport Services",
        "items"=>["Goods transport","Construction materials transport","Logistics services"]
    ]
];

// HANDLE ADD TO CART
if(isset($_POST['add'])){
    $item_name = trim($_POST['item_name']); // using name instead of database ID
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $item_name;
}

// CHECK IF CATEGORY EXISTS
if(!isset($services[$cat_key])){
    die("Invalid category selected.");
}

// GET CATEGORY INFO
$category = $services[$cat_key];
$category_name = $category['name'];
$items = $category['items'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $category_name; ?> Items</title>
<style>
body{font-family:Arial;background:#f5f5f5;margin:0;}
.container{width:90%;margin:auto;padding:30px;}
h2{text-align:center;margin-bottom:30px;}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;}
.card{background:#fff;padding:15px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.1);text-align:center;}
button{margin-top:10px;padding:8px 12px;background:#ff6f00;color:#fff;border:none;border-radius:5px;cursor:pointer;}
.top-bar{display:flex;justify-content:space-between;margin-bottom:20px;}
a{text-decoration:none;color:#ff6f00;font-weight:bold;}
</style>
</head>
<body>
<div class="container">
<div class="top-bar">
    <a href="services.php">← Back to Services</a>
    <a href="cart.php">🛒 View Cart</a>
</div>

<h2><?php echo $category_name; ?> - Available Items</h2>
<div class="grid">

<?php foreach($items as $item): ?>
    <div class="card">
        <h3><?php echo $item; ?></h3>
        <form method="POST">
            <input type="hidden" name="item_name" value="<?php echo $item; ?>">
            <button name="add">Add to Cart</button>
        </form>
    </div>
<?php endforeach; ?>

</div>
</div>
</body>
</html>