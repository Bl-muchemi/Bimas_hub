<?php
session_start();
include "includes/db.php";

// --- HANDLE ADD TO CART ---
if(isset($_POST['add_to_cart'])){
    $item = $_POST['item_name'];
    $qty  = max(1, intval($_POST['qty']));

    if(isset($_SESSION['cart'][$item])){
        $_SESSION['cart'][$item] += $qty;
    } else {
        $_SESSION['cart'][$item] = $qty;
    }

    header("Location: services.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Our Services | Bimas Enterprises Limited</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root{
  --primary:#ff6f00;
  --dark:#1f1f1f;
  --light:#f5f5f5;
}

body{
  margin:0;
  font-family:'Segoe UI',sans-serif;
  background:var(--light);
  color:#333;
}

a{text-decoration:none;color:inherit}

header{
  background:#fff;
  padding:15px 40px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  box-shadow:0 2px 8px rgba(0,0,0,.1);
}

.logo{
  font-size:26px;
  font-weight:800;
  color:var(--primary);
}

nav a{
  margin-left:20px;
  font-weight:600;
}

nav a:hover{color:var(--primary)}

.hero{
  background:linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)),
  url("https://images.unsplash.com/photo-1503387762-592deb58ef4e");
  background-size:cover;
  background-position:center;
  color:#fff;
  padding:80px 40px;
  text-align:center;
}

.hero h1{font-size:40px}

.container{
  max-width:1200px;
  margin:auto;
  padding:50px 40px;
}

.section{
  background:#fff;
  padding:35px;
  border-radius:12px;
  margin-bottom:35px;
  box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.section h2{
  color:var(--primary);
  margin-bottom:20px;
}

.grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
  gap:25px;
}

.card{
  background:#f9f9f9;
  padding:15px;
  border-radius:12px;
  transition:.3s;
  text-align:center;
}

.card:hover{
  transform:translateY(-5px);
}

.card img{
  width:100%;
  height:200px;
  object-fit:contain;
  background:#fff;
  border-radius:10px;
  margin-bottom:10px;
}

.card i{
  font-size:30px;
  color:var(--primary);
  margin-bottom:10px;
}

.card ul{
  text-align:left;
  padding-left:18px;
  margin-top:10px;
}

