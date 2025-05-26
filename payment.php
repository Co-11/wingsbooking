<?php
session_start();

// Get the total price from session or use default
$amount = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : '197.40';
?>
 <!-- <tr><th>Price</th><td>₹<?= htmlspecialchars($flight['price']) ?></td></tr> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Select Payment Method</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    .payment-method {
      border: 1px solid #d0d0d0;
      border-radius: 8px;
      padding: 16px;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
      transition: 0.3s;
    }

    .payment-method:hover {
      border-color: #007bff;
      background-color: #f9f9f9;
    }

    .payment-method input {
      margin-right: 10px;
    }

    .logos img {
      height: 24px;
      margin-right: 8px;
    }

    .total-price {
      background-color: #e9f3fb;
      padding: 16px;
      font-size: 1.2rem;
      font-weight: 600;
      text-align: right;
      border-radius: 6px;
      color: #004080;
    }
  </style>
</head>
<body>
  <div class="container mt-5" style="max-width: 600px;">
    <h4 class="mb-4">Select a payment method:</h4>
    <form action="process_payment.php" method="POST">
      
      <label class="payment-method">
        <div class="d-flex align-items-center">
          <input type="radio" name="payment_method" value="paypal" required>
          <span class="ms-2">PayPal</span>
        </div>
        <img src="https://www.paypalobjects.com/webstatic/icon/pp258.png" alt="PayPal" height="24">
      </label>

      <label class="payment-method">
        <div class="d-flex align-items-center">
          <input type="radio" name="payment_method" value="bank_transfer">
          <span class="ms-2">Bank Transfer</span>
        </div>
      </label>

      <label class="payment-method">
        <div class="d-flex align-items-center">
          <input type="radio" name="payment_method" value="credit_card">
          <span class="ms-2">Credit Card</span>
        </div>
        <div class="logos">
          <img src="https://img.icons8.com/color/48/visa.png" alt="Visa">
          <img src="https://img.icons8.com/color/48/mastercard.png" alt="MasterCard">
          <img src="https://img.icons8.com/color/48/amex.png" alt="Amex">
          <img src="https://img.icons8.com/color/48/discover.png" alt="Discover">
        </div>
      </label>

      <label class="payment-method">
        <div class="d-flex align-items-center">
          <input type="radio" name="payment_method" value="debit_card">
          <span class="ms-2">Debit Card</span>
        </div>
        <div class="logos">
          <img src="https://img.icons8.com/color/48/visa.png" alt="Visa Debit">
          <img src="https://img.icons8.com/color/48/mastercard.png" alt="MasterCard Debit">
        </div>
      </label>

      <div class="total-price mt-4">Total price: INR <?php echo htmlspecialchars($amount); ?></div>

      <button type="submit" class="btn btn-primary mt-4 w-100">Confirm & Continue</button>
    </form>
  </div>
</body>
</html>
