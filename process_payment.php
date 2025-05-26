<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = $_POST['payment_method'] ?? '';

    switch ($method) {
        case 'paypal':
            header("Location: paypal_payment.php"); exit;
        case 'credit_card':
            header("Location: credit_card_payment.php"); exit;
        case 'debit_card':
            header("Location: debit_card_payment.php"); exit;
        case 'bank_transfer':
            header("Location: bank_transfer_instructions.php"); exit;
        default:
            echo "Invalid payment method selected.";
    }
} else {
    header("Location: payment.php");
    exit;
}
