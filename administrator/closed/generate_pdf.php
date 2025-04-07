<?php
require_once('../tcpdf/tcpdf.php'); // Include TCPDF library
include('db_conn.php');

// Fetching filter date from GET parameters
$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'datetime_req';
$order = isset($_GET['order']) && $_GET['order'] === 'ASC' ? 'ASC' : 'DESC';

// SQL Query
$sql = "SELECT * FROM ticket WHERE status = 'Closed'";
if ($filter_date) {
    $sql .= " AND DATE(datetime_req) = '$filter_date'";
}
$sql .= " ORDER BY $sort $order";

$result = $conn->query($sql);
$total_tickets = $result->num_rows;

// Format filter date and current date
$month_name = $filter_date ? date('F Y', strtotime($filter_date)) : 'All Dates';
$current_date = date('F j, Y'); // Current date in format "Month Day, Year"


// Initialize TCPDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Filtered Closed Tickets');



// Set header with generated date (Full month name, day, and year)
$pdf->SetHeaderData('', 0, 'Filtered Closed Tickets', 'Generated on: ' . $current_date);
$pdf->setHeaderFont(['helvetica', '', 12]);
$pdf->setFooterFont(['helvetica', '', 10]);
$pdf->SetMargins(10, 20, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);


$pdf->Image('../images/cicto_logo.png', 25,15, 15, '', 'PNG');

// Set the position for the title text
$pdf->SetXY(40, 18);  // Set the position for the text (X = 40, Y = 28)
$pdf->SetFont('helvetica', 'B', 14);  // Bold font for the header
$pdf->MultiCell(0, 10, 'City Information and Communications Technology', 0, 'L');
$pdf->SetFont('helvetica', 'I', 12);  // Italic font for the subtitle

// Start creating HTML content for the PDF
$html = '<h1 style="text-align: center;font-size:15pt;">Filtered Closed Tickets</h1>';

// **New logic** to show the Date/Time Requested from tickets
if ($filter_date) {
    // Use the first ticket's datetime_req as the filter date for the header
    $row = $result->fetch_assoc();
    $filter_date = date('F j, Y', strtotime($row['datetime_req']));
    $html .= '<p style="text-align: center;">Filter Date: ' . $filter_date . '</p>';
} else {
    $html .= '<p style="text-align: center;">Filter Date: All Dates</p>';
}

$html .= '<p style="text-align: center;font-size: 15pt; font-weight:bold;text-decoration: underline;">Total Tickets: ' . $total_tickets . '</p>';
$html .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; font-size: 10px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Ticket #</th>
            <th>Serial #</th>
            <th>Date/Time Requested</th>
            <th>Office</th>
            <th>Requester Name</th>
            <th>Unit</th>
            <th>Category</th>
            <th>Assigned To</th>
            <th>Priority</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>';

// Add ticket data to the table
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
       $priorityColor = ($row['priority'] === 'High') ? '#FF0000' : (($row['priority'] === 'Medium') ? '#FFA500' : '#E6B800 ');
        $html .= '<tr>
            <td>' . $row['ticket_number'] . '</td>
            <td>' . $row['serial_number'] . '</td>
            <td>' . date('m/d/Y - g:i A', strtotime($row['datetime_req'])) . '</td>
            <td>' . $row['office'] . '</td>
            <td>' . $row['req_name'] . '</td>
            <td>' . $row['unit'] . '</td>
            <td>' . $row['category'] . '</td>
            <td>' . $row['assigned_name'] . '</td>
            <td style="color:' . $priorityColor . ';">' . $row['priority'] . '</td>
            <td>' . $row['status'] . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="10" style="text-align: center;">No data found</td></tr>';
}

$html .= '</tbody></table>';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF
$pdf->Output('filtered_closed_tickets.pdf', 'I');

// Close database connection
$conn->close();
?>
