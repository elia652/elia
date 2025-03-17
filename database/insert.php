<?php
session_start();
include("connection.php"); // Include database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Securely hash password

    try {
        // Insert user into database
        $sql = "INSERT INTO users (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect to display page
        header("Location: display.php");
        exit;
    } catch (PDOException $e) {
        die("Insertion failed: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #34495e;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex-direction: column;
        }
        .form-container {
            background: #ecf0f1 ;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }
        h2{
            color:#34495e
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: rgb(255, 255, 255);
            color: black;
        }
        button {
            background: #34495e;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background:rgb(42, 52, 61);
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add User</h2>
    <form method="post">
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" autocomplete="new-password" required>
        <a href="display.php"><button type="submit">Add User</button></a>
    </form>
</div>

</body>
</html>
