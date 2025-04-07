<?php

include('db_conn.php');

// Initialize the $report array with default values
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

// Check if both startDate and endDate are set and not empty
if (isset($_POST['startDate']) && isset($_POST['endDate']) && !empty($_POST['startDate']) && !empty($_POST['endDate'])) {

    // Retrieve POST data
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Prepare the SQL statement to get all tickets within the date range
     $sql = "SELECT * FROM ticket WHERE status IN ('Repaired', 'Closed') AND datetime_req BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);  // "ss" means two strings

    // Execute and fetch results
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize variables to hold report data
    $totalTickets = 0;
    $repairedTickets = 0;
    $closedTickets = 0;
    $officeTicketCount = [];
    $serialTicketCount = [];
    $categoryCount = [];
    $unitCount = [];

    
    // Check if there are results before processing
    if ($result->num_rows > 0) {
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
            $office = $ticket['office']; // Assuming 'office' field exists
            if (isset($officeTicketCount[$office])) {
                $officeTicketCount[$office]++;
            } else {
                $officeTicketCount[$office] = 1;
            }

            // Count tickets per serial number
            $serial = $ticket['serial_number']; // Assuming 'serial_number' field exists
            if (isset($serialTicketCount[$serial])) {
                $serialTicketCount[$serial]++;
            } else {
                $serialTicketCount[$serial] = 1;
            }

            // Count category (dynamically from database)
            $category = $ticket['category']; // Assuming 'category' field exists
            if (isset($categoryCount[$category])) {
                $categoryCount[$category]++;
            } else {
                $categoryCount[$category] = 1;
            }

            // Count unit types (dynamically from database)
            $unit = $ticket['unit']; // Assuming 'unit' field exists
            if (isset($unitCount[$unit])) {
                $unitCount[$unit]++;
            } else {
                $unitCount[$unit] = 1;
            }
        }

        // Sort office ticket counts from highest to lowest
        arsort($officeTicketCount);

        // Sort categories by count from highest to lowest
        arsort($categoryCount);

        // Sort units by count from highest to lowest
        arsort($unitCount);

        // Determine the most tickets office, category, and unit
        $mostTicketsOffice = array_keys($officeTicketCount)[0];
        $mostTicketsSerial = array_keys($serialTicketCount, max($serialTicketCount))[0];
        $mostCommonCategory = array_keys($categoryCount)[0];
        $mostCommonUnit = array_keys($unitCount)[0];

        // Prepare the report data
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

} else {
    // If no date range is selected, provide a message
    echo "<p>Please select a date range to generate the report.</p>";
}

// Output the report
if (isset($report)) {
    echo "<h3>Report for Tickets from {$startDate} to {$endDate}</h3>";

    echo "<table id='report-summary'>
            <thead>
                <tr>
                    <th>Total Tickets</th>
                    <th>Repaired Tickets</th>
                    <th>Closed Tickets</th>
                    <th>Office with the Most Tickets</th>
                    <th>Serial Number with the Most Tickets</th>
                    <th>Most Common Category</th>
                    <th>Most Common Unit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$report['totalTickets']}</td>
                    <td>{$report['repairedTickets']}</td>
                    <td>{$report['closedTickets']}</td>
                    <td>{$report['mostTicketsOffice']}</td>
                    <td>{$report['mostTicketsSerial']}</td>
                    <td>{$report['mostCommonCategory']}</td>
                    <td>{$report['mostCommonUnit']}</td>
                </tr>
            </tbody>
          </table>";

        // Add a button to print PDF
    echo "<br><br><button onclick=\"window.open('generate_pdf.php?startDate={$startDate}&endDate={$endDate}', '_blank');\">Print PDF</button>";
    // List office ticket counts
    echo "<h4>Offices Ranked by Ticket Count</h4>";
    echo "<table id='office-tickets'>";
    echo "<thead><tr><th>Office</th><th>Ticket Count</th></tr></thead>";
    echo "<tbody>";
    foreach ($report['officeCounts'] as $office => $count) {
        echo "<tr><td>{$office}</td><td>{$count}</td></tr>";
    }
    echo "</tbody></table>";

    // List unit counts
    echo "<h4>Units by Count</h4>";
    echo "<table id='unit-counts'>";
    echo "<thead><tr><th>Unit</th><th>Count</th></tr></thead>";
    echo "<tbody>";
    foreach ($report['unitCounts'] as $unit => $count) {
        echo "<tr><td>{$unit}</td><td>{$count}</td></tr>";
    }
    echo "</tbody></table>";

    // List category counts
    echo "<h4>Categories by Count</h4>";
    echo "<table id='category-counts'>";
    echo "<thead><tr><th>Category</th><th>Count</th></tr></thead>";
    echo "<tbody>";
    foreach ($report['categoryCounts'] as $category => $count) {
        echo "<tr><td>{$category}</td><td>{$count}</td></tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p>No tickets found for the selected date range.</p>";
    
}

?>
