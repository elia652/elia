<?php
 include("../database/connection.php");
if(isset($_GET['id']) && !empty($_GET['id'])){
    $id=$_GET['id'];
}

try{
    $sql="DELETE from supplier where id=:id ";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":id",$id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: select.php");
    exit();
}catch(PDOException $e){
    echo"<script>
    window.alert('We can not delete this supplier $e');
    </script>";
    header("Location: select.php");
    exit();
}