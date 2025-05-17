<!-- divya -->


<?php
// Include the database connection
include('connection.php');

// Initialize an error message variable
$error_message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize the form data
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the data
    if ($password !== $confirm_password) {
        $error_message = 'Passwords do not match.';
    } else {
        // Check if the email already exists
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $error_message = 'Email already exists. Please use a different one.';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert the user data into the database
            $insert_query = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$hashed_password')";
            if (mysqli_query($conn, $insert_query)) {
                // Registration successful, redirect to login page
                header('Location: login.php');
                exit();
            } else {
                $error_message = 'Error: Could not register user. Please try again later.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="index.css">
    <style>
 header nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        background-color: #002244;
        position: relative;
      }
      
      /* Logo */
      .logo {
        color: white;
        font-size: 24px;
        font-weight: bold;
      }
      
      /* Mobile menu icon (toggle) */
      .menu-icon {
        display: none;
        font-size: 30px;
        color: white;
      }
      
      /* Navigation links */
      #navLinks {
        list-style: none;
        display: flex;
        gap: 20px;
        margin: 0;
        padding: 0;
        justify-content: center;
        flex-grow: 1;
      }
      
      #navLinks li {
        margin: 0;
      }
      
      #navLinks a {
        color: white;
        text-decoration: none;
        font-size: 16px;
      }
      
      /* Auth buttons positioned at the corners */
      .auth-buttons {
        display: flex;
        gap: 10px;
      }
      
      .auth-buttons .btn {
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        background-color: #007bff;
        transition: background-color 0.3s;
      }
      
      .auth-buttons .btn:hover {
        background-color: #0056b3;
      }
      
      .auth-buttons .login-btn {
        margin-right: 10px;
      }
      
      /* Mobile menu icon visibility for small screens */
      @media screen and (max-width: 768px) {
        .menu-icon {
          display: block;
        }
      
        #navLinks {
          display: none;
          flex-direction: column;
          position: absolute;
          top: 60px;
          left: 0;
          width: 100%;
          background-color: #002244;
        }
      
        #navLinks li {
          text-align: center;
          margin: 10px 0;
        }
      
        #navLinks.active {
          display: flex;
        }
      
        .auth-buttons {
          display: flex;
          gap: 10px;
          position: absolute;
          right: 20px;
          top: 15px;
        }
      }
      .btn1{
         background-color: #007bff;  
         border-radius: 5px;

      }
      a{
        text-decoration: none;
        color: white;
      }
.registration-form {
    width: 100%;
    max-width: 500px;
    margin: 50px auto;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.registration-form h2 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}

.registration-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.registration-form input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

.registration-form input:focus {
    border-color: #007bff;
    outline: none;
}

.registration-form button {
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    color: white;
    font-size: 16px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.registration-form button:hover {
    background-color: #007bff;
}

/* Error Message */
.error-message {
    color: red;
    font-size: 14px;
    margin-bottom: 15px;
}

/* Footer Link */
.registration-form p {
    text-align: center;
    margin-top: 15px;
}

.registration-form a {
    color:#007bff;
    text-decoration: none;
}

.registration-form a:hover {
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    .ban-img .banner-content h1 {
        font-size: 28px;
    }

    .ban-img .banner-content p {
        font-size: 16px;
    }
    
    .registration-form {
        width: 90%;
    }
}
    </style>
</head>
<body>

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

    <div class="registration-form">
        <h2>Create an Account</h2>

        <!-- Display error message if there's any -->
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Registration Form -->
        <form action="register.php" method="POST">
            <!-- Full Name -->
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" required placeholder="Enter your full name">

            <!-- Email -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email">

            <!-- Password -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password">

            <!-- Confirm Password -->
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm your password">

            <!-- Submit Button -->
            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>


</body>
</html>
