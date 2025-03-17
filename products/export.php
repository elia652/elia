<?php
include("../database/connection.php"); // Include your database connection

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=products_export.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Open output stream
$excel_output = fopen("php://output", "w");

// Column headers
fputcsv($excel_output, ["ID", "Product Name", "Description", "Image (Path)", "Creator"], "\t");

// Fetch data from the database
$sql = "SELECT p.id, p.product_name, p.description, p.image, u.firstName
        FROM products p
        JOIN users u ON p.created_by = u.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Write data to Excel file
foreach ($products as $row) {
    // Check if image exists and append the full image path (or use a placeholder)
/////////////////////////////////////////////////////////////////////////////////////////////baddak tghayer sater li ta7et
    $imagePath = !empty($row['image']) ? 'http://localhost/project/uploads/' . $row['image'] : 'No Image Available';
    // Update the row with the image source (path)
    $row['image'] = $imagePath;
    fputcsv($excel_output, $row, "\t");
}

// Close output stream
fclose($excel_output);
exit();
?>
