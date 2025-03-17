<?php
include("../database/connection.php");
include("select.php");

// Fetch all suppliers to map IDs to names
$supplierMap = [];
try {
    $supplierQuery = "SELECT * FROM supplier";
    $stmt = $conn->prepare($supplierQuery);
    $stmt->execute();
    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($suppliers as $supplier) {
        $supplierMap[$supplier['id']] = $supplier['supplier_name'];
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            background-color: #34495e;
            color: white;
            padding-top: 20px;
        }
        .container {
            width: 90%;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            overflow-x: auto;
        }
        .top-bar {
            width: 90%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .top-bar button {
            background: #d35400;
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        .top-bar button:hover {
            background: rgba(32, 73, 104, 0.34);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.2);
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background: #2c3e50;
            color: #ecf0f1;
        }
        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.1);
        }
        tr:hover {
            background: rgba(255, 255, 255, 0.3);
            transition: 0.3s;
        }
        .product-image {
            width: 100px;
            height: auto;
            border-radius: 5px;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            text-align: center;
        }
        .modal-content {
            margin-top: 5%;
            max-width: 90%;
            max-height: 80vh;
            border-radius: 10px;
        }
        .close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
        }
        .edit-btn,.delete-btn{
            color: #fff;
            text-decoration: none;
            padding: 8px;
            border-radius: 8px;
        }
        .edit-btn{
            padding-left: 10px;
            padding-right: 10px;
            background-color: rgb(49, 122, 199);
        }
        .edit-btn:hover{
            background-color:rgba(49, 122 199 0.66);
        }
        .delete-btn{
            background-color: red;
        }
        .delete-btn:hover{
            background-color: rgba(255, 0, 0, 0.66);
        }
        /* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    text-align: center;
}

.modal-content {
    margin-top: 5%;
    max-width: 90%;
    max-height: 80vh;
    border-radius: 10px;
}

.close {
    position: absolute;
    top: 20px;
    right: 30px;
    color: white;
    font-size: 35px;
    font-weight: bold;
    cursor: pointer;
}
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }
            .top-bar button {
                padding: 10px 14px;
                font-size: 14px;
            }
            table {
                table-layout: fixed;
                overflow-x: auto;
                white-space: nowrap;
            }
            th, td {
               font-size: 8px !important;
               padding:6px !important;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

            .product-image {
                width: 75px;
            }
        }
        @media (max-width: 480px) {
            .container {
                width: 100%;
                padding: 10px;
            }
            .top-bar {
                flex-direction: column;
                align-items: flex-start;
            }
            .top-bar button {
                display: block !important;
                margin: 0 auto  !important;
                font-size: 14px;
                padding: 8px;
            }
            table {
                table-layout: fixed;
                overflow-x: auto;
                white-space: nowrap;
            }
            th, td {
                padding: 5px !important;
               font-size: 5px !important;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;

}

            .product-image {
                width: 60px;
            }
        }
    </style>
</head>
<body>

<div class="top-bar">
    <button onclick="window.location.href='../dash/dashboardP.php'">
        <i class="fa fa-arrow-left"></i> Back
    </button>
</div>

<div class="container">
    <h2>Products List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Prod.Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Created_By</th>
                <th>Suppliers</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $index => $product): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                       
 <td>
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= htmlspecialchars($product['image']) ?>" class="product-image" alt="Product Image">
                        <div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImg">
                        </div>
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
                        <td><?= htmlspecialchars($product['created_by']) ?></td>
                        <td>
                            <?= isset($supplierMap[$product['suppliers']]) ? htmlspecialchars($supplierMap[$product['suppliers']]) : "No Supplier" ?>
                        </td>
                        <td class="action">
                            <a href="editProduct.php?id=<?= $product['id'] ?>" class="edit-btn"><i class="fa fa-edit"></i> Edit</a>
                            <a href="deleteProduct.php?id=<?= $product['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?');"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No products yet</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script>
     const images = document.querySelectorAll('.product-image');
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImg");
    const closeBtn = document.querySelector(".close");

    // Loop through images and add click event
    images.forEach(img => {
        img.addEventListener("click", function() {
            modal.style.display = "block";
            modalImg.src = this.src;
        });
    });

    // Close modal when clicking outside the image or on the close button
    document.addEventListener("click", function(event) {
        if (event.target === modal || event.target === closeBtn) {
            modal.style.display = "none";
        }
    });

</script>
</body>
</html>
