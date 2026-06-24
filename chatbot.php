<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "includes/db.php";

// -------- AI FUNCTION --------
function callAI($message){

    $apiKey = "YOUR_GROQ_API_KEY"; // <-- Put your Groq/Llama key here

    $data = [
        "model" => "llama-3.1-8b-instant",
        "messages" => [
            [
                "role" => "system",
                "content" => "You are a helpful assistant for Bimas Hub. Answer about products, prices, stock, shipping, payments, and general questions."
            ],
            [
                "role" => "user",
                "content" => $message
            ]
        ],
        "temperature" => 0.7
    ];

    $ch = curl_init("https://api.groq.com/openai/v1/chat/completions");

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $apiKey
    ]);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if(curl_errno($ch)){
        return "API Error: " . curl_error($ch);
    }

    curl_close($ch);

    $respData = json_decode($response, true);

    if(isset($respData['choices'][0]['message']['content'])){
        return $respData['choices'][0]['message']['content'];
    }

    return "AI Error: " . $response;
}

// -------- HANDLE CHAT REQUEST --------
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])){
    header('Content-Type: application/json');

    $userMsg = trim($_POST['message']);
    $lower = strtolower($userMsg);
    $reply = "Sorry, I couldn't process that.";

    // ----- CHECK PRODUCT DATABASE -----
    $res = mysqli_query($conn, "SELECT name, price, stock FROM products");
    if($res){
        while($row = mysqli_fetch_assoc($res)){
            $productName = strtolower($row['name']);
            if(strpos($lower, $productName) !== false){
                $reply = $row['name']." costs KES ".number_format($row['price'])." and we have ".$row['stock']." in stock.";
                echo json_encode(['reply'=>$reply]);
                exit;
            }
        }
    }

    // ----- CHECK SALES TODAY -----
    if(strpos($lower,'sales today') !== false || strpos($lower,'today sales') !== false){
        $sales = mysqli_query($conn, "
            SELECT SUM(total_amount) as total_sales 
            FROM orders 
            WHERE DATE(order_date) = CURDATE()
        ");

        if($sales){
            $row = mysqli_fetch_assoc($sales);
            $total = $row['total_sales'] ?? 0;
            $reply = "Today's total sales for Bimas Hub are KES ".number_format($total).".";
        } else {
            $reply = "Sorry, I couldn't retrieve today's sales.";
        }

        echo json_encode(['reply'=>$reply]);
        exit;
    }

    // ----- COMMON RESPONSES -----
    if(strpos($lower,'hello') !== false || strpos($lower,'hi') !== false){
        $reply = "Hello! Welcome to Bimas Hub. How can I assist you today?";
    } elseif(strpos($lower,'payment') !== false || strpos($lower,'mpesa') !== false){
        $reply = "You can pay using M-PESA during checkout. Make sure your phone number is registered.";
    } elseif(strpos($lower,'shipping') !== false || strpos($lower,'delivery') !== false){
        $reply = "We deliver nationwide across Kenya. You can track orders from your dashboard.";
    } elseif(strpos($lower,'bimas hub') !== false){
        $reply = "Bimas Hub supplies construction materials, electronics, office supplies, uniforms and more across Kenya.";
    } else {
        // ----- AI FALLBACK -----
        $reply = callAI($userMsg);
    }

    echo json_encode(['reply'=>$reply]);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Bimas Hub AI Chatbot</title>
<style>
body{font-family:Arial;background:#f5f5f5;margin:0;padding:0;}
.container{width:90%;max-width:600px;margin:50px auto;background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.1);}
h2{text-align:center;color:#ff6f00;}
.chat-box{border:1px solid #ddd;padding:15px;height:300px;overflow-y:auto;border-radius:5px;background:#fafafa;}
.chat-box p{margin:8px 0;padding:8px;border-radius:5px;}
.user{background:#ff6f00;color:#fff;text-align:right;}
.bot{background:#eee;color:#000;text-align:left;}
form{display:flex;margin-top:10px;}
input{flex:1;padding:10px;border-radius:5px;border:1px solid #ccc;}
button{padding:10px 15px;background:#ff6f00;color:#fff;border:none;border-radius:5px;margin-left:5px;cursor:pointer;}
</style>
</head>
<body>
<div class="container">
<h2>Bimas Hub AI Chatbot</h2>
<div class="chat-box" id="chat-box"></div>
<form id="chat-form">
<input type="text" id="message" placeholder="Ask me anything..." required>
<button type="submit">Send</button>
</form>
</div>

<script>
const form = document.getElementById('chat-form');
const chatBox = document.getElementById('chat-box');

form.addEventListener('submit', async function(e){
    e.preventDefault();
    const msgInput = document.getElementById('message');
    const message = msgInput.value.trim();
    if(message === '') return;

    // Show user message
    const userP = document.createElement('p');
    userP.className = 'user';
    userP.textContent = message;
    chatBox.appendChild(userP);
    chatBox.scrollTop = chatBox.scrollHeight;

    // Send message to PHP
    const res = await fetch('chatbot.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'message=' + encodeURIComponent(message)
    });
    const data = await res.json();

    // Show AI reply
    const botP = document.createElement('p');
    botP.className = 'bot';
    botP.textContent = data.reply;
    chatBox.appendChild(botP);
    chatBox.scrollTop = chatBox.scrollHeight;

    msgInput.value = '';
});
</script>
</body>
</html>