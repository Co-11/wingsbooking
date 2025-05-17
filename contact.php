<!-- divya -->
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - WingsBooking</title>
      <link rel="stylesheet" href="index.css">
      <style>
        .con-body{
  background-color: #003366;
}
.contact-section {
  max-width: 700px;
  margin: 4rem auto;
  padding: 2rem;
  background-color: #f9fbff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.contact-section h1 {
  font-size: 2rem;
  color: #003366;
  margin-bottom: 1rem;
}

.contact-section p {
  font-size: 1rem;
  color: #444;
  margin-bottom: 2rem;
}

.contact-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  border: px solid black;
}

.contact-form input,
.contact-form textarea {
  padding: 1rem;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  width: 100%;
  box-sizing: border-box;
  resize: vertical;
}

.contact-form textarea {
  min-height: 120px;
}

.contact-form button {
  padding: 0.8rem;
  background-color: #003366;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.3s ease;
}

.contact-form button:hover {
  background-color: #002244;
}

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


  </style>
</head>
<body>


  <script>
  function toggleMenu() {
    document.getElementById('navLinks').classList.toggle('active');
  }
</script>

<!-- HEADER NAVBAR -->
  <!-- HEADER (responsive nav) -->

<header>
  <nav>
    <div class="logo">WingsBooking</div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="flight.php">Flights</a></li>
      <li><a href="dashboard.php">My Bookings</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="about.php">About Us</a></li>
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
   <section class="contact-section">
  <h1>Contact Us</h1>
  <p>If you have any questions about flight bookings, please reach out to us below.</p>

  <form class="contact-form">
    <input type="text" placeholder="Your Full Name" required />
    <input type="email" placeholder="Your Email Address" required />
    <textarea placeholder="Your Message" required></textarea>
    <button type="submit">Send Message</button>
  </form>
</section>


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
