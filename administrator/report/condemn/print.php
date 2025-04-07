<?php
require_once('../tcpdf/tcpdf.php');

// Receive the POST data from JavaScript
$technician_name = isset($_POST['technician_name']) ? $_POST['technician_name'] : 'N/A';
$phone = isset($_POST['phone']) ? $_POST['phone'] : 'N/A';
$email = isset($_POST['email']) ? $_POST['email'] : 'N/A';
$total_tickets = isset($_POST['total_tickets']) ? $_POST['total_tickets'] : '0';
$repaired_tickets = isset($_POST['repaired_tickets']) ? $_POST['repaired_tickets'] : '0';
$closed_tickets = isset($_POST['closed_tickets']) ? $_POST['closed_tickets'] : '0';
$in_progress_tickets = isset($_POST['in_progress_tickets']) ? $_POST['in_progress_tickets'] : '0';
$formatted_date_range = isset($_POST['formattedDateRange']) ? $_POST['formattedDateRange'] : 'N/A'; // Receive formatted date range

// Create a new TCPDF object
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ticket System');
$pdf->SetTitle('Technician Report');
$pdf->SetSubject('Technician Ticket Statistics');
$pdf->SetMargins(15, 15, 15); // Set page margins

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

$pdf->Image('../../images/cicto_logo.png', 10,18, 25, '', 'PNG');

// Set the position for the title text
$pdf->SetXY(40, 28);  // Set the position for the text (X = 40, Y = 28)
$pdf->SetFont('helvetica', 'B', 14);  // Bold font for the header
$pdf->MultiCell(0, 10, 'City Information and Communications Technology', 0, 'L');


// Add title
$pdf->SetFont('helvetica', 'I', 12);  // Italic font for the subtitle
$pdf->Cell(0, 10, 'Technician Details and Ticket Statistics', 0, 1, 'C');

// Display the selected date range with full month name
$pdf->Ln(10); // Line break
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(40, 10, 'Selected Date Range:', 1, 0, 'C');
$pdf->Cell(0, 10, $formatted_date_range, 1, 1, 'C');

// Technician Details Table
$pdf->Ln(10); // Line break
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(40, 10, 'Technician Name:', 1, 0, 'C');
$pdf->Cell(0, 10, $technician_name, 1, 1, 'C');

$pdf->Cell(40, 10, 'Phone:', 1, 0, 'C');
$pdf->Cell(0, 10, $phone, 1, 1, 'C');

$pdf->Cell(40, 10, 'Email:', 1, 0, 'C');
$pdf->Cell(0, 10, $email, 1, 1, 'C');

// Ticket Statistics Table
$pdf->Ln(10); // Line break
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(40, 10, 'Total Tickets:', 1, 0, 'C');
$pdf->Cell(0, 10, $total_tickets, 1, 1, 'C');

$pdf->Cell(40, 10, 'Repaired Tickets:', 1, 0, 'C');
$pdf->Cell(0, 10, $repaired_tickets, 1, 1, 'C');

$pdf->Cell(40, 10, 'Closed Tickets:', 1, 0, 'C');
$pdf->Cell(0, 10, $closed_tickets, 1, 1, 'C');

$pdf->Cell(40, 10, 'In Progress Tickets:', 1, 0, 'C');
$pdf->Cell(0, 10, $in_progress_tickets, 1, 1, 'C');

// Add footer text (Technician name or Department Head)
$pdf->Ln(50); // Line break
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'ERWIN G. MANADAO', 0, 1, 'C');
$pdf->SetFont('helvetica', 'I', 10); // Name centered
$pdf->Cell(0, 10, 'CICTO Department Head', 0, 1, 'C'); // Position centered

// Output the PDF to the browser
$pdf->Output('technician_report.pdf', 'I');


?>
