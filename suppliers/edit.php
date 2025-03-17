<?php
session_start();
include("../database/connection.php");
if($_GET['id']){
    $id=$_GET['id'];
}

foreach ($_SESSION['suppliers'] as $sp){
    if($sp['id']==$id){
        $suppliers=$sp;
        break;
    }
}
if($_SERVER['REQUEST_METHOD']==="POST"){


    $name=trim($_POST['name']);
    $location=trim($_POST['location']);
    $email=trim($_POST['email']);

try{

    $sql="UPDATE supplier SET supplier_name= :name , supplier_location= :location , email= :email WHERE id=:id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":name", $name , PDO::PARAM_STR);
    $stmt->bindParam(":location", $location , PDO::PARAM_STR);
    $stmt->bindParam(":email", $email , PDO::PARAM_STR);
    $stmt->bindParam(":id", $id , PDO::PARAM_STR);

    $stmt->execute();
    header("Location: select.php");
    exit();
   }catch(PDOException $e){
    echo"There is something wrong";
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
        <h2>Edit Supplier</h2>
        <form method="POST" action="">
            <label for="name">Supplier Name:</label>
            <input type="text" name="name" required value="<?= $suppliers['supplier_name'] ?>" />
            <label for="location">Supplier Location:</label>
            <input type="text" name="location" required  value="<?= $suppliers['supplier_location'] ?>" />
            <label for="email">Supplier Email:</label>
            <input type="email" name="email" required  value="<?= $suppliers['email'] ?>"/>
            <button type="submit">Edit</button>
        </form>
    </div>
</body>
</html>