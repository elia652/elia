<?php
session_start();
include("../database/connection.php"); // Include database connection

// Check if the user ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid user ID.");
}
$id = $_GET['id'];

foreach ($_SESSION['results'] as $p) {
    if ($p['id'] == $id) {
        $result = $p;
        break;
    }
}
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ordered = $_POST['quantity_ordered'];
    $received = $_POST['quantity_received'];
    $remaining = $ordered - $received;
    $status = "pending";


    try {
        if ($remaining < 0) {
            header("Location: fetch.php");
            exit();
        }     
         if ($remaining == 0) {
            $status = 'complete';
            $sql = "UPDATE product_supplier SET quantity_ordered = :ordered, status = :status, quantity_received = :received, quantity_remaining = :remaining, updated_at = Now() WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        } else if($remaining>0) {
            // Update product_supplier details
            $sql = "UPDATE product_supplier SET quantity_ordered = :ordered, quantity_received = :received, quantity_remaining = :remaining, updated_at = Now() WHERE id = :id";
            $stmt = $conn->prepare($sql);}
            $stmt->bindParam(':ordered', $ordered, PDO::PARAM_INT);
            $stmt->bindParam(':received', $received, PDO::PARAM_INT);
            $stmt->bindParam(':remaining', $remaining, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Redirect back to product list
            header("Location: fetch.php");
            exit();
        
    } catch (PDOException $e) {
        die("Update failed: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        button {
            background: #e67e22;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #d35400;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit </h2>
    <form method="post">
        <label for="quantity_ordered">Quantity Ordered:</label>
        <input type="number" name="quantity_ordered" value="<?= htmlspecialchars($result['quantity_ordered']) ?>" required>
        <label for="quantity_received">Quantity Received:</label>
        <input type="number" name="quantity_received" value="<?= htmlspecialchars($result['quantity_received']) ?>" required>
        <button type="submit">Update </button>
    </form>
</div>

</body>
</html>
