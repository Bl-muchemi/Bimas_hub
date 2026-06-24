<?php
// Only include if you need database connection
// include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shipping Information | Bimas Enterprises Limited</title>

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

/* HEADER */
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

/* HERO */
.hero{
  background:linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)),
  url("https://images.unsplash.com/photo-1601584115197-04ecc0da31d7");
  background-size:cover;
  background-position:center;
  color:#fff;
  padding:80px 40px;
  text-align:center;
}
.hero h1{font-size:40px}

/* CONTENT */
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

/* GRID */
.grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
  gap:25px;
}

.card{
  background:#f9f9f9;
  padding:25px;
  border-radius:12px;
  text-align:center;
}
.card i{
  font-size:38px;
  color:var(--primary);
  margin-bottom:10px;
}

/* TABLE */
table{
  width:100%;
  border-collapse:collapse;
}
th,td{
  padding:12px;
  border-bottom:1px solid #ddd;
  text-align:left;
}
th{
  background:#f0f0f0;
}

/* FOOTER */
footer{
  background:#111;
  color:#ccc;
  padding:40px;
}
</style>
</head>

<body>

<!-- HEADER -->
<header>
  <div class="logo">Bimas Hub</div>
  <nav>
    <a href="index.php">Home</a>
    <a href="services.php">Services</a>
    <a href="shipping.php">Shipping</a>
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact</a>
  </nav>
</header>

<!-- HERO -->
<section class="hero">
  <h1>Shipping Information</h1>
  <p>Fast, Reliable & Affordable Delivery Across Kenya</p>
</section>

<div class="container">

  <div class="section">
    <h2>How Shipping Works</h2>
    <div class="grid">
      <div class="card">
        <i class="fa fa-cart-shopping"></i>
        <p>Customer places order through the Bimas Hub platform.</p>
      </div>
      <div class="card">
        <i class="fa fa-box"></i>
        <p>Order is confirmed and packed at our warehouse.</p>
      </div>
      <div class="card">
        <i class="fa fa-truck"></i>
        <p>Goods are dispatched using reliable transport.</p>
      </div>
      <div class="card">
        <i class="fa fa-location-dot"></i>
        <p>Delivery to customer’s specified location.</p>
      </div>
    </div>
  </div>

  <div class="section">
    <h2>Delivery Zones & Charges</h2>
    <table>
      <tr>
        <th>Location</th>
        <th>Estimated Time</th>
        <th>Delivery Fee</th>
      </tr>
      <tr>
        <td>Mombasa Town</td>
        <td>Same Day / Next Day</td>
        <td>KES 500</td>
      </tr>
      <tr>
        <td>South Coast & North Coast</td>
        <td>1 – 2 Days</td>
        <td>KES 800</td>
      </tr>
      <tr>
        <td>Other Counties</td>
        <td>2 – 4 Days</td>
        <td>Based on Distance</td>
      </tr>
    </table>
  </div>

  <div class="section">
    <h2>Payment Methods</h2>
    <div class="grid">
      <div class="card">
        <i class="fa fa-mobile-screen-button"></i>
        <p>M-Pesa payments accepted</p>
      </div>
      <div class="card">
        <i class="fa fa-credit-card"></i>
        <p>Visa & Mastercard payments</p>
      </div>
      <div class="card">
        <i class="fa fa-money-bill"></i>
        <p>Cash on Delivery (selected locations)</p>
      </div>
    </div>
  </div>

  <div class="section">
    <h2>Important Notes</h2>
    <ul>
      <li>Delivery charges may vary depending on order size and weight.</li>
      <li>Customers are notified before dispatch.</li>
      <li>Large construction materials may require special arrangements.</li>
      <li>Goods are checked before delivery to ensure quality.</li>
    </ul>
  </div>

</div>

<footer>
  <p><strong>Bimas Enterprises Limited</strong></p>
  <p>📞 +254 722 613 150 | +254 799 870 629</p>
  <p>📍 P.O Box 89468, 80100 Mombasa</p>
</footer>

</body>
</html>