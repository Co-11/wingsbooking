<?php
require_once('tcpdf/tcpdf.php');
session_start();

// Get form data (example)
$name = $_POST['name'] ?? 'John Doe';
$payment_method = $_POST['payment_method'] ?? 'Unknown';
$amount_paid = $_POST['amount'] ?? '0.00';

// Generate unique ticket number
$ticket_no = strtoupper(uniqid('TKT'));

// Generate PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$html = <<<EOD
<h1 style="text-align:center;">E-Ticket</h1>
<p><strong>Name:</strong> {$name}</p>
<p><strong>Ticket Number:</strong> {$ticket_no}</p>
<p><strong>Payment Method:</strong> {$payment_method}</p>
<p><strong>Amount Paid:</strong> £{$amount_paid}</p>
<p><strong>Date:</strong> {date('Y-m-d H:i:s')}</p>
<hr>
<p>Thank you for booking with WingsBooking. Please carry this e-ticket during your travel.</p>
EOD;

$pdf->writeHTML($html, true, false, true, false, '');

// Save PDF file to 'tickets/' folder
$pdf_name = "eticket_{$ticket_no}.pdf";
$pdf_path = __DIR__ . "/tickets/{$pdf_name}";

// Make sure the tickets folder exists
if (!is_dir(__DIR__ . "/tickets")) {
    mkdir(__DIR__ . "/tickets", 0777, true);
}

$pdf->Output($pdf_path, 'F'); // 'F' means save to file

// Save booking info + ticket name to DB here (optional)

// Redirect user to bank transfer instructions page with ticket file name
header("Location: bank_transfer_instructions.php?file={$pdf_name}");
exit;
?>
