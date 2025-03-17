<?php
include("../database/connection.php");
session_start();

if ($conn) {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        try {
            if (isset($_POST['firstName'], $_POST['password'], $_POST['lastName'], $_POST['email'])) {
                $fname = $_POST['firstName'];
                $lname = $_POST['lastName'];
                $email = $_POST['email'];
                $pass = $_POST['password'];
                $imagePath = NULL;

                // Password hashing
                $hashing_pass = password_hash($pass, PASSWORD_DEFAULT);

                // File upload handling
                if (!empty($_FILES["image"]["name"])) {
                    $target_dir = "upload/";

                    // Ensure directory exists
                    if (!file_exists($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }

                    $image_name = basename($_FILES["image"]["name"]);
                    $imageFileType = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
                    $newFileName = uniqid() . "_" . $image_name;
                    $target_file = $target_dir . $newFileName;

                    // Allowed file types
                    $allowed_types = ["jpg", "jpeg", "png", "gif"];
                    if (!in_array($imageFileType, $allowed_types)) {
                        die("Invalid file type! Only JPG, JPEG, PNG, and GIF files are allowed.");
                    }

                    // Move uploaded file
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $imagePath = $target_file;
                    } else {
                        die("Error moving file to target directory!");
                    }
                }

                // Insert into database
                
                    $sql = "INSERT INTO users (firstName, lastName, email, password, image) 
                            VALUES (:firstName, :lastName, :email, :password, :imagePath)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":firstName", $fname, PDO::PARAM_STR);
                    $stmt->bindParam(":lastName", $lname, PDO::PARAM_STR);
                    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                    $stmt->bindParam(":password", $hashing_pass, PDO::PARAM_STR);
                    $stmt->bindParam(":imagePath", $imagePath, PDO::PARAM_STR);
                    $stmt->execute();
            

                // Redirect on success
                header("Location: home1.php");
                exit();
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
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
    <title>Signup Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #34495e; /* Dark Blue Background */
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            padding-top: 40px;
            border-radius: 10px;
            width: 100%;
            height:96vh;
            max-width: 400px;
            margin-top: 13px;
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
            background-color:rgb(45, 59, 72);
            color:white;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Signup</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="firstName" class="form-label">FirstName</label>
                <input type="text" class="form-control" id="username" required name="firstName" placeholder="Enter your firstname">
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">LastName</label>
                <input type="text" class="form-control" id="username" required name="lastName" placeholder="Enter your lastname">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="username" required name="email" placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" required name="password" autocomplete="new-password" placeholder="Enter your password">
            </div>     
            <div class="mb-3">
                <label for="imag" class="form-label">Image</label>
                <input type="file" class="form-control" id="password"  name="image">
            </div>
            <button type="submit" class="btn btn-login">Signup</button>
        </form>
    </div>
</body>
</html>
