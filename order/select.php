<?php
session_start();
include("../database/connection.php");

try {
    // Query to fetch supplier names along with product_supplier details
    $sql = "SELECT ps.id, s.supplier_name, p.product_name, 
                   ps.quantity_ordered, ps.quantity_received, ps.quantity_remaining, 
                   ps.status, ps.created_by
            FROM product_supplier ps
            JOIN products p ON ps.product = p.id
            JOIN supplier s ON ps.supplier = s.id";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $results = $stmt->fetchAll();
    $_SESSION['results']=$results;
} catch (PDOException $e) {
    echo "<script>
        window.alert('There is something wrong: " . $e->getMessage() . "');
        window.location.href='../index.php';
    </script>";
    exit();
}
?>