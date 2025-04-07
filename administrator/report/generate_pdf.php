<?php
require_once('tcpdf/tcpdf.php'); // Include TCPDF library

// Retrieve the start and end dates from the URL parameters
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

// Convert the start and end dates to readable month/year format
$startMonth = date("F", strtotime($startDate)); // Start month name
$startYear = date("Y", strtotime($startDate));  // Start year
$endMonth = date("F", strtotime($endDate));     // End month name
$endYear = date("Y", strtotime($endDate));      // End year

// Initialize the report data (this would be fetched from your database)
$report = [
    'totalTickets' => 0,
    'repairedTickets' => 0,
    'closedTickets' => 0,
    'mostTicketsOffice' => 'N/A',
    'mostTicketsSerial' => 'N/A',
    'mostCommonCategory' => 'N/A',
    'mostCommonUnit' => 'N/A',
    'unitCounts' => [],
    'categoryCounts' => [],
    'officeCounts' => [],
];

// Connect to the database
include('db_conn.php');

// Prepare the SQL statement to get all tickets within the date range
$sql = "SELECT * FROM ticket WHERE datetime_req BETWEEN ? AND ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $startDate, $endDate);  // "ss" means two strings
$stmt->execute();
$result = $stmt->get_result();

// Initialize variables for counts
$officeTicketCount = [];
$serialTicketCount = [];
$categoryCount = [];
$unitCount = [];
$totalTickets = 0;
$repairedTickets = 0;
$closedTickets = 0;

// Process the tickets and generate the report data
if ($result->num_rows > 0) {
    while ($ticket = $result->fetch_assoc()) {
        $totalTickets++;

        // Count repaired and closed tickets
        if ($ticket['status'] == 'Repaired') {
            $repairedTickets++;
        } elseif ($ticket['status'] == 'Closed') {
            $closedTickets++;
        }

        // Count tickets per office
        $office = $ticket['office'];
        if (isset($officeTicketCount[$office])) {
            $officeTicketCount[$office]++;
        } else {
            $officeTicketCount[$office] = 1;
        }

        // Count tickets per serial number
        $serial = $ticket['serial_number'];
        if (isset($serialTicketCount[$serial])) {
            $serialTicketCount[$serial]++;
        } else {
            $serialTicketCount[$serial] = 1;
        }

        // Count category
        $category = $ticket['category'];
        if (isset($categoryCount[$category])) {
            $categoryCount[$category]++;
        } else {
            $categoryCount[$category] = 1;
        }

        // Count unit types
        $unit = $ticket['unit'];
        if (isset($unitCount[$unit])) {
            $unitCount[$unit]++;
        } else {
            $unitCount[$unit] = 1;
        }
    }

    // Sort counts by highest first
    arsort($officeTicketCount);
    arsort($categoryCount);
    arsort($unitCount);

    // Determine the most frequent values
    $mostTicketsOffice = array_keys($officeTicketCount)[0];
    $mostTicketsSerial = array_keys($serialTicketCount, max($serialTicketCount))[0];
    $mostCommonCategory = array_keys($categoryCount)[0];
    $mostCommonUnit = array_keys($unitCount)[0];

    // Prepare the final report data
    $report = [
        'totalTickets' => $totalTickets,
        'repairedTickets' => $repairedTickets,
        'closedTickets' => $closedTickets,
        'mostTicketsOffice' => $mostTicketsOffice,
        'mostTicketsSerial' => $mostTicketsSerial,
        'mostCommonCategory' => $mostCommonCategory,
        'mostCommonUnit' => $mostCommonUnit,
        'unitCounts' => $unitCount,
        'categoryCounts' => $categoryCount,
        'officeCounts' => $officeTicketCount,
    ];
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Create new PDF document
$pdf = new TCPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

$pdf->Image('../images/cicto_logo.png', 10,18, 25, '', 'PNG');


// Set document information
$pdf->SetAuthor('City Information and Communications Technology');
$pdf->SetTitle('Ticket');

// Set the position for the title text
$pdf->SetXY(40, 28);  // Set the position for the text (X = 40, Y = 28)
$pdf->SetFont('helvetica', 'B', 14);  // Bold font for the header
$pdf->MultiCell(0, 10, 'City Information and Communications Technology', 0, 'L');
$pdf->SetFont('helvetica', 'I', 12);  // Italic font for the subtitle
$pdf->MultiCell(0, 10, 'TICKET REPORT', 0, 'C');


// Add the header with the month name
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, "{$startMonth} {$startYear} to {$endMonth} {$endYear}", 0, 1, 'C'); // Dynamically set the title based on the month and year

// Add the summary table
$pdf->SetFont('helvetica', '', 12);
$pdf->Ln(5);
$pdf->Cell(70, 10, "Total Tickets:", 1);
$pdf->Cell(0, 10, $report['totalTickets'], 1, 1);
$pdf->Cell(70, 10, "Repaired Tickets:", 1);
$pdf->Cell(0, 10, $report['repairedTickets'], 1, 1);
$pdf->Cell(70, 10, "Closed Tickets:", 1);
$pdf->Cell(0, 10, $report['closedTickets'], 1, 1);
$pdf->Cell(70, 10, "Office with Most Tickets:", 1);
$pdf->Cell(0, 10, $report['mostTicketsOffice'], 1, 1);
$pdf->Cell(70, 10, "Serial Number with Most Tickets:", 1);
$pdf->Cell(0, 10, $report['mostTicketsSerial'], 1, 1);
$pdf->Cell(70, 10, "Most Common Category:", 1);
$pdf->Cell(0, 10, $report['mostCommonCategory'], 1, 1);
$pdf->Cell(70, 10, "Most Common Unit:", 1);
$pdf->Cell(0, 10, $report['mostCommonUnit'], 1, 1);

// Add the office ticket counts table
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'BU', 12); // 'BU' for bold and underline
$pdf->Cell(0, 10, 'Offices Ranked by Ticket Count', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 10);
foreach ($report['officeCounts'] as $office => $count) {
    $pdf->Cell(95, 10, $office, 1);
    $pdf->Cell(0, 10, $count, 1, 1);
}

// Add the unit counts table
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'BU', 12); 
$pdf->Cell(0, 10, 'Units by Count', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 10);
foreach ($report['unitCounts'] as $unit => $count) {
    $pdf->Cell(95, 10, $unit, 1);
    $pdf->Cell(0, 10, $count, 1, 1);
}

// Add the category counts table
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'BU', 12); 
$pdf->Cell(0, 10, 'Categories by Count', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 10);
foreach ($report['categoryCounts'] as $category => $count) {
    $pdf->Cell(95, 10, $category, 1);
    $pdf->Cell(0, 10, $count, 1, 1);
}

// Output the PDF
$pdf->Output('ticket_report.pdf', 'I'); // 'I' for inline display in browser, 'D' for download

?>
