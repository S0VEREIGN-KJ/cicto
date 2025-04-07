<?php
// Include the TCPDF library
require_once('tcpdf/tcpdf.php');
include('db_conn.php');

// Get the date range from the URL
$startDate = $_GET['startDate'] ?? '';
$endDate = $_GET['endDate'] ?? '';

// Check if both startDate and endDate are set
if (!empty($startDate) && !empty($endDate)) {

    // Prepare the SQL statement to get all tickets within the date range
    $sql = "SELECT * FROM ticket WHERE datetime_req BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate); // "ss" means two strings

    // Execute and fetch results
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // Initialize variables to hold report data
        $totalTickets = 0;
        $repairedTickets = 0;
        $closedTickets = 0;
        $officeTicketCount = [];
        $serialTicketCount = [];
        $categoryCount = [];
        $unitCount = [];

        // Loop through the tickets and collect statistics
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
            $officeTicketCount[$office] = ($officeTicketCount[$office] ?? 0) + 1;

            // Count tickets per serial number
            $serial = $ticket['serial_number'];
            $serialTicketCount[$serial] = ($serialTicketCount[$serial] ?? 0) + 1;

            // Count category
            $category = $ticket['category'];
            $categoryCount[$category] = ($categoryCount[$category] ?? 0) + 1;

            // Count unit types
            $unit = $ticket['unit'];
            $unitCount[$unit] = ($unitCount[$unit] ?? 0) + 1;
        }

        // Determine the most frequent occurrences
        $mostTicketsOffice = array_keys($officeTicketCount, max($officeTicketCount))[0] ?? 'N/A';
        $mostTicketsSerial = array_keys($serialTicketCount, max($serialTicketCount))[0] ?? 'N/A';
        $mostCommonCategory = array_keys($categoryCount, max($categoryCount))[0] ?? 'N/A';
        $mostCommonUnit = array_keys($unitCount, max($unitCount))[0] ?? 'N/A';

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        // Create a new TCPDF instance
        $pdf = new TCPDF();

        // Add a page to the PDF
        $pdf->AddPage();

        // Set some basic information
        $pdf->SetFont('helvetica', '', 12);

        // Add the report header
        $pdf->Cell(0, 10, "Ticket Report from {$startDate} to {$endDate}", 0, 1, 'C');
        $pdf->Ln(5);

        // Report summary in the PDF
        $pdf->Cell(40, 10, "Total Tickets: " . $totalTickets);
        $pdf->Ln();
        $pdf->Cell(40, 10, "Repaired Tickets: " . $repairedTickets);
        $pdf->Ln();
        $pdf->Cell(40, 10, "Closed Tickets: " . $closedTickets);
        $pdf->Ln();
        $pdf->Cell(40, 10, "Most Tickets Office: " . $mostTicketsOffice);
        $pdf->Ln();
        $pdf->Cell(40, 10, "Most Tickets Serial: " . $mostTicketsSerial);
        $pdf->Ln();
        $pdf->Cell(40, 10, "Most Common Category: " . $mostCommonCategory);
        $pdf->Ln();
        $pdf->Cell(40, 10, "Most Common Unit: " . $mostCommonUnit);
        $pdf->Ln(10);

        // Add table headers for ticket list
        $pdf->Cell(30, 10, 'Ticket ID', 1);
        $pdf->Cell(30, 10, 'Serial Number', 1);
        $pdf->Cell(30, 10, 'Date', 1);
        $pdf->Cell(30, 10, 'Status', 1);
        $pdf->Cell(30, 10, 'Technician', 1);
        $pdf->Cell(30, 10, 'Category', 1);
        $pdf->Cell(30, 10, 'Unit', 1);
        $pdf->Ln();

        // Output each ticket row in the table
        while ($ticket = $result->fetch_assoc()) {
            $pdf->Cell(30, 10, $ticket['ticket_number'], 1);
            $pdf->Cell(30, 10, $ticket['serial_number'], 1);
            $pdf->Cell(30, 10, $ticket['datetime_req'], 1);
            $pdf->Cell(30, 10, $ticket['status'], 1);
            $pdf->Cell(30, 10, $ticket['assigned_name'], 1);
            $pdf->Cell(30, 10, $ticket['category'], 1);  // Display category
            $pdf->Cell(30, 10, $ticket['unit'], 1);      // Display unit
            $pdf->Ln();
        }

        // Output the PDF
        $pdf->Output('ticket_report_invoice.pdf', 'I');  // 'I' for inline display (browser view)

    } else {
        echo "No tickets found in the selected date range.";
    }

} else {
    echo "Please provide a valid date range.";
}
?>
