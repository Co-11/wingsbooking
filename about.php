<!-- Divya -->

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us | WingsBooking</title>
  <link rel="stylesheet" href="index.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
      header nav {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 15px 30px;
  background-color: #002244;
  position: relative;
}

.logo {
  position: absolute;
  left: 30px;
  color: white;
  font-size: 24px;
  font-weight: bold;
}

.nav-links {
  list-style: none;
  display: flex;
  gap: 30px;
  margin: 0;
  padding: 0;
}

.nav-links li a {
  color: white;
  text-decoration: none;
  font-size: 16px;
  font-weight: 500;
}

.user-menu {
  position: absolute;
  right: 30px;
}

.user-btn {
  background-color: #007BFF;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  font-size: 15px;
  font-weight: bold;
  cursor: pointer;
  position: relative;
}

.user-btn:hover {
  background-color: #0056b3;
}

.dropdown-content {
  display: none;
  position: absolute;
  right: 0;
  background-color: white;
  min-width: 150px;
  top: 38px;
  border-radius: 5px;
  overflow: hidden;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
  z-index: 1000;
}

.dropdown-content a {
  display: block;
  padding: 10px 15px;
  text-decoration: none;
  color: #002244;
  font-weight: 500;
}

.dropdown-content a:hover {
  background-color: #f1f1f1;
}

.user-menu:hover .dropdown-content {
  display: block;
}

/* Mobile responsiveness */
@media screen and (max-width: 768px) {
  nav {
    flex-direction: column;
    align-items: flex-start;
  }

  .nav-links {
    flex-direction: column;
    background-color: #002244;
    width: 100%;
  }

  .logo, .user-menu {
    position: static;
    margin-bottom: 10px;
  }

  .user-menu {
    align-self: flex-end;
    margin-right: 30px;
  }

  .dropdown-content {
    position: static;
    box-shadow: none;
  }
}
  .about-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 40px 20px;
  color: #333;
}

.about-hero {
  text-align: center;
  padding: 40px 0 20px;
}

.about-hero h1 {
  font-size: 36px;
  color: #002244;
}

.about-hero p {
  font-size: 18px;
  color: #555;
}

.about-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 30px;
  margin-top: 40px;
}

.about-box {
  background-color: #f0f8ff;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.about-box h2 {
  color: #007BFF;
  margin-bottom: 10px;
}

.about-box p {
  font-size: 16px;
  line-height: 1.6;
}

footer {
  background-color: #002244;
  color: white;
  text-align: center;
  padding: 15px;
  margin-top: 50px;
}

  </style>
</head>
<body>

<!-- Header -->
<header>
  <nav>
    <div class="logo">WingsBooking</div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="flight.php">Flights</a></li>
      <li><a href="dashboard.php">My Bookings</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="about.php" class="active">About Us</a></li>
    </ul>

    <?php if (isset($_SESSION['email'])): ?>
      <div class="user-menu">
        <button class="user-btn">
          <?php echo $_SESSION['full_name']; ?> ▼
        </button>
        <div class="dropdown-content">
          <a href="dashboard.php">Dashboard</a>
          <a href="logout.php">Logout</a>
        </div>
      </div>
    <?php else: ?>
      <div class="user-menu">
        <a href="login.php" class="user-btn">Login</a>
        <a href="register.php" class="user-btn">Register</a>
      </div>
    <?php endif; ?>
  </nav>
</header>

<!-- About Section -->
<main class="about-container">
  <section class="about-hero">
    <h1>About WingsBooking</h1>
    <p>Your gateway to effortless travel planning and affordable flights.</p>
  </section>

  <section class="about-content">
    <div class="about-box">
      <h2>Who We Are</h2>
      <p>WingsBooking is your trusted flight booking partner offering affordable and reliable air travel services. We make booking flights easy for everyone.</p>
    </div>

    <div class="about-box">
      <h2>What We Do</h2>
      <p>We help travelers find and book the best flights across the globe. Our goal is to deliver a seamless travel booking experience through a user-friendly platform.</p>
    </div>

    <div class="about-box">
      <h2>Our Mission</h2>
      <p>To make air travel smooth, accessible, and enjoyable by offering best-in-class service, 24/7 support, and great deals on every flight booking.</p>
    </div>
  </section>
</main>

<footer style="background:#003366; color:#fff; padding:40px 20px; font-family: Arial, sans-serif; text-align:center;">
  <div style="max-width:1200px; margin:0 auto; display:flex; flex-wrap:wrap; justify-content:space-between; gap:20px;">
    <div style="flex:1; min-width:200px;">
      <h3 style="margin-bottom:15px; color: #ffcc00;">WingsBooking</h3>
      <p>Your trusted partner for seamless flight bookings worldwide.</p>
    </div>
    <div style="flex:1; min-width:150px;">
      <h4 style="margin-bottom:10px;">Quick Links</h4>
      <ul style="list-style:none; padding:0;">
        <li><a href="index.php" style="color:#fff; text-decoration:none;">Home</a></li>
        <li><a href="flight.php" style="color:#fff; text-decoration:none;">Flights</a></li>
        <li><a href="mybooking.php" style="color:#fff; text-decoration:none;">Booking</a></li>
        <li><a href="contact.php" style="color:#fff; text-decoration:none;">Contact</a></li>
         <li><a href="about.php" style="color:#fff; text-decoration:none;">About Us</a></li>
      </ul>
    </div>
    <div style="flex:1; min-width:200px;">
      <h4 style="margin-bottom:10px;">Contact Us</h4>
      <p>Email: support@wingsbooking.com</p>
      <p>Phone: +1 (800) 555-1234</p>
      <p>Address: 456 Aviation Blvd, Sky City</p>
    </div>
  </div>
  <div style="margin-top:30px; font-size:14px; color:#ccc;">
    &copy; 2025 WingsBooking. All rights reserved.
  </div>
</footer>

</body>
</html>
