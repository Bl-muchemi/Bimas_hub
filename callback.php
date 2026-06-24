<?php
include "includes/db.php";

// Get raw callback JSON
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

// Log everything for debugging
file_put_contents('mpesa_callback.log', $raw . PHP_EOL, FILE_APPEND);

// Validate structure
if(isset($data['Body']['stkCallback'])){

    $callback = $data['Body']['stkCallback'];
    $resultCode = $callback['ResultCode'];

    // =========================
    // SUCCESS PAYMENT
    // =========================
    if($resultCode == 0){

        $items = $callback['CallbackMetadata']['Item'];

        $amount = 0;
        $phone = '';
        $receipt = '';

        foreach($items as $item){
            if($item['Name'] == 'Amount'){
                $amount = $item['Value'];
            }
            if($item['Name'] == 'MpesaReceiptNumber'){
                $receipt = $item['Value'];
            }
            if($item['Name'] == 'PhoneNumber'){
                $phone = $item['Value'];
            }
        }

        // =========================
        // UPDATE ORDER STATUS
        // =========================

        $conn->query("
            UPDATE orders 
            SET status = 'paid'
            WHERE status = 'pending'
            ORDER BY id DESC
            LIMIT 1
        ");

        // OPTIONAL: store payment record (recommended)
        $conn->query("
            CREATE TABLE IF NOT EXISTS payments (
                id INT AUTO_INCREMENT PRIMARY KEY,
                phone VARCHAR(20),
                amount DECIMAL(10,2),
                mpesa_receipt VARCHAR(100),
                status VARCHAR(20),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");

        $conn->query("
            INSERT INTO payments (phone, amount, mpesa_receipt, status)
            VALUES ('$phone', '$amount', '$receipt', 'success')
        ");

    } else {

        // =========================
        // FAILED PAYMENT
        // =========================

        $conn->query("
            UPDATE orders 
            SET status = 'failed'
            WHERE status = 'pending'
            ORDER BY id DESC
            LIMIT 1
        ");
    }
}

// Always respond OK to Safaricom
echo "OK";
?>