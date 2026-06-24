<?php
session_start();
include "includes/db.php";

$message = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get and trim input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){

        $user = $result->fetch_assoc();

        // Verify hashed password
        if(password_verify($password, $user['password'])){

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if($user['role'] === "admin"){
                header("Location: admin.php");
                exit();
            } else {
                header("Location: users.php");
                exit();
            }

        } else {
            // If password is plain text in DB (temporary fallback)
            if($password === $user['password']){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                if($user['role'] === "admin"){
                    header("Location: admin.php");
                    exit();
                } else {
                    header("Location: users.php");
                    exit();
                }
            }

            $message = "Invalid password.";
        }

    } else {
        $message = "User not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bimas Hub Login</title>
    <style>
        body{
            font-family: Arial;
            background:#f5f5f5;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }
        .box{
            background:white;
            padding:40px;
            width:350px;
            border-radius:8px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }
        h2{
            text-align:center;
            color:#ff6f00;
        }
        input{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:1px solid #ccc;
            border-radius:5px;
        }
        button{
            width:100%;
            padding:12px;
            background:#ff6f00;
            border:none;
            color:white;
            font-size:16px;
            border-radius:5px;
            cursor:pointer;
        }
        button:hover{
            background:#e65c00;
        }
        .message{
            text-align:center;
            margin-bottom:10px;
            color:red;
        }
        .register{
            text-align:center;
            margin-top:10px;
        }
        .register a{
            color:#ff6f00;
            text-decoration:none;
        }
    </style>
</head>
<body>
<div class="box">
    <h2>Login</h2>
    <div class="message"><?php echo htmlspecialchars($message); ?></div>

    <form method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <div class="register">
        Don't have an account? <a href="register.php">Register</a>
    </div>
</div>
</body>
</html>