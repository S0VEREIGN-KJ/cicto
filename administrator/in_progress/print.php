<?php
require_once('../tcpdf/tcpdf.php');
include ('db_conn.php');

function getTicketData($ticket_number) {
    global $conn;
    // Query to fetch ticket data
    $sql = "SELECT * FROM ticket WHERE ticket_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ticket_number);  // Bind ticket_number as string
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if data is found
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();  // Return the ticket data
    } else {
        return null;  // Return null if no data found
    }
}

function getTechnicians() {
    global $conn;

    // Query to fetch technicians' names
    $sql = "SELECT full_name FROM technician";
    $result = $conn->query($sql);

    // Check if data is found
    $technicians = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $technicians[] = $row['full_name'];  // Add each technician's name to the array
        }
    }

    return $technicians;  // Return the list of technicians
}

// Assuming you passed the ticket number as a URL parameter
$ticket_number = $_GET['ticket_number'];  // Get ticket number from the URL

// Fetch ticket data and technicians
$ticket_data = getTicketData($ticket_number);
$technicians = getTechnicians();

// If ticket data is not found, you can handle it here (e.g., show an error page)
if (!$ticket_data) {
    echo "Ticket not found!";
    exit;
}

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('City Information and Communications Technology');
$pdf->SetTitle('Ticket');

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

// Set font
$pdf->SetFont('helvetica', '', 12);

$pdf->Image('../images/cicto_logo.png', 10,18, 25, '', 'PNG');

// Set the position for the title text
$pdf->SetXY(40, 28);  // Set the position for the text (X = 40, Y = 28)
$pdf->SetFont('helvetica', 'B', 14);  // Bold font for the header
$pdf->MultiCell(0, 10, 'City Information and Communications Technology', 0, 'L');
$pdf->SetFont('helvetica', 'I', 12);  // Italic font for the subtitle
$pdf->MultiCell(0, 10, 'JOB ORDER SLIP', 0, 'C');

// Generate HTML for the PDF
$html = '

    <h2>Job Order Details</h2>
    <table cellpadding="5" border="1" style="width: 100%;">
        <tr><td><strong>Ticket ID:</strong> ' . $ticket_data['ticket_number'] . '</td></tr>
        <tr><td><strong>Serial No.:</strong> ' . $ticket_data['serial_number'] . '</td></tr>
        <tr><td><strong>Date and Time Requested:</strong> ' . $ticket_data['datetime_req'] . '</td></tr>
        <tr><td><strong>Employee ID:</strong> ' . $ticket_data['id_number'] . '</td></tr>
        <tr><td><strong>Requester Name:</strong> ' . $ticket_data['req_name'] . '</td></tr>
        <tr><td><strong>Office:</strong> ' . $ticket_data['office'] . '</td></tr>
        <tr><td><strong>Phone Number:</strong> ' . $ticket_data['phone_number'] . '</td></tr>
        <tr><td><strong>Email Address:</strong> ' . $ticket_data['email'] . '</td></tr>
        <tr><td><strong>Subject:</strong> ' . $ticket_data['subject'] . '</td></tr>
        <tr><td><strong>Device:</strong> ' . $ticket_data['unit'] . '</td></tr>
        <tr><td><strong>Category:</strong> ' . $ticket_data['category'] . '</td></tr>
        <tr><td><strong>Accessories:</strong> ' . $ticket_data['accessories'] . '</td></tr>
        <tr><td><strong>Item Date Received:</strong> ' . $ticket_data['item_date_received'] . '</td></tr>
        <tr><td><strong>Received By:</strong> ' . $ticket_data['received_by'] . '</td></tr>
        <tr><td><strong>Name of Technician:</strong> ' . $ticket_data['assigned_name'] . '</td></tr>
        <tr><td><strong>Diagnostic:</strong> ' . $ticket_data['diagnostic'] . '</td></tr>
        <tr><td><strong>Priority:</strong> ' . $ticket_data['priority'] . '</td></tr>
        <tr><td><strong>Status:</strong> ' . $ticket_data['status'] . '</td></tr>
        <tr><td><strong>Recommendation:</strong> ' . $ticket_data['comment'] . '</td></tr>
        <tr><td><strong>Approved for Release by:</strong> ' . $ticket_data['approved_by'] . '</td></tr>
        <tr><td><strong>Release Date:</strong> ' . $ticket_data['release_date'] . '</td></tr>
    </table>
    
    <br>
    <div style="text-align: center; margin: 0; padding: 0;">
        <h3 style="margin: 0; padding: 0;">ERWIN G. MANADAO</h3>
        CICTO Department Head
    </div>

';

// Output the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('job_order_slip.pdf', 'I');
?>
