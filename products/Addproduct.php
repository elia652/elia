<?php
include("../suppliers/select.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = htmlspecialchars($_POST['name']); // Prevent XSS
    $description = htmlspecialchars($_POST['description']);
    $suppliers = isset($_POST['suppliers']) ? json_encode($_POST['suppliers']) : json_encode([]);
    $imagePath = null;

    if (isset($_SESSION['user']['id'])) {
        $userId = $_SESSION['user']['id'];

        // Image Upload Logic
        if (!empty($_FILES["image"]["name"])) {
            $target_dir = "uploads/";
            $image_name = basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
            $newFileName = uniqid() . "_" . $image_name;
            $target_file = $target_dir . $newFileName;

            if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $imagePath = $target_file;
                    $_SESSION['image'] = $imagePath;
                } else {
                    die("Error uploading the file.");
                }
            } else {
                die("Invalid file type! Only JPG, JPEG, PNG, and GIF allowed.");
            }
        }

        // Insert Data into Database
        $sql = "INSERT INTO products (product_name, description, image, created_by, created_at, suppliers) 
                VALUES (?, ?, ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $imagePath, PDO::PARAM_STR);
        $stmt->bindParam(4, $userId, PDO::PARAM_INT);
        $stmt->bindParam(5, $suppliers, PDO::PARAM_STR); // Store JSON suppliers
        $stmt->execute();

        header("Location: view.php");
        exit;
    }
}

// Fetch Suppliers (No Need to Use Session)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: #2c3e50;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    font-family: Arial, sans-serif;
}

.insert {
    background-color: white;
    width: 100%;
    max-width: 450px;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.head {
    font-size: 28px;
    text-align: center;
    margin-bottom: 20px;
    color: #2c3e50;
    font-weight: bold;
}

.head::after {
    content: "";
    display: block;
    background-color: #2c3e50;
    height: 2px;
    width: 50%;
    margin: 0 auto;
}

.before {
    font-size: 18px;
    color: #2c3e50;
    margin-bottom: 8px;
    display: block;
}

input, textarea, select {
    font-size: 16px;
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
}

input[type="file"] {
    font-size: 14px;
    padding: 5px;
    margin-top: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
}

textarea {
    resize: vertical;
    height: 80px;
    max-height: 100px;
}

button[type="submit"] {
    width: 100%;
    padding: 12px;
    font-size: 18px;
    background-color: #2c3e50;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #34495e;
}

select[multiple] {
    height: 120px;
    background-color: #fff;
    border: 1px solid #ccc;
}

@media (max-width: 500px) {
    .insert {
        padding: 15px;
        width: 100%;
    }

    .head {
        font-size: 24px;
    }

    input, textarea, select, button {
        font-size: 14px;
    }
}
    </style>
</head>
<body>
    <div class="insert">
        <div class="head">Add Product</div>
        <div class="form">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="name" class="before">Product Name:</label>
                <input type="text" name="name" required />
                <label for="description" class="before">Description:</label>
                <textarea name="description"></textarea>

                <input type="file" name="image">
                <label for="suppliers" class="before">Suppliers</label>
                <select name="suppliers[]" multiple>
                    <?php foreach ($suppliers as $supplier): ?>
                        <option value="<?= htmlspecialchars($supplier['id']) ?>">
                            <?= htmlspecialchars($supplier['supplier_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" id="sub">Add</button>
            </form>
        </div>
    </div>
</body>
</html>
