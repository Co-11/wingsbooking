  <!-- Bootstrap & FontAwesome -->
<!-- divya -->

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>WingsBooking - Book your Wings</title>

  <!-- Your main CSS -->
  <link rel="stylesheet" href="index.css">

  <!-- Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
.user-menu a{
  text-decoration: none;
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

.book-now-button {
  background-color: #007BFF;/* Semi-transparent black */
  color: white;
  padding: 8px 20px;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  font-family: Arial, sans-serif;
  cursor: pointer;
  transition: background-color 0.3s ease;
  display: inline-block;
  text-align: center;
  user-select: none;
}

.book-now-button a{
  text-decoration: none;
  color: white;
}

.book-now-button:hover {
  background-color: rgba(0, 0, 0, 0.8); /* Darker on hover */
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




  <!-- Banner -->
  <div class="ban-img">
    <div class="overlay"></div>
    <img src="image/img.jpg" alt="Banner Image" class="banner-image">
    <div class="banner-content">
      <h1 class="txt">Find Your Next Adventure</h1>
      <p>Book your flight effortlessly and explore new destinations.</p>
    <button class="book-now-button"><a href="flight.php">Book Now</a></button>


    </div>
  </div>
</header>

  


<!-- Script for dropdown -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional JS for toggling mobile nav -->
<script>
function toggleMenu() {
  document.getElementById('navLinks').classList.toggle('active');
}
</script>





    
    <!------------------------------ services----------------- -->

    <section class="services">
        <h2>Our Services</h2>
        <div class="service-cards">
            <div class="service">
                <i class="fas fa-plane-departure"></i>
                <h3>Easy Booking</h3>
                <p>Book your flight in just a few clicks with our user-friendly platform.</p>
            </div>
            <div class="service">
                <i class="fas fa-utensils"></i>
                <h3>In-Flight Meals</h3>
                <p>Enjoy delicious meals and refreshments during your journey.</p>
            </div>
            <div class="service">
                <i class="fas fa-headset"></i>
                <h3>24/7 Support</h3>
                <p>Our customer care team is available around the clock to help you.</p>
            </div>
            <div class="service">
                <i class="fas fa-suitcase-rolling"></i>
                <h3>Baggage Handling</h3>
                <p>Safe and efficient baggage services for a worry-free trip.</p>
            </div>
        </div>
    </section>

    <!-- -----------------testimonial --------------------------->

    <section class="testimonials">
        <h2>What Our Passengers Say</h2>
        <div class="testimonial-cards">
            <div class="testimonial">
                <i class="fas fa-user-circle testimonial-icon"></i>
                <p>"Booking with WingsBooking  was effortless and quick. Highly recommend it!"</p>
                <h4>- Priya Sharma</h4>
            </div>
            <div class="testimonial">
                <i class="fas fa-user-circle testimonial-icon"></i>
                <p>"The flight was smooth, on time, and the customer service was outstanding."</p>
                <h4>- James Turner</h4>
            </div>
            <div class="testimonial">
                <i class="fas fa-user-circle testimonial-icon"></i>
                <p>"Best airline experience I've had in years. Super convenient!"</p>
                <h4>- Aisha Rahman</h4>
            </div>
        </div>
    </section>

    <!-- ---------------------destination ----------------------->
    
    <section class="destinations">
        <h2>Popular Destinations</h2>
        <div class="destination-cards">
            <div class="destination">
                <div class="destination-img-wrapper">
                  <img src="image/new_york.png" alt="New York">
                  <div class="overlay">
                    <a href="flight.php" class="view-flights-btn">View Flights</a>
                  </div>
                </div>
                <h3>New York, USA</h3>
                <p>City lights, iconic sights, and endless energy.</p>
              </div>
            <div class="destination">
                <div class="destination-img-wrapper">
                    <img src="image/south_korea.avif" alt="South Korea">
                    <div class="overlay">
                      <a href="flight.php" class="view-flights-btn">View Flights</a>
                    </div>
                  </div>
                
                <h3>South Korea</h3>
                <p>Trendy cities, rich culture, and tasty cuisine.</p>
            </div>
            <div class="destination">
                <div class="destination-img-wrapper">
                    <img src="image/maldives.jpg" alt="Maldives">
                    <div class="overlay">
                      <a href="flight.php" class="view-flights-btn">View Flights</a>
                    </div>
                  </div>
                
                <h3>Maldives</h3>
                <p>Crystal-clear waters and serene beaches.</p>
            </div>
        
                <div class="destination">
                    <div class="destination-img-wrapper">
                        <img src="image/Greece.jpg" alt="Greece">
                        <div class="overlay">
                          <a href="flight.php" class="view-flights-btn">View Flights</a>
                        </div>
                      </div>
               
                <h3>Greece</h3>
                <p>Sunny islands, ancient ruins, and great food.</p>
            </div>

    </section>    

    <!------------------------ footer --------------------------->

    <!-- FONT AWESOME --->
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