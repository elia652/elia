<?php
session_start();
include("../database/connection.php"); // Include database connection
// Check if the user ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid product ID.");
}

$id = $_GET['id'];

foreach ($_SESSION['products'] as $p) {
    if ($p['id'] == $id) {
        $product = $p;
        break;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $imagePath = NULL;


            // Debugging file upload
            if (!empty($_FILES["image"]["name"])) {
                echo "File is uploaded: " . $_FILES["image"]["name"] . "<br>";
                echo "File Size: " . $_FILES["image"]["size"] . " bytes<br>";
                echo "File Type: " . $_FILES["image"]["type"] . "<br>";

                // Check for upload errors
                if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
                    echo "Error during file upload: " . $_FILES["image"]["error"];
                    exit;
                }

                // Define file upload directory
                $target_dir = "uploads/";  // Ensure this folder exists
                $image_name = basename($_FILES["image"]["name"]);
                $imageFileType = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
                $newFileName = uniqid() . "_" . $image_name;  // Unique file name
                $target_file = $target_dir . $newFileName;

                // Allowed file types
                $allowed_types = ["jpg", "jpeg", "png", "gif"];

                // Check file type
                if (in_array($imageFileType, $allowed_types)) {
                    // Move uploaded file to target directory
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        echo "File uploaded successfully!";
                        $imagePath = $target_file;  // Save file path in the database
                    } else {
                        echo "Error moving file to target directory!";
                    }
                } else {
                    echo "Invalid file type! Only JPG, JPEG, PNG, and GIF files are allowed.";
                    exit;
                }
            }


    try {
        if($imagePath !=NULL){

        $sql = "UPDATE products SET product_name = :product_name, description = :description, updated_at=NOW(), image= :imagePath WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":imagePath", $imagePath, PDO::PARAM_STR);

    }
        else if($imagePath == NULL){
            $sql="UPDATE products set product_name = :product_name, description = :description, updated_at=NOW() WHERE id = :id"; 
            $stmt = $conn->prepare($sql);
        }
        $stmt->bindParam(':product_name', $product_name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to user list
        header("Location: view.php");
        exit();
    } catch (PDOException $e) {
        header("Location: editProduct.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body{
        background-color:#2c3e50;
        height:100vh;
        display: flex;
        align-items: center;
        justify-content: center;
     flex-direction: column;
    }
    .insert{
    background-color:white  ;
    height: 450px;
    border-radius: 10px;
    width:400px;
    padding: 10px;
    }
    .before{
        margin-left: 140px;
        font-size:18px;
        color:#2c3e50;
    }
    .head{
        font-size: 28px;
        text-align: center;
        margin-top: 40px;
        margin-bottom: 40px;
        color:#2c3e50;
    }
    .head::after{
        content: "";
        display: block;
        background-color: #2c3e50;
        height: 2px;
        margin: 0 auto;
    }
    input{
        font-size:22px;
        width:320px;
        margin-left: 30px;
        margin-right: 20px;
    }
    .form{
        display: flex;
        flex-direction: column;
    }
    .form-down{
        margin-top: 20px;
    }
    textarea{
        width:320px;
        margin-left: 30px;
        margin-right: 20px;
        max-width: 320px;
        max-height: 58px;
    }
    #sub{
       margin-left:135px;
       margin-top: 30px;
       padding:5px;
       width: 90px;
       height:50px;
       border:none;
       background:#2c3e50;
       color:white;
       border-radius: 8px;
       cursor:pointer;
    }
    #sub:hover{
        background-color:rgb(51, 83, 114);
        color:white;
    }
    input[type="file"]{
        font-size: 16px;
        margin-left: 120px;
    }
    .Image{
        margin-left: 120px;
    }
</style>
<body>
    <div class="insert">
        <div class="head">Edit Product</div>
        <div class="form">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="name" class="before">Product Name:</label>
                <input type="text" name="product_name" value="<?= $product['product_name']?>"required />
        </div>
        <div class="form form-down">
                <label for="description" class="before">Description txt:</label>
                <textarea name="description"></textarea></div>
                <div class="form form-down">
                <label for="image" class="before">Image:</label>
                <!-- Display Current Image -->
               <?php if (!empty($user['image'])): ?>
               <img src="<?= htmlspecialchars($product['image']) ?>" width="100" alt="Current Image" class="Image">
               <?php endif; ?>
               <input type="file" name="image"/></div>
                <button type="submit" id="sub">Update</button>
            </form>
        </div>
    </div>
</body>
</html>