<?php
include("select.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #34495e;
            color: white;
            padding-top: 20px;
            margin: 0;
        }

        .container {
            width: 90%;
            max-width: 1000px;
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
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .top-bar button:hover {
            background: rgba(32, 73, 104, 0.34);
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
            background: rgba(255, 255, 255, 0.2);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
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

        /* Media Query for smaller screens */
/* Default styles apply to larger screens */

/* Tablets (max-width: 1024px) */
@media (max-width: 1024px) {
    .container {
        width: 95%;
    }
    .top-bar {
        width: 95%;
    }
}

/* Mobile Phones (max-width: 768px) */
@media (max-width: 768px) {
    body {
        padding-top: 10px;
    }
    .container {
        width: 100%;
        padding: 15px;
    }
    .top-bar {
        flex-direction: column;
        align-items: center;
    }
    .top-bar button {
        width: 100%;
        margin-bottom: 10px;
    }
    table {
        font-size: 14px; /* Smaller font for smaller screens */
    }
    .action-buttons {
        flex-direction: column; /* Stack buttons vertically */
        gap: 5px;
    }
    .edit-btn, .delete-btn {
        padding: 8px;
        font-size: 12px;
    }
}

/* Small Phones (max-width: 480px) */
@media (max-width: 480px) {
    h2 {
        font-size: 20px;
    }
    th, td {
        padding: 8px;
    }
    .edit-btn, .delete-btn {
        font-size: 10px;
        padding: 5px;
    }
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
    <h2>Products List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Created_by</th>
                <th>Suppliers</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($suppliers) > 0): ?>
                <?php $id = 0; ?>
                <?php foreach ($suppliers as $supplier): ?>
                    <tr>
                        <td><?= ++$id; ?></td>
                        <td><?= htmlspecialchars($supplier['supplier_name'])?></td>
                        <td><?= htmlspecialchars($supplier['supplier_location'])?></td>
                        <td><?= htmlspecialchars($supplier['email'])?></td>
                        <td><?= htmlspecialchars($supplier['created_by'])?></td>
                        <td class="action-buttons">
                            <a href="edit.php?id=<?= $supplier['id'] ?>" class="edit-btn"><i class="fa fa-edit"></i> Edit</a>
                            <a href="delete.php?id=<?= $supplier['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?');"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No products yet</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
