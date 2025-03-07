<?php
session_start();
include 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check the database for the user
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $user['username'];
            header("Location: HomePage.html");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <link rel="icon" type="image/x-icon" href="./images/newslogo21.png">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN LOGIN</title>
    <style>
        @font-face {
            font-family: Sublima;
            src: url(sublima/Sublima-ExtraBold.otf);
        }
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(220, 220, 220);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 60px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.21);
            width: 400px;
            height: 400px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2 {
            margin-top: -2%;
            margin-bottom: 15%;
            text-align: center;
            width: 100%;
            font-family: Sublima;
            font-size: 40px;
        }
        h2 span {
            color:rgb(255, 0, 0);
        }

        .login-container img {
            width: 35%;
            height: 35%;
            margin-top: -40px;
            margin-bottom: 10px;
        
        }
        form {
            width: 80%;
        }
        label {
            display: block;
            margin-bottom: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 16px;
            font-family: Sublima;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid black;
            border-radius: 10px;
            margin-right: 100px;
        }
        button {
            width: 50%;
            margin-top: 10px;
            padding: 10px;
            background-color:rgb(205, 114, 114);
            color: white;
            border: 1px solid white;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            font-family: Sublima;
        }
        button:hover {
            background-color:rgb(17, 42, 205);
            color: white;
            transition: 0.3s;
        }
        .error {
            color: red;
            margin-bottom: 10px;
            position: absolute;
            top: 330px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2><span>ADMIN</span> LOGIN</h2> <!-- Now correctly positioned at the top -->
        <img src="./images/newslogo21.png" alt="logo">
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
