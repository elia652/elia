<?php
include("../database/connection.php");

if($_GET['id']){
    $id=$_GET['id'];
try{
    $sql="DELETE FROM product_supplier WHERE id=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":id",$id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: fetch.php");
    exit();
}catch(PDOException $e){
    echo"<script>
    window.alert('You can not delete this product');
    </script>";
    header("Location: fetch.php");
    exit();
}
}else{
        header("Location: ../index.php");
}
?>