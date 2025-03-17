<?php
require('../fpdf/fpdf.php');

// Create instance of FPDF
$pdf = new FPDF();
$pdf->SetFont('Arial', 'B', 16);  // Set font

// Add a page
$pdf->AddPage();

// Title of the document
$pdf->Cell(200, 10, 'Inventory Users List', 0, 1, 'C');

// Fetch data from the database
// Assuming $conn is your PDO connection
include('../database/connection.php');

try {
    $sql = "SELECT * from users";
            
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Table Header
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, 'ID', 1, 0, 'C'); // Minimized column width
    $pdf->Cell(20, 10, 'FName', 1, 0, 'C'); // Minimized column width
    $pdf->Cell(20, 10, 'LName', 1, 0, 'C'); // Minimized column width
    $pdf->Cell(50, 10, 'Email', 1, 0, 'C'); // Minimized column width
    $pdf->Cell(30, 10, 'password', 1, 0, 'C'); // Minimized column width
    $pdf->Cell(50, 10, 'Image Path (Src)', 1, 1, 'C');  // Larger column for Image Path

    // Table Data
    $pdf->SetFont('Arial', '', 10);
    foreach ($products as $product) {
        $pdf->Cell(10, 10, $product['id'], 1, 0, 'C');
        $pdf->Cell(20, 10, $product['firstName'], 1, 0, 'C');
        $pdf->Cell(20, 10, $product['lastName'], 1, 0, 'C');
        $pdf->Cell(50, 10, $product['email'], 1, 0, 'C');
        $pdf->Cell(30, 10, $product['password'], 1, 0, 'C');
        
        // Display the image path (src)
        $pdf->Cell(50, 10, $product['image'], 1, 1, 'C');  // The image path stored in the database
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Output the PDF to the browser
$pdf->Output();
?>
