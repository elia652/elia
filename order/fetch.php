<?php
include("select.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products and Suppliers</title>
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
            width: 80%;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .top-bar {
            width: 80%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .top-bar button {
            background: #d35400;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        .top-bar button:hover {
            background:rgba(32, 73, 104, 0.34);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.2);
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background: #2c3e50;
            color: #ecf0f1;
            text-transform: uppercase;
            letter-spacing: 1px;
        } 
        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.1);
        } 
        tr:hover {
            background: rgba(255, 255, 255, 0.3);
            transition: 0.3s;
        }
        .action-buttons {
            display: flex;
            flex-direction: row;
            gap: 10px;
            justify-content: center;
        }
        .edit-btn, .delete-btn {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
        }
        .edit-btn {
            background: #3498db;
            color: white;
        }
        .edit-btn:hover {
            background: #2980b9;
        }
        .delete-btn {
            background: #e74c3c;
            color: white;
        }
        .delete-btn:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>

<div class="top-bar">
    <button onclick="window.location.href='../dash/dashboardS.php'">
        <i class="fa fa-arrow-left"></i> Back
    </button>
</div>

<div class="container">
    <h2>Products and Suppliers</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Supplier</th>
                <th>Product</th>
                <th>Quantity Ordered</th>
                <th>Quantity Received</th>
                <th>Quantity Remaining</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($results) > 0): ?>
                <?php $id = 0; ?>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?= ++$id; ?></td>
                        <td><?= htmlspecialchars($result['supplier_name']) ?></td>
                        <td><?= htmlspecialchars($result['product_name']) ?></td>
                        <td><?= htmlspecialchars($result['quantity_ordered']) ?></td>
                        <td><?= htmlspecialchars($result['quantity_received']) ?></td>
                        <td><?= htmlspecialchars($result['quantity_remaining']) ?></td>
                        <td><?= htmlspecialchars($result['status']) ?></td>
                        <td><?= htmlspecialchars($result['created_by']) ?></td>
                        <td class="action-buttons">
                            <a href="edit.php?id=<?= $result['id'] ?>" class="edit-btn"><i class="fa fa-edit"></i> Edit</a>
                            <a href="delete.php?id=<?= $result['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?');"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No products yet</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
