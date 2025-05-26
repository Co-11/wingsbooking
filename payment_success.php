<?php
require_once('tcpdf/tcpdf.php');
session_start();

// Get user data
$name = $_SESSION['user_name'] ?? '';
$payment_method = $_SESSION['payment_method'] ?? '';
$amount_raw = $_SESSION['total_price'] ?? '';

// Validate
if ($name === '' || $payment_method === '' || !is_numeric($amount_raw) || $amount_raw <= 0) {
    die("Error: Missing or invalid user data. Please login and complete your booking first.");
}

// Sanitize
$name_safe = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$payment_method_safe = htmlspecialchars($payment_method, ENT_QUOTES, 'UTF-8');
$amount_display = number_format((float)$amount_raw, 2);

// If form is submitted, generate ticket
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_ticket'])) {
    $ticket_no = strtoupper(uniqid('TKT'));
    $current_date = date('Y-m-d H:i:s');

    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    $html = <<<EOD
    <h1 style="text-align:center;">E-Ticket</h1>
    <p><strong>Name:</strong> {$name_safe}</p>
    <p><strong>Ticket Number:</strong> {$ticket_no}</p>
    <p><strong>Payment Method:</strong> {$payment_method_safe}</p>
    <p><strong>Amount Paid:</strong> ₹{$amount_display}</p>
    <p><strong>Date:</strong> {$current_date}</p>
    <hr>
    <p>Thank you for booking with WingsBooking. Please carry this e-ticket during your travel.</p>
    EOD;

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf_filename = "eticket_{$ticket_no}.pdf";
    $pdf->Output($pdf_filename, 'D');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Payment Success</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f2f9ff;
      padding: 50px;
    }
    .ticket-box {
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <div class="ticket-box">
    <h2>✅ Payment Successful!</h2>
    <p>Thank you, <strong><?php echo $name_safe; ?></strong>!</p>
    <p>Payment Method: <strong><?php echo $payment_method_safe; ?></strong></p>
    <p>Amount Paid: <strong>₹<?php echo $amount_display; ?></strong></p>

    <form method="POST">
      <button type="submit" name="generate_ticket" class="btn btn-success mt-4">🎫 Generate E-Ticket</button>
    </form>
  </div>
</body>
</html>
