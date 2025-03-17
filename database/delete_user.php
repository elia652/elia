<?php
session_start();
include("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM users WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: display.php"); 
      
    } catch (PDOException $e) {
        echo "$e";
       
    }
    
} else {
    header("Location: ../index.php");
    exit();
}
?>
