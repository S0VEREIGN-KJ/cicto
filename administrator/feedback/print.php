<?php
require_once('../tcpdf/tcpdf.php');
include ('db_conn.php');

// Fetch feedback data
$query = "SELECT feedback, full_name FROM feedback"; // Update with your table and column names
$result = $conn->query($query);

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('City Information and Communications Technology');
$pdf->SetTitle('Feedback Print');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Add logo
$pdf->Image('../images/cicto_logo.png', 10, 18, 25, '', 'PNG');

// Add title
$pdf->SetXY(40, 28);  // Set position for title text
$pdf->SetFont('helvetica', 'B', 14);  // Bold font for header
$pdf->MultiCell(0, 10, 'City Information and Communications Technology', 0, 'L');
$pdf->SetFont('helvetica', 'I', 12);  // Italic font for subtitle
$pdf->MultiCell(0, 10, 'FEEDBACK', 0, 'C');

// Generate HTML for the PDF
$html = '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse; width:100%;">
            <thead>
                <tr style="background-color:#f2f2f2; font-weight:bold; text-align:center;">
                    <th width="80%" style="border: 1px solid #000;">Feedback to the Service / Ticket</th>
                    <th width="20%" style="border: 1px solid #000;">Technician</th>
                </tr>
            </thead>
            <tbody>';

// Populate table rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td style="border: 1px solid #000; padding: 5px; width: 80%;">' . htmlspecialchars($row['feedback']) . '</td>
                    <td style="border: 1px solid #000; padding: 5px; width: 20%;">' . htmlspecialchars($row['full_name']) . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr>
                <td colspan="2" style="text-align:center; border: 1px solid #000; padding: 5px;">No feedback available.</td>
              </tr>';
}

$html .= '</tbody>
        </table>';

// Write the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('feedback_report.pdf', 'I');

// Close the database connection
$conn->close();
?>
