<?php
// Include the FPDF library
require_once('db.php');
require('./fpdf/fpdf.php');

function generateInvoice($userId, $cartItems, $userDetails)
{
    // Create PDF instance
    $pdf = new FPDF();
    $pdf->addPage();

    // Add user details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'User Details:', 0, 1);
    $pdf->Cell(0, 10, 'Name: ' . $userDetails['FirstName'] . ' ' . $userDetails['LastName'], 0, 1);
    $pdf->Cell(0, 10, 'Email: ' . $userDetails['Email'], 0, 1);

    // Add order details
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Order Details:', 0, 1);

    foreach ($cartItems as $cartItem) {
        $pdf->Cell(0, 10, 'Product: ' . $cartItem['ProductName'], 0, 1);
        $pdf->Cell(0, 10, 'Price: $' . $cartItem['Price'], 0, 1);
        $pdf->Cell(0, 10, 'Quantity: ' . $cartItem['Quantity'], 0, 1);
        
        // Use Ln() to move to the next line after each set of information
        $pdf->Ln(5);
    }

    // Specify the path and filename for the PDF
    $pdfFilePath = '/Applications/xampp/htdocs/TrendTrove/invoice.pdf';

    // Output PDF to file
    $pdf->Output($pdfFilePath, 'F');

}

?>
