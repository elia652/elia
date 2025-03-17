<?php
// Include the FPDF library
require('../fpdf/fpdf.php');

// Create instance of FPDF
$pdf = new FPDF();
$pdf->SetFont('Arial', 'B', 16);  // Set font

// Add a page
$pdf->AddPage();

// Title of the document
$pdf->Cell(200, 10, 'Inventory Suppliers List', 0, 1, 'C');

// Fetch data from the database
include('../database/connection.php');

try {
    $sql = "SELECT p.id, p.supplier_name, p.supplier_location, p.email, u.firstName
            FROM supplier p
            JOIN users u ON p.created_by = u.id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Table Header
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(20, 10, 'ID', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Supplier Name', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Location', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Email', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Created By', 1, 1, 'C');

    // Table Data
    $pdf->SetFont('Arial', '', 12);
    foreach ($suppliers as $supplier) {
        $pdf->Cell(20, 10, $supplier['id'], 1, 0, 'C');
        $pdf->Cell(50, 10, $supplier['supplier_name'], 1, 0, 'C');
        $pdf->Cell(50, 10, $supplier['supplier_location'], 1, 0, 'C');
        $pdf->Cell(50, 10, $supplier['email'], 1, 0, 'C');
        $pdf->Cell(30, 10, $supplier['firstName'], 1, 1, 'C');
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Output the PDF to the browser
$pdf->Output();
?>
