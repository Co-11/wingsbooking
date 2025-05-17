<!-- divya -->


<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'webdata'; // Your database name
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Server-side validation
    if (empty($fullName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: register.html");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: register.html");
        exit();
    }

    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: register.html");
        exit();
    }

    if (strlen($password) < 8 || !preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", $password)) {
        $_SESSION['error'] = "Password must be at least 8 characters long and include letters, numbers, and special characters.";
        header("Location: register.html");
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email is already registered.";
        header("Location: register.html");
        exit();
    }

    // Insert user into database
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, created_at) VALUES (?, ?, ?, NOW())");
    if ($stmt->execute([$fullName, $email, $hashedPassword])) {
        $_SESSION['success'] = "Registration successful. You can now log in.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Registration failed. Please try again.";
        header("Location: register.html");
        exit();
    }
}
?>
