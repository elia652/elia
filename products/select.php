<?php
session_start();
try {
    // Fetch all products from the database
    $sql = "SELECT * FROM products";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['products']=$products;
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
return $products;
?>