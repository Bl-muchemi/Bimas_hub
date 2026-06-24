<?php
session_start();
include "includes/db.php"; // Make sure this path is correct

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch messages from the database (replace table_name with your messages table)
$messages = [];
if ($conn) {
    $result = mysqli_query($conn, "SELECT id, sender, message, created_at FROM messages ORDER BY created_at DESC");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Messages | Bimas Hub</title>
<style>
body{font-family:Arial, sans-serif;background:#f5f5f5;margin:0;padding:0;}
.container{width:90%;max-width:800px;margin:50px auto;background:#fff;padding:30px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
h2{color:#ff6f00;text-align:center;margin-bottom:30px;}
table{width:100%;border-collapse:collapse;}
th, td{padding:12px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#ff6f00;color:#fff;}
a{color:#ff6f00;text-decoration:none;font-weight:bold;}
</style>
</head>
<body>
<div class="container">
<h2>Messages</h2>

<?php if(count($messages) > 0): ?>
<table>
    <tr>
        <th>Sender</th>
        <th>Message</th>
        <th>Date</th>
    </tr>
    <?php foreach($messages as $msg): ?>
    <tr>
        <td><?php echo htmlspecialchars($msg['sender']); ?></td>
        <td><?php echo htmlspecialchars($msg['message']); ?></td>
        <td><?php echo date('d-M-Y H:i', strtotime($msg['created_at'])); ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>No messages yet.</p>
<?php endif; ?>

<a href="services.php">← Back to Services</a>
</div>
</body>
</html>