<!-- divya -->

<?php session_start(); ?>
<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "webdata";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$flight = null;
$success = false;

if (isset($_GET['flight_no']) && !empty($_GET['flight_no'])) {
    $flightNo = $_GET['flight_no'];

    $stmt = $conn->prepare("SELECT * FROM flights WHERE flight_no = ?");
    $stmt->bind_param("s", $flightNo);
    $stmt->execute();
    $result = $stmt->get_result();
    $flight = $result->fetch_assoc();
    $stmt->close();
}

// Handle booking form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    $flightNo = $_POST['flight_no'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $seat = $_POST['seat'];

    $stmt = $conn->prepare("INSERT INTO bookings (flight_no, name, email, gender, age, phone, seat) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssiss", $flightNo, $name, $email, $gender, $age, $phone, $seat);
        if ($stmt->execute()) {
            $success = true;
        } else {
            echo "Execute error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Prepare error: " . $conn->error;
    }
}
?>
  

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Book Your Flight - WingsBooking</title>
  <link rel="stylesheet" href="index.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
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
  <div class="user-menu dropdown">
    <button class="user-btn dropbtn">
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

<div class="container mt-5">
  <?php if ($success): ?>
    <script>
      Swal.fire("Success!", "Your flight is successfully booked!", "success");
    </script>
    <div class="alert alert-success text-center">Your flight is successfully booked!</div>
  <?php elseif ($flight): ?>
    <div class="bg-white p-4 shadow rounded">
      <h3 class="text-center mb-4">Flight Confirmation</h3>
      <table class="table table-bordered mb-4">
        <tr><th>Flight No</th><td><?= htmlspecialchars($flight['flight_no']) ?></td></tr>
        <tr><th>Airline</th><td><?= htmlspecialchars($flight['airline']) ?></td></tr>
        <tr><th>From</th><td><?= htmlspecialchars($flight['departure_city']) ?></td></tr>
        <tr><th>To</th><td><?= htmlspecialchars($flight['arrival_city']) ?></td></tr>
        <tr><th>Date</th><td><?= htmlspecialchars($flight['date']) ?></td></tr>
        <tr><th>Time</th><td><?= htmlspecialchars($flight['time']) ?></td></tr>
        <tr><th>Price</th><td>$<?= htmlspecialchars($flight['price']) ?></td></tr>
      </table>

      <h4 class="mb-3">Passenger Details</h4>
      <form method="post">
        <input type="hidden" name="flight_no" value="<?= htmlspecialchars($flight['flight_no']) ?>">
        <div class="row">
          <div class="col-md-6 mb-3"><input name="name" class="form-control" placeholder="Full Name" required></div>
          <div class="col-md-6 mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
          <div class="col-md-6 mb-3">
            <select name="gender" class="form-select" required>
              <option value="">Select Gender</option>
              <option>Male</option>
              <option>Female</option>
              <option>Other</option>
            </select>
          </div>
          <div class="col-md-3 mb-3"><input type="number" name="age" class="form-control" placeholder="Age" required></div>
          <div class="col-md-6 mb-3"><input type="text" name="phone" class="form-control" placeholder="Phone Number" required></div>
          <div class="col-md-6 mb-3"><input type="text" name="seat" class="form-control" placeholder="Seat No" required></div>
        </div>
        <div class="text-center">
          <button class="btn btn-success px-4" type="submit" name="confirm">Confirm Booking</button>
        </div>
      </form>
    </div>
  <?php else: ?>
    <div class="alert alert-danger text-center">Invalid flight selection. Please go back and select a flight.</div>
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

<script>
  function toggleMenu() {
    document.getElementById("navLinks").classList.toggle("show");
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
