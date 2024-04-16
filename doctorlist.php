<?php

require_once '../func/connection.php';

// Fetch doctor usernames from the doctors table
$sqlDoctors = "SELECT id, username FROM doctors"; 

$resultDoctors = $conn->query($sqlDoctors);

if ($resultDoctors) {
    if ($resultDoctors->num_rows > 0) {
        // Store doctor usernames in an array
        $doctors = array();
        while ($row = $resultDoctors->fetch_assoc()) {
            $doctors[] = $row;
        }

        // Output JSON response with doctor usernames
        echo json_encode(array("success" => true, "doctors" => $doctors));
    } else {
        // Output JSON response if no doctors found
        echo json_encode(array("success" => false, "message" => "No doctors found"));
    }
} else {
    // Output JSON response if there was an error with the query
    echo json_encode(array("success" => false, "message" => "Error fetching doctors: " . $conn->error));
}

$conn->close();
?>
