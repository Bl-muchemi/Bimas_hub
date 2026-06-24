<<?php
include "includes/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us | Bimas Hub</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root{
  --primary:#ff6f00;
  --dark:#1f1f1f;
  --light:#f5f5f5;
}
*{box-sizing:border-box}
body{
  margin:0;
  font-family:'Segoe UI',sans-serif;
  background:var(--light);
  color:#333;
}
a{text-decoration:none;color:inherit}

/* TOP BAR */
.topbar{
  background:#000;
  color:#fff;
  padding:6px 40px;
  display:flex;
  justify-content:space-between;
  font-size:13px;
}

/* HEADER */
header{
  background:#fff;
  padding:15px 40px;
  display:flex;
  align-items:center;
  gap:20px;
  box-shadow:0 2px 8px rgba(0,0,0,.1);
}
.logo{
  font-size:26px;
  font-weight:800;
  color:var(--primary);
}
.search{
  flex:1;
}
.search input{
  width:100%;
  padding:12px;
  border-radius:6px;
  border:1px solid #ccc;
}
.icons a{
  margin-left:20px;
  font-weight:600;
}

/* NAV */
nav{
  background:var(--dark);
}
nav ul{
  list-style:none;
  display:flex;
  margin:0;
  padding:0 40px;
}
nav li a{
  color:#fff;
  padding:14px 18px;
  display:block;
}
nav li:hover, nav li a.active{
  background:var(--primary);
}

/* HERO */
.hero{
  background:linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)),
  url("https://images.unsplash.com/photo-1581092919537-6f06a1c8d1c2");
  background-size:cover;
  background-position:center;
  color:#fff;
  padding:60px 40px;
  text-align:center;
}
.hero h1{
  font-size:36px;
  max-width:700px;
  margin:auto;
}
.hero p{
  font-size:18px;
}

/* CONTACT FORM */
.contact-section{
  max-width:900px;
  margin:60px auto;
  background:#fff;
  padding:40px;
  border-radius:12px;
  box-shadow:0 4px 12px rgba(0,0,0,.1);
}
.contact-section h2{
  text-align:center;
  margin-bottom:25px;
  color:var(--primary);
}
.contact-form{
  display:flex;
  flex-direction:column;
  gap:15px;
}
.contact-form input,
.contact-form textarea{
  padding:12px;
  border:1px solid #ccc;
  border-radius:6px;
  font-size:15px;
  width:100%;
}
.contact-form button{
  padding:14px;
  background:var(--primary);
  color:#fff;
  border:none;
  border-radius:6px;
  cursor:pointer;
  font-size:16px;
}
.contact-form button:hover{
  background:#e65c00;
}

/* CONTACT INFO */
.contact-info{
  margin-top:40px;
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:20px;
}
.contact-info div{
  background:#f0f0f0;
  padding:20px;
  border-radius:8px;
}
.contact-info h3{
  margin-bottom:12px;
  color:var(--primary);
}

/* FOOTER */
footer{
  background:#111;
  color:#ccc;
  padding:40px;
}
.footer-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:30px;
}
footer h3{color:#fff}
.social a{
  font-size:22px;
  margin-right:15px;
  color:#fff;
}
</style>
</head>

<body>

<!-- TOP BAR -->
<div class="topbar">
  <span>🚚 Fast Delivery Across Kenya</span>
  <span>📞 +254 722 613 150</span>
</div>

<!-- HEADER -->
<header>
  <div class="logo">Bimas Hub</div>
  <div class="search">
    <input type="text" placeholder="Search products, brands and categories">
  </div>
  <div class="icons">
    <a href="#"><i class="fa fa-user"></i> Account</a>
    <a href="#"><i class="fa fa-shopping-cart"></i> Cart <span id="cart">0</span></a>
  </div>
</header>

<!-- NAVIGATION -->
<nav>
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="services.php">Categories</a></li>
    <li><a href="services.php">Products</a></li>
    <li><a href="shipping.php">Shipping</a></li>
    <li><a href="about.php">About Us</a></li>
    <li><a href="contact.php" class="active">Contact Us</a></li>
  </ul>
</nav>

<!-- HERO -->
<section class="hero">
  <h1>Contact Bimas Hub</h1>
  <p>We are here to answer your questions and help you with your orders</p>
</section>

<!-- CONTACT FORM SECTION -->
<section class="contact-section">
  <h2>Get in Touch</h2>
  <form class="contact-form" action="submit_contact.php" method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="text" name="subject" placeholder="Subject" required>
    <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
    <button type="submit">Send Message</button>
  </form>

  <div class="contact-info">
    <div>
      <h3>Our Office</h3>
      <p>123 Bimas Avenue, Nairobi, Kenya</p>
      <p>📞 +254 722 613 150</p>
      <p>✉️ support@bimashub.com</p>
    </div>
    <div>
      <h3>Follow Us</h3>
      <p><a href="#">Facebook</a></p>
      <p><a href="#">Instagram</a></p>
      <p><a href="#">TikTok</a></p>
    </div>
  </div>
</section>

<!-- FOOTER -->
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

</body>
</html>