.card ul li{
  margin-bottom:5px;
  font-size:14px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

/* ROOFING TWO COLUMN */
.roofing-wrap{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:20px;
  margin-top:15px;
  text-align:left;
}

.roof-box{
  background:#fff;
  padding:15px;
  border-radius:10px;
  box-shadow:0 2px 6px rgba(0,0,0,.05);
}

.roof-box h4{
  margin-bottom:10px;
  color:#444;
}

.btn, button{
  display:inline-block;
  margin-top:10px;
  padding:6px 12px;
  background:var(--primary);
  color:#fff;
  border-radius:5px;
  font-size:14px;
  border:none;
  cursor:pointer;
}

footer{
  background:#111;
  color:#ccc;
  padding:40px;
}

footer h3{color:#fff}
</style>
</head>

<body>

<header>
  <div class="logo">Bimas Hub</div>
  <nav>
    <a href="index.php">Home</a>
    <a href="services.php">Services</a>
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact</a>
    <a href="cart.php">Cart (<?php echo count($_SESSION['cart'] ?? []); ?>)</a>
  </nav>
</header>

<section class="hero">
  <h1>Our Services</h1>
  <p>Reliable • Professional • Affordable</p>
</section>

<div class="container">

<?php
$services = [

"Building Materials" => [
    "folder"=>"images/building_construction/",
    "icon"=>"fa fa-industry",
    "desc"=>"Building materials supply",
    "items"=>["Cement","Sand","Ballast","Timber","Paints","Plumbing materials","Electrical supplies"]
],

"Roofing Services" => [
    "folder"=>"images/roofing_sheets/",
    "icon"=>"fa fa-house",
    "desc"=>"Roofing sheets and accessories supply",
    "items"=>[
        "Roofing Sheets (Tiles)" => [
            "SRT 880 Tile 2.5mm",
            "SRT 880 Tile 3.0mm",
            "ACT 920 Tile 2.5mm",
            "ACT 920 Tile 2.8mm",
            "ACT 920 Tile 3.0mm",
            "S-ACT 1028 Tile 2.0mm",
            "S-ACT 1028 Tile 2.5mm",
            "S-ACT 1028 Tile 2.8mm",
            "S-ACT 1028 Tile 3.0mm"
        ],
        "Roofing Accessories" => [
            "Ridge Cap",
            "Hips",
            "Valleys",
            "Eaves",
            "Wall Flashing",
            "End Cap Ridge",
            "End Cap Hips",
            "Screws & Waterproof Caps"
        ]
    ]
],

"Office Equipment" => [
    "folder"=>"images/office_equipment/",
    "icon"=>"fa fa-chair",
    "desc"=>"Office equipment supply",
    "items"=>["Desks","Office chairs","Filing cabinets","Printers","Photocopiers","Stationery"]
],

"Uniforms" => [
    "folder"=>"images/uniforms/",
    "icon"=>"fa fa-shirt",
    "desc"=>"Uniform supply",
    "items"=>["School uniforms","Hospital uniforms","Corporate uniforms","Protective wear"]
],

"Electronics" => [
    "folder"=>"images/electronics/",
    "icon"=>"fa fa-laptop",
    "desc"=>"Electronics supply",
    "items"=>["Laptops","Desktops","Monitors","Keyboards","Networking devices"]
],

"Food Supplies" => [
    "folder"=>"images/food/",
    "icon"=>"fa fa-basket-shopping",
    "desc"=>"Food supply",
    "items"=>["Maize","Beans","Rice","Fruits","Vegetables","Milk"]
],

"Cleaning Services" => [
    "folder"=>"images/cleaning_services/",
    "icon"=>"fa fa-broom",
    "desc"=>"Cleaning services",
    "items"=>["Office cleaning","Home cleaning","Sanitization","Cleaning detergents supply"]
],

"Construction – Building Works" => [
    "folder"=>"images/building_construction/",
    "icon"=>"fa fa-city",
    "desc"=>"Construction services",
    "items"=>["Residential buildings","Commercial buildings","School construction","Hospital construction"]
],

"Construction – Road Works" => [
    "folder"=>"images/road_construction/",
    "icon"=>"fa fa-road",
    "desc"=>"Road construction services",
    "items"=>["Road construction","Road marking","Painting services"]
],

"Construction – Solar" => [
    "folder"=>"images/solars/",
    "icon"=>"fa fa-solar-panel",
    "desc"=>"Solar installation",
    "items"=>["Solar panels","Installation","Maintenance","Inverters","Battery systems"]
],

"Transport Services" => [
    "folder"=>"images/transport_services/",
    "icon"=>"fa fa-truck",
    "desc"=>"Transport services",
    "items"=>["Goods transport","Construction materials transport","Logistics services"]
],

];

foreach($services as $title => $info){

    $key = strtolower(str_replace([' ', '–'], '_', $title));

    echo '<div class="section">';
    echo '<h2><a href="category.php?cat='.$key.'">'.$title.'</a></h2>';
    echo '<div class="grid">';

    $images = glob($info['folder']."*.{jpg,png,jpeg,gif}", GLOB_BRACE);

    if(count($images) > 0){
        foreach($images as $img){

            echo '<div class="card">';
            echo '<img src="'.$img.'" alt="'.$title.'">';
            echo '<i class="'.$info['icon'].'"></i>';
            echo '<p>'.$info['desc'].'</p>';

            echo '<ul>';

            if($title == "Roofing Services"){

                echo "<div class='roofing-wrap'>";

                foreach($info['items'] as $group => $groupItems){

                    echo "<div class='roof-box'>";
                    echo "<h4>$group</h4>";

                    foreach($groupItems as $item){
                        echo "<li>
                                $item
                                <form method='POST' style='display:inline-block;margin-left:10px;'>
                                    <input type='hidden' name='item_name' value='$item'>
                                    <input type='number' name='qty' value='1' min='1' style='width:50px;'>
                                    <button type='submit' name='add_to_cart'>Add</button>
                                </form>
                              </li>";
                    }

                    echo "</div>";
                }

                echo "</div>";

            } else {

                foreach($info['items'] as $group => $groupItems){

                    if(is_array($groupItems)){
                        echo "<h4 style='margin-top:10px;color:#444;'>$group</h4>";

                        foreach($groupItems as $item){
                            echo "<li>
                                    $item
                                    <form method='POST' style='display:inline-block;margin-left:10px;'>
                                        <input type='hidden' name='item_name' value='$item'>
                                        <input type='number' name='qty' value='1' min='1' style='width:50px;'>
                                        <button type='submit' name='add_to_cart'>Add</button>
                                    </form>
                                  </li>";
                        }

                    } else {
                        echo "<li>
                                $groupItems
                                <form method='POST' style='display:inline-block;margin-left:10px;'>
                                    <input type='hidden' name='item_name' value='$groupItems'>
                                    <input type='number' name='qty' value='1' min='1' style='width:50px;'>
                                    <button type='submit' name='add_to_cart'>Add</button>
                                </form>
                              </li>";
                    }
                }
            }

            echo '</ul>';
            echo '<a href="category.php?cat='.$key.'" class="btn">View Items</a>';
            echo '</div>';
        }
    }

    echo '</div></div>';
}
?>

</div>

<footer>
  <h3>Bimas Enterprises Limited</h3>
  <p>Quality services delivered on time and at competitive prices.</p>
  <p>📞 +254 722 613 150 | +254 799 870 629</p>
</footer>

</body>
</html>
