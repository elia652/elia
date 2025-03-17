<?php
session_start();
include("../database/connection.php");

if($_GET['id']){
    $id=$_GET['id'];
try{
    $sql="DELETE FROM products WHERE id=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":id",$id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: view.php");
    exit();
}catch(PDOException $e){
    echo"<script>
    window.alert('You can not delete this product');
    </script>";
    header("Location: deleteProduct.php");
    exit();
}
}else{
        header("Location: ../index.php");
}
?>