<?php
include("../database/connection.php");
session_start();

// Debugging: Check if session contains the correct 'user' data
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    if (isset($user['id'])) {
        $id = $user['id'];
    } else {
        // Handle the case where 'id' is not set
        die("User ID is not set in the session.");
    }
} else {
    die("User session is not set.");
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Get the form input values
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $email = trim($_POST['email']);

    // Try to insert the supplier data
    try {
        // Prepare the SQL query
        $sql = "INSERT INTO supplier (supplier_name, supplier_location, email, created_by, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        
        // Bind the parameters
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $location, PDO::PARAM_STR);
        $stmt->bindParam(3, $email, PDO::PARAM_STR);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Redirect to the dashboard after successful insertion
        header("Location: view.php");
        exit();
    } catch (PDOException $e) {
        // Log the error (for developers) and show a user-friendly message
        error_log("Database error: " . $e->getMessage());
        echo "<script>
                alert('There was an error processing your request. Please try again later.');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers</title>
</head>
<style>
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    body{
        background-color: #2c3e50;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        flex-direction: column;
       }
       .inserting{
        background-color: whitesmoke;
        display: inline-block;
        width: 400px;
        height:500px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        padding: 40px;
       }
       h2{
        display:block ;
        margin-left:60px;
        margin-right: 30px;
        margin-top: 25px;
        margin-bottom: 40px;
        font-size: 32px;
        color: #2c3e50;
       }
       h2::after{
        display: block;
        content: "";
        width: 100%;
        margin-left: -20px;
        background-color: #2c3e50;
        height: 2px;
       }
       form{
        display: flex;
        flex-direction: column;
       }
       label{
        font-size: 20px;
        color: #2c3e50;
        font-weight:bold;
       }
       input{
        margin-bottom: 20px;
        font-size: 18px;
        padding: 5px;
       }
       button{
        margin-top: 30px;
        height: 40px;
        background-color: #2c3e50;
        color: whitesmoke;
        font-size: 18px;
       }
       button:hover{
        background-color:rgb(42, 52, 63);
        color: white;
       }
</style>
<body>
    <div class="inserting">
        <h2>Add Supplier</h2>
        <form method="POST" action="">
            <label for="name">Supplier Name:</label>
            <input type="text" name="name" required />
            <label for="location">Supplier Location:</label>
            <input type="text" name="location" required />
            <label for="email">Supplier Email:</label>
            <input type="email" name="email" required />
            <button type="submit">Add</button>
        </form>
    </div>
</body>
</html>