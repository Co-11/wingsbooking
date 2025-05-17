<!-- divya -->


<?php
// Start the session
session_start();

// Include the database connection
include('connection.php');

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database for the user
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists and password matches
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            header("Location: dashboard.php"); // Redirect to the dashboard
            exit();
        } else {
            $error_message = "Incorrect password.";
        }
    } else {
        $error_message = "No user found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

      .login-container {
    max-width: 400px;
    margin: 80px auto;
    padding: 30px;
    background-color: #ffffff;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    text-align: center;
}

.login-container h2 {
    margin-bottom: 20px;
    color: #333;
}

/* Form styles */
.login-form {
    display: flex;
    flex-direction: column;
}

.login-form label {
    text-align: left;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.login-form input[type="email"],
.login-form input[type="password"] {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    transition: border-color 0.3s;
}

.login-form input:focus {
    border-color: #007bff;
    outline: none;
}

/* Button styling */
.login-form button {
    padding: 12px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.login-form button:hover {
    background-color: #0056b3;
}

/* Error message */
.error-message {
    color: red;
    margin-bottom: 15px;
    font-weight: bold;
}

/* Link to register */
.login-container p {
    margin-top: 15px;
    font-size: 14px;
}

.login-container a {
    color: #007bff;
    text-decoration: none;
}

.login-container a:hover {
    text-decoration: underline;
}
    </style>
</head>
<body>

    <header>
    <nav>
      <div class="logo">WingsBooking</div>
      <div class="menu-icon" onclick="toggleMenu()">☰</div>
      <ul id="navLinks">
        <li><a href="index.php">Home</a></li>
        <li><a href="flight.php">Flights</a></li>
        <li><a href="mybookings.php">My Bookings</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="about.php">About Us</a></li>
      </ul>
      <div class="auth-buttons">
      
        <a href="register.php" class="btn register-btn">Register</a>
      </div>
    </nav>
    </header>

    <div class="login-container">
        <h2>Login</h2>

        <?php
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>

        <form action="login.php" method="POST" class="login-form">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password">

            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>

</body>
</html>
