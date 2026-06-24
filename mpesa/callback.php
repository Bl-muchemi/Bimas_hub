<?php
// 1. Enable errors for debugging (Check your server logs to see these)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../includes/db.php'; // Database connection

// --- Setup logs directory (Ensure this folder is writable) ---
$logDir = '../logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0777, true);
}

// --- Receive JSON callback from M-PESA ---
$callbackJSON = file_get_contents('php://input');
$callbackData = json_decode($callbackJSON, true);

// Log every single hit from Safaricom so we have a paper trail
file_put_contents($logDir . '/mpesa_callback_raw.txt', date('Y-m-d H:i:s') . " " . $callbackJSON . PHP_EOL, FILE_APPEND);

// --- Extract STK callback safely ---
$stkCallback = $callbackData['Body']['stkCallback'] ?? null;
$checkoutRequestID = $stkCallback['CheckoutRequestID'] ?? null;
$resultCode = $stkCallback['ResultCode'] ?? null;
$resultDesc = $stkCallback['ResultDesc'] ?? '';

if ($checkoutRequestID) {
    if ($resultCode === 0) {
        // ResultCode 0 means SUCCESS
        $items = $stkCallback['CallbackMetadata']['Item'] ?? [];
        
        $mpesaReceipt = '';
        $amountPaid = 0;
        $phone = '';

        foreach ($items as $item) {
            $name = $item['Name'] ?? '';
            $value = $item['Value'] ?? '';
            
            if ($name === 'MpesaReceiptNumber') $mpesaReceipt = $value;
            if ($name === 'Amount') $amountPaid = $value;
            if ($name === 'PhoneNumber') $phone = $value;
        }

        // Update transaction as 'paid'
        // Ensure your table 'mpesa_transactions' has a 'receipt' column
        $stmt = $conn->prepare(
            "UPDATE mpesa_transactions SET status = ?, receipt = ?, amount = ? WHERE checkout_request_id = ?"
        );
        $status = 'paid';
        $stmt->bind_param('ssis', $status, $mpesaReceipt, $amountPaid, $checkoutRequestID);

        if ($stmt->execute()) {
            file_put_contents($logDir . '/mpesa_db_updates.txt', date('Y-m-d H:i:s') . " SUCCESS: Updated ID $checkoutRequestID to paid\n", FILE_APPEND);
        } else {
            file_put_contents($logDir . '/mpesa_db_errors.txt', date('Y-m-d H:i:s') . " DB ERROR: " . $stmt->error . "\n", FILE_APPEND);
        }
        $stmt->close();

    } else {
        // ResultCode != 0 means user cancelled, insufficient funds, or timeout
        $stmt = $conn->prepare(
            "UPDATE mpesa_transactions SET status = ? WHERE checkout_request_id = ?"
        );
        $status = 'failed';
        $stmt->bind_param('ss', $status, $checkoutRequestID);
        $stmt->execute();
        $stmt->close();

        file_put_contents($logDir . '/mpesa_db_updates.txt', date('Y-m-d H:i:s') . " FAILED: ID $checkoutRequestID - $resultDesc\n", FILE_APPEND);
    }
}

// --- Respond to M-PESA (Mandatory acknowledgement) ---
header('Content-Type: application/json');
echo json_encode([
    "ResultCode" => 0,
    "ResultDesc" => "Accepted"
]);
?>