<?php
session_start(); // Always start the session first

// Fetch user's full name and amount from the session
$name = $_SESSION['full_name'] ?? 'Guest';
$amount = $_SESSION['total_price'] ?? '0.00';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Pay with PayPal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f1f9ff;
      padding: 50px;
    }
    .payment-container {
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .paypal-logo {
      height: 40px;
    }
  </style>
</head>
<body>
  <div class="payment-container text-center">
    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" alt="PayPal" class="paypal-logo mb-3">
    
    <h3>Hello, <?php echo htmlspecialchars($name); ?>!</h3>
    <p class="lead">You're about to complete your booking using <strong>PayPal</strong>.</p>
    <p>Total to pay: <strong>₹<?php echo htmlspecialchars($amount); ?></strong></p>

    <form action="payment_success.php" method="POST">
      <!-- Simulated payment submission -->
      <input type="hidden" name="payment_method" value="PayPal">
      <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">
      <button class="btn btn-primary btn-lg mt-3" type="submit">Pay with PayPal</button>
    </form>

    <p class="text-muted mt-3">This is a simulated payment page for demonstration purposes.</p>
  </div>
</body>
</html>