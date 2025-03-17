<?php
session_start();
include("../database/connection.php");
try{
    $query = "SELECT * FROM supplier";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['suppliers']=$suppliers;
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
return $suppliers;
?>

