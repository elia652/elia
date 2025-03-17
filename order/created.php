<?php 
include("../database/connection.php");
include("../products/select.php");

try {
    $query = "SELECT * FROM supplier";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = trim($_POST['supplier_name']);
    $quantity = trim($_POST['quantity']);
    $product = trim($_POST['product_name']);
    $status="pending";
    $sql = "INSERT INTO product_supplier (supplier, product, quantity_ordered, status,created_by) VALUES (?, ?, ?,?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(1, $name, PDO::PARAM_INT);
    $stmt->bindParam(2, $product, PDO::PARAM_INT);
    $stmt->bindParam(3, $quantity, PDO::PARAM_INT);
    $stmt->bindParam(5, $id, PDO::PARAM_INT);
    $stmt->bindParam(4, $status, PDO::PARAM_STR);


    $supp = $stmt->execute();
    
    $_SESSION['supp_status'] = $supp; // ✅ Store result in session

    header("Location: fetch.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Product</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #34495e;
            padding-left: 200px;
            color: white;
        }
        .order-section {
            border: 1px solid #ddd;
            border-radius: 5px;
            display: inline-block;
            width: 800px;
            padding: 10px;
            margin-bottom: 10px;
            background: #2c3e50;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .add-btn {
            background-color: rgb(230, 123, 46);
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        h3 {
            font-size: 22px;
        }
        .input {
            float: right;
        }
        .delete{
            margin-top: 10px;;
        }
        .button{
            margin:0 auto;
        }
    </style>
</head>
<body>

<h3>+ Order Product</h3>

    <div id="order-container">
        <div class="order-section">
            <form action="" method="POST">
                <div class="product">
                    <label>PRODUCT NAME:</label>
                    <select class="product-dropdown" name="product_name">
                        <option value="">Select Product</option>
                        <?php foreach($products as $product) { ?>
                            <option value="<?= htmlspecialchars($product['id']) ?>">
                                <?= htmlspecialchars($product['product_name']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div> 
                <div class="supplier">
                    <span>Supplier Name</span>
                    <select name="supplier_name">
                    <?php foreach($suppliers as $supplier){?>
                        <option value="<?= htmlspecialchars($supplier['id'])?>">
                            <?= htmlspecialchars($supplier['supplier_name'])?>
                        </option>
                        <?php } ?>
                    </select>
                    <div class="input">
                        <label for="quantity">Quantity:</label>
                        <input type="number" class="quantity" name="quantity" placeholder="Enter quantity...">
                    </div>
                </div>
                <button class="add-btn button" type="submit" >Submit</button>

            </form> <!-- ✅ Fixed form placement -->
            <button type="button" class="delete" >Delete</button>

        </div>
    </div>
    <!-- ✅ Ensure the button is outside the form -->
    <button class="add-btn" id="add-product" type="button">Add Another Product</button>
    <script>
        let y='{"name":"ali", "age":"18","origin":"lebanese"}';
        let x=JSON.parse(y);
        console.log(x);
     
        $(document).ready(function(){
            $("#add-product").click(function () {
                let newOrder = $(".order-section:first").clone();
                newOrder.find("input").val(""); // Clear input fields
                $("#order-container").append(newOrder);
            });
            // jQuery only binds events to elements that exist when the page first loads.
            $(document).on("click", ".delete",function(){
        $(this).closest(".order-section").remove();
    });
        });
      
           </script>

</body>
</html>
