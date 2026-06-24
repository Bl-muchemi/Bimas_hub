<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "bimas_hub";

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bimas Hub | General Supplies & Construction</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root{--primary:#ff6f00;--dark:#1f1f1f;--light:#f5f5f5;}
*{box-sizing:border-box;}
body{margin:0;font-family:'Segoe UI',sans-serif;background:var(--light);color:#333;}
a{text-decoration:none;color:inherit;}
.topbar{background:#000;color:#fff;padding:6px 40px;display:flex;justify-content:space-between;font-size:13px;}
header{background:#fff;padding:15px 40px;display:flex;align-items:center;gap:20px;box-shadow:0 2px 8px rgba(0,0,0,.1);position:relative;}
.logo{font-size:26px;font-weight:800;color:var(--primary);}
.search{flex:1;}
.search input{width:100%;padding:12px;border-radius:6px;border:1px solid #ccc;}
.icons a{margin-left:20px;font-weight:600;position:relative;}
.icons div{display:inline-block;position:relative;}
.dropdown{position:absolute;top:35px;left:0;background:#fff;color:#333;min-width:140px;border-radius:6px;box-shadow:0 4px 8px rgba(0,0,0,.1);display:none;z-index:10;}
.dropdown a{display:block;padding:10px 15px;color:#333;}
.dropdown a:hover{background:var(--primary);color:#fff;}
nav{background:var(--dark);}
nav ul{list-style:none;display:flex;margin:0;padding:0 40px;}
nav li a{color:#fff;padding:14px 18px;display:block;}
nav li:hover, nav li a.active{background:var(--primary);}
.hero{height:100vh;background:linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('images/company_profile.png') no-repeat center center;background-size:cover;display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;color:#fff;}
.hero h1{font-size:48px;max-width:800px;margin:0 auto 20px;}
.hero p{font-size:20px;margin-bottom:30px;}
.hero button{background:var(--primary);border:none;padding:16px 32px;font-size:18px;color:#fff;border-radius:6px;cursor:pointer;transition:0.3s;}
.hero button:hover{background:#e65c00;}
.section{padding:60px 40px;}
.section h2{margin-bottom:25px;text-align:center;}
.categories{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;}
.cat{background:#fff;padding:25px;border-radius:12px;text-align:center;box-shadow:0 4px 12px rgba(0,0,0,.1);transition:.3s;}
.cat:hover{transform:translateY(-6px);}
.cat i{font-size:40px;color:var(--primary);margin-bottom:10px;}
.products{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;}
.product{background:#fff;padding:20px;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,.1);}
.product button{background:var(--primary);border:none;width:100%;padding:10px;color:#fff;border-radius:6px;cursor:pointer;}
.shipping{background:#fff;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-top:30px;}
.ship-box{padding:25px;border-radius:12px;background:#f0f0f0;text-align:center;font-weight:600;}
footer{background:#111;color:#ccc;padding:40px;margin-top:30px;}
.footer-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:30px;}
footer h3{color:#fff;}
.social a{font-size:22px;margin-right:15px;color:#fff;}

/* Chatbot button */
#chatbot-btn{position:fixed;bottom:20px;right:20px;background:var(--primary);color:#fff;padding:15px 20px;border-radius:50%;font-size:24px;cursor:pointer;z-index:1000;}
#chatbot-box{position:fixed;bottom:80px;right:20px;width:300px;max-height:400px;background:#fff;border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,0.3);display:none;flex-direction:column;overflow:hidden;z-index:1000;}
#chatbot-box .chat-header{background:var(--primary);color:#fff;padding:10px;text-align:center;font-weight:bold;}
#chatbot-box .chat-content{flex:1;padding:10px;overflow-y:auto;}
#chatbot-box .chat-content p{margin:5px 0;padding:8px;border-radius:5px;}
.user-msg{background:var(--primary);color:#fff;text-align:right;}
.bot-msg{background:#eee;color:#000;text-align:left;}
#chatbot-box form{display:flex;border-top:1px solid #ddd;}
#chatbot-box input{flex:1;padding:8px;border:none;}
#chatbot-box button{padding:8px;background:var(--primary);color:#fff;border:none;cursor:pointer;}
</style>
</head>
<body>

<div class="topbar">
  <span>🚚 Fast Delivery Across Kenya</span>
  <span>📞 +254 722 613 150</span>
</div>

<header>
  <div class="logo">Bimas Hub</div>
  <div class="search"><input type="text" placeholder="Search products, brands and categories"></div>
  <div class="icons">
    <a href="admin.php"><i class="fa fa-user-shield"></i> Admin</a>
    <div>
      <a href="#"><i class="fa fa-user"></i> Account <i class="fa fa-caret-down"></i></a>
      <div class="dropdown">
        <a href="users.php">User Dashboard</a>
        <a href="employer.php">Employer Dashboard</a>
      </div>
    </div>
    <a href="cart.php"><i class="fa fa-shopping-cart"></i> Cart <span id="cart">0</span></a>
  </div>
</header>

<nav>
  <ul>
    <li><a href="index.php" class="active">Home</a></li>
    <li><a href="services.php">Categories</a></li>
    <li><a href="services.php">Products</a></li>
    <li><a href="shipping.php">Shipping</a></li>
    <li><a href="about.php">About Us</a></li>
    <li><a href="contact.php">Contact Us</a></li>
  </ul>
</nav>

<section class="hero">
  <h1>Bimas Enterprises Limited</h1>
  <p>Your One-Stop Supplier for General Supplies & Construction</p>
  <button onclick="location.href='services.php'">Our Services</button>
</section>

<section class="section">
  <h2>Shop by Category</h2>
  <div class="categories">
    <div class="cat"><i class="fa fa-hammer"></i><h4>Construction</h4></div>
    <div class="cat"><i class="fa fa-bolt"></i><h4>Electrical</h4></div>
    <div class="cat"><i class="fa fa-faucet"></i><h4>Plumbing</h4></div>
    <div class="cat"><i class="fa fa-car"></i><h4>Transport</h4></div>
  </div>
</section>

<section class="section">
  <h2>Popular Products</h2>
  <div class="products">
  <?php
  $sql = "SELECT * FROM products";
  $result = mysqli_query($conn, $sql);
  if(!$result) { die("Query failed: " . mysqli_error($conn)); }
  if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
          echo "<div class='product'>";
          echo "<h4>".htmlspecialchars($row['name'])."</h4>";
          echo "<p>KES ".number_format($row['price'])."</p>";
          echo "<form method='post' action='add_to_cart.php'>";
          echo "<input type='hidden' name='product_id' value='".$row['id']."'>";
          echo "<button type='submit'>Add to Cart</button>";
          echo "</form>";
          echo "</div>";
      }
  } else {
      echo "<p>No products found.</p>";
  }
  ?>
  </div>
</section>

<section class="section">
  <h2>Shipping & Payments</h2>
  <div class="shipping">
    <div class="ship-box">🚚 1–3 Days Delivery</div>
    <div class="ship-box">📦 Nationwide Coverage</div>
    <div class="ship-box">📱 M-Pesa Payments</div>
    <div class="ship-box">💳 Visa & Mastercard</div>
  </div>
</section>

<footer>
  <div class="footer-grid">
    <div>
      <h3>Bimas Enterprises Ltd</h3>
      <p>Trusted supplier of quality goods and construction services.</p>
    </div>
    <div>
      <h3>Quick Links</h3>
      <p><a href="about.php">About Us</a></p>
      <p><a href="services.php">Services</a></p>
      <p><a href="contact.php">Contact</a></p>
      <p><a href="shipping.php">Shipping</a></p>
      <p><a href="admin.php">Admin</a></p>
    </div>
    <div>
      <h3>Follow Us</h3>
      <div class="social">
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-tiktok"></i></a>
      </div>
      <p>@bimas_thrift</p>
    </div>
  </div>
</footer>

<!-- Chatbot -->
<div id="chatbot-btn"><i class="fa fa-robot"></i></div>
<div id="chatbot-box">
  <div class="chat-header">Bimas Hub Chatbot</div>
  <div class="chat-content" id="chat-content"></div>
  <form id="chat-form">
      <input type="text" id="chat-input" placeholder="Ask me anything..." required>
      <button type="submit">Send</button>
  </form>
</div>

<script>
const account = document.querySelector('.icons div');
const dropdown = account.querySelector('.dropdown');
account.addEventListener('mouseenter', () => dropdown.style.display = 'block');
account.addEventListener('mouseleave', () => dropdown.style.display = 'none');

let count = 0;
function add() {
  count++;
  document.getElementById("cart").innerText = count;
  alert("Product added to cart");
}

// Chatbot toggle
const chatBtn = document.getElementById('chatbot-btn');
const chatBox = document.getElementById('chatbot-box');
chatBtn.addEventListener('click', ()=> {
    chatBox.style.display = chatBox.style.display === 'flex' ? 'none' : 'flex';
});

// Chatbot message sending
const chatForm = document.getElementById('chat-form');
const chatInput = document.getElementById('chat-input');
const chatContent = document.getElementById('chat-content');

chatForm.addEventListener('submit', async function(e){
    e.preventDefault();
    const msg = chatInput.value.trim();
    if(msg === '') return;

    // display user message
    const userP = document.createElement('p');
    userP.className = 'user-msg';
    userP.textContent = msg;
    chatContent.appendChild(userP);
    chatContent.scrollTop = chatContent.scrollHeight;

    // send to chatbot.php
    const res = await fetch('chatbot.php', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'message='+encodeURIComponent(msg)
    });
    const data = await res.json();

    const botP = document.createElement('p');
    botP.className = 'bot-msg';
    botP.textContent = data.reply;
    chatContent.appendChild(botP);
    chatContent.scrollTop = chatContent.scrollHeight;

    chatInput.value = '';
});
</script>

</body>
</html>