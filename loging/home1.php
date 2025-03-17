<?php
include("../database/connection.php");
session_start(); 

if ($conn) {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST['firstName']) && isset($_POST['password'])) {
            $name = $_POST['firstName'];
            $pass = $_POST['password'];

            // Fetch user details based on username only
            $sql = "SELECT * FROM users WHERE firstName = :name";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row
//////////////////////////////////////////////////////////////////////////////////////////////////
//password_verify($pass,$user['password'])
                // Store user data in session
                $_SESSION['user'] = $user;
                
                // Redirect to home page
                header("Location: ../home.php");
                exit();
            } else {
                // Redirect back to login on failure
                header("Location: ../index.php");
                exit();
            }
        }
    }

?>
               



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
body {
    background-color: #34495e;
    font-family: 'Arial', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-container {
    background-color: #fff;
    padding: 40px;
    border-radius: 8px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.login-container h2 {
    text-align: center;
    color: #34495e;
    margin-bottom: 20px;
}

.form-label {
    color: #34495e;
}

.form-control {
    border-radius: 4px;
    border: 1px solid #ddd;
    margin-bottom: 15px;
}

.btn-login {
    background-color: #34495e;
    color: white;
    border: none;
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    font-size: 16px;
}

.btn-login:hover {
    background-color: #2c3e50;
    color: white;
}

a {
    color: #2c3e50;
    display: block;
    text-align: center;
    margin-top: 10px;
}

a:hover {
    color: red;
}

button {
    cursor: pointer;
}

/* MEDIA QUERIES FOR MOBILE RESPONSIVENESS */
@media (max-width: 768px) {
    .login-container {
        width: 90%;
        padding: 20px;
    }
    h2{
        margin-bottom: 13px;
    }
    .form-control {
        font-size: 14px;
    }

    .btn-login {
        font-size: 14px;
        padding: 8px;
    }

    a {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .login-container {
        width: 95%;
        padding: 15px;
    }

    h2 {
        font-size: 20px;
    }

    .btn-login {
        font-size: 13px;
        padding: 7px;
    }

    a {
        font-size: 13px;
    }
}
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">FirstName</label>
                <input type="text" class="form-control" id="username" name="firstName" placeholder="Enter your username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-login">Login</button>
        </form>
        <div class="sign"><a href="signup.php">Signup</a></div>
    </div>
    <script>

    let user = <?= isset($user) ? json_encode($user) : 'null' ?>;
    console.log(user);
</script>
    
</body>
</html>