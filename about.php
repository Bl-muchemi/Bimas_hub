<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About Us | Bimas Enterprises Limited</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root{
  --primary:#ff6f00;
  --dark:#1c1c1c;
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
  background:linear-gradient(rgba(0,0,0,.65),rgba(0,0,0,.65)),
  url("https://images.unsplash.com/photo-1581092919537-6f06a1c8d1c2");
  background-size:cover;
  background-position:center;
  color:#fff;
  padding:90px 40px;
  text-align:center;
}
.hero h1{font-size:42px}

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
  margin-bottom:30px;
  box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.section h2{
  color:var(--primary);
  margin-bottom:15px;
}

ul{padding-left:20px}
li{margin-bottom:8px}

/* SERVICES GRID */
.grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
  gap:20px;
}

/* FOOTER */
footer{
  background:#111;
  color:#ccc;
  padding:40px;
}
.social a{
  color:#fff;
  font-size:22px;
  margin-right:15px;
}
</style>
</head>

<body>

<header>
  <div class="logo">Bimas Enterprises Ltd</div>
  <nav>
    <a href="index.html">Home</a>
    <a href="about.html">About Us</a>
    <a href="services.html">Services</a>
    <a href="contact.html">Contact</a>
  </nav>
</header>

<section class="hero">
  <h1>Company Profile</h1>
  <p>General Supplies • Construction • Transport Services</p>
</section>

<div class="container">

  <div class="section">
    <h2>About Us</h2>
    <p>
      <strong>BIMAS ENTERPRISES LIMITED</strong> is a Timber supplier, Building materials supplier,
      Transport services provider, General Supplies & Construction Company established in 2014.
      We have built a strong reputation for delivering quality services on time and at competitive prices.
    </p>
  </div>

  <div class="section">
    <h2>Vision</h2>
    <p>To become a leading One-Stop Supplier & Contractor in Kenya.</p>

    <h2>Mission</h2>
    <ul>
      <li>Provide good services to customers</li>
      <li>Ensure quality services</li>
      <li>Operate Quality Management Systems efficiently</li>
    </ul>
  </div>

  <div class="section">
    <h2>Core Values</h2>
    <ul>
      <li><strong>Professional:</strong> Integrity, honesty and ethical standards</li>
      <li><strong>Innovative:</strong> Solutions that stand the test of time</li>
      <li><strong>Client Focused:</strong> Customer satisfaction first</li>
    </ul>
  </div>

  <div class="section">
    <h2>Our Services</h2>
    <div class="grid">
      <div>
        <h3>General Supplies</h3>
        <ul>
          <li>Building materials</li>
          <li>Office stationery & furniture</li>
          <li>Staff uniforms</li>
          <li>Computers & accessories</li>
          <li>Food supplies</li>
        </ul>
      </div>

      <div>
        <h3>Cleaning Services</h3>
        <ul>
          <li>House & office cleaning</li>
          <li>Contract cleaning staff</li>
          <li>Supply of cleaning materials</li>
        </ul>
      </div>

      <div>
        <h3>Construction Services</h3>
        <ul>
          <li>Building & road works</li>
          <li>Water works</li>
          <li>Road marking & painting</li>
          <li>Residential & commercial projects</li>
        </ul>
      </div>

      <div>
        <h3>Transport Services</h3>
        <ul>
          <li>Light transport services</li>
          <li>Heavy transport services</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="section">
    <h2>Our Customers</h2>
    <ul>
      <li>Schools</li>
      <li>Government Institutions</li>
      <li>Hotels</li>
      <li>Construction Companies</li>
      <li>Banks & Supermarkets</li>
      <li>Health Institutions & Individuals</li>
    </ul>
  </div>

  <div class="section">
    <h2>Contact Information</h2>
    <p><strong>Phone:</strong> +254 722 613 150 | +254 799 870 629</p>
    <p><strong>Email:</strong> info@bimasenterprises.co.ke | bimasenterprise@gmail.com</p>
    <p><strong>Address:</strong> P.O Box 89468, 80100 Mombasa</p>

    <h3>Follow Us</h3>
    <div class="social">
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-tiktok"></i></a>
    </div>
    <p>@bimas_thrift</p>
  </div>

</div>

<footer>
  <p>© 2026 Bimas Enterprises Limited. All Rights Reserved.</p>
  <p><strong>Director:</strong> James Munene</p>
</footer>

</body>
</html>
