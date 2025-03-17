<?php
require('../fpdf/fpdf.php');

// Create instance of FPDF
$pdf = new FPDF();
$pdf->SetFont('Arial', 'B', 16);  // Set font

// Add a page
$pdf->AddPage();

// Title of the document
$pdf->Cell(200, 10, 'Inventory Products List', 0, 1, 'C');

// Fetch data from the database
// Assuming $conn is your PDO connection
include('../database/connection.php');

try {
    $sql = "SELECT p.id, p.product_name, p.description, p.image, u.firstName
            FROM products p
            JOIN users u ON p.created_by = u.id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Table Header
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'ID', 1, 0, 'C'); // Minimized column width
    $pdf->Cell(50, 10, 'Product Name', 1, 0, 'C'); // Minimized column width
    $pdf->Cell(30, 10, 'Description', 1, 0, 'C'); // Minimized column width
    $pdf->Cell(30, 10, 'Created By', 1, 0, 'C'); // Minimized column width
    $pdf->Cell(50, 10, 'Image Path (Src)', 1, 1, 'C');  // Larger column for Image Path

    // Table Data
    $pdf->SetFont('Arial', '', 10);
    foreach ($products as $product) {
        $pdf->Cell(30, 10, $product['id'], 1, 0, 'C');
        $pdf->Cell(50, 10, $product['product_name'], 1, 0, 'C');
        $pdf->Cell(30, 10, $product['description'], 1, 0, 'C');
        $pdf->Cell(30, 10, $product['firstName'], 1, 0, 'C');
        
        // Display the image path (src)
        $pdf->Cell(50, 10, $product['image'], 1, 1, 'C');  // The image path stored in the database
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Output the PDF to the browser
$pdf->Output();
?>
