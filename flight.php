  <!-- divya -->

  
  <?php
  // Start the session only if it hasn't been started already
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  $host = "localhost";
  $username = "root";
  $password = "";
  $database = "webdata";
  $conn = new mysqli($host, $username, $password, $database);
  if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

  $departureFlights = [];
  $returnFlights = [];
  $search = false;

  function fetchFlights($conn, $departure = '', $arrival = '', $type = '', $tripType = '', $date = '', $airline = '') {
      $query = "SELECT * FROM flights WHERE 1=1";
      $params = [];
      $types = '';

      if ($departure) { $query .= " AND departure_city = ?"; $params[] = $departure; $types .= 's'; }
      if ($arrival) { $query .= " AND arrival_city = ?"; $params[] = $arrival; $types .= 's'; }
      if ($type) { $query .= " AND type = ?"; $params[] = $type; $types .= 's'; }
      if ($tripType) { $query .= " AND trip_type = ?"; $params[] = $tripType; $types .= 's'; }
      if ($date) { $query .= " AND date = ?"; $params[] = $date; $types .= 's'; }
      if ($airline) { $query .= " AND airline = ?"; $params[] = $airline; $types .= 's'; }

      $stmt = $conn->prepare($query);
      if ($params) $stmt->bind_param($types, ...$params);
      $stmt->execute();
      $result = $stmt->get_result();
      $flights = [];

      while ($row = $result->fetch_assoc()) {
          $booked = $conn->prepare("SELECT COUNT(*) as count FROM bookings WHERE flight_no = ?");
          $booked->bind_param("s", $row['flight_no']);
          $booked->execute();
          $count = $booked->get_result()->fetch_assoc()['count'];
          $booked->close();
          if ($count < 5) $flights[] = $row;
      }
      $stmt->close();
      return $flights;
  }

  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'search') {
      $departure = $_POST['departure'] ?? '';
      $arrival = $_POST['arrival'] ?? '';
      $type = $_POST['flight_type'] ?? '';
      $tripType = $_POST['trip_type'] ?? 'one-way';
      $date = $_POST['date'] ?? '';
      $returnDate = $_POST['return_date'] ?? '';
      $airline = $_POST['airline'] ?? '';

      $departureFlights = fetchFlights($conn, $departure, $arrival, $type, $tripType, $date, $airline);
      if ($tripType === 'round-trip' && $returnDate) {
          $returnFlights = fetchFlights($conn, $arrival, $departure, $type, $tripType, $returnDate, $airline);
      }
      $search = true;
  } else {
      $departureFlights = fetchFlights($conn);
  }
  ?>


  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Book Your Flight - WingsBooking</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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


  <!-- FLIGHT SEARCH FORM -->
  <div class="container my-5 pt-5">
    <div class="bg-white p-4 shadow rounded">
      <h2 class="text-center mb-4">Search Flights</h2>
      <form method="post">
        <input type="hidden" name="action" value="search">
        <div class="row mb-3">
          <div class="col-md-3"><input name="departure" class="form-control" placeholder="Departure City" required></div>
          <div class="col-md-3"><input name="arrival" class="form-control" placeholder="Arrival City" required></div>
          <div class="col-md-3"><input type="date" name="date" class="form-control" required></div>
          <div class="col-md-3">
            <select name="flight_type" class="form-select">
              <option value="">All Types</option>
              <option value="domestic">Domestic</option>
              <option value="international">International</option>
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-3">
            <select name="trip_type" class="form-select" id="trip_type">
              <option value="one-way">One Way</option>
              <option value="round-trip">Round Trip</option>
            </select>
          </div>
          <div class="col-md-3" id="return_date_div" style="display:none;">
            <input type="date" name="return_date" class="form-control" placeholder="Return Date">
          </div>
          <div class="col-md-3">
            <select name="airline" class="form-select">
              <option value="">All Airlines</option>
              <option value="Indigo">Indigo</option>
              <option value="Ixigo">Ixigo</option>
              <option value="Air Bus">Air Bus</option>
            </select>
          </div>
        </div>
        <div class="text-center"><button class="btn btn-primary px-4" type="submit">Search Flights</button></div>
      </form>
    </div>
    <?php if (!empty($departureFlights)): ?>
    <div class="mt-5 bg-white p-4 shadow rounded">
      <h4 class="mb-4 text-center"><?= $search ? "Departure Flights" : "All Available Flights" ?></h4>
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>Flight No</th><th>Airline</th><th>From</th><th>To</th><th>Type</th><th>Trip</th><th>Date</th><th>Time</th><th>Price</th><th>Book</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($departureFlights as $f): ?>
          <tr>
            <td><?= $f['flight_no'] ?></td>
            <td><?= $f['airline'] ?></td>
            <td><?= $f['departure_city'] ?></td>
            <td><?= $f['arrival_city'] ?></td>
            <td><?= ucfirst($f['type']) ?></td>
            <td><?= ucfirst($f['trip_type']) ?></td>
            <td><?= $f['date'] ?></td>
            <td><?= $f['time'] ?></td>
            <td>$<?= $f['price'] ?></td>
            <td>
              <a href="conformation.php?flight_no=<?= urlencode($f['flight_no']) ?>" target="_blank" class="btn btn-success btn-sm">Book</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>

    <?php if (!empty($returnFlights)): ?>
    <div class="mt-5 bg-white p-4 shadow rounded">
      <h4 class="mb-4 text-center">Return Flights</h4>
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>Flight No</th><th>Airline</th><th>From</th><th>To</th><th>Type</th><th>Trip</th><th>Date</th><th>Time</th><th>Price</th><th>Book</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($returnFlights as $f): ?>
          <tr>
            <td><?= $f['flight_no'] ?></td>
            <td><?= $f['airline'] ?></td>
            <td><?= $f['departure_city'] ?></td>
            <td><?= $f['arrival_city'] ?></td>
            <td><?= ucfirst($f['type']) ?></td>
            <td><?= ucfirst($f['trip_type']) ?></td>
            <td><?= $f['date'] ?></td>
            <td><?= $f['time'] ?></td>
            <td>$<?= $f['price'] ?></td>
            <td>
              <a href="conformation.php?flight_no=<?= urlencode($f['flight_no']) ?>" target="_blank" class="btn btn-success btn-sm">Book</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>

  <script>
    $('#trip_type').on('change', function () {
      $('#return_date_div').toggle(this.value === 'round-trip');
    }).trigger('change');
  </script>


  <!-- FOOTER (unchanged styling, improved layout) -->
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
      // Toggle the 'show' class on the <ul> element when the hamburger is clicked
      document.getElementById("navLinks").classList.toggle("show");
    }
  </script>

  <!-- Bootstrap JS (for navbar toggle) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  </body>
  </html>
