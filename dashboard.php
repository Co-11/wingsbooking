<!-- divya -->


<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$database = "webdata";
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$email = $_SESSION['email'];

// Only get bookings for the logged-in user
$sql = "
    SELECT b.*, f.airline, f.departure_city, f.arrival_city, f.date, f.time, f.price 
    FROM bookings b
    JOIN flights f ON b.flight_no = f.flight_no
    WHERE b.email = ?
    ORDER BY b.id DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Bookings - WingsBooking</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
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

  </style>
</head>
<body>

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

<div class="container booking-table">
  <h2 class="text-center mb-4">My Booked Flights</h2>

  <?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Flight No</th>
          <th>Airline</th>
          <th>From</th>
          <th>To</th>
          <th>Date</th>
          <th>Time</th>
          <th>Price</th>
          <th>Seat</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['flight_no']) ?></td>
            <td><?= htmlspecialchars($row['airline']) ?></td>
            <td><?= htmlspecialchars($row['departure_city']) ?></td>
            <td><?= htmlspecialchars($row['arrival_city']) ?></td>
            <td><?= htmlspecialchars($row['date']) ?></td>
            <td><?= htmlspecialchars($row['time']) ?></td>
            <td>$<?= htmlspecialchars($row['price']) ?></td>
            <td><?= htmlspecialchars($row['seat']) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info text-center">You have no bookings yet.</div>
  <?php endif; ?>
</div>

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
