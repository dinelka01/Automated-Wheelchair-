<?php
session_start();

require_once '../func/connection.php';

// Check if doctor's ID is set in the session
if (!isset($_SESSION['user_id'])) {
    // If not set, redirect to the login page
    header("Location: login.php");
    exit;
}

// Get the doctor's ID from the session
$doctorId = $_SESSION['user_id']; 

// Fetch appointments with status "pending" for the logged-in doctor
$sql = "SELECT a.appointment_id, a.user_id, a.status,a.wheelchair, p.username AS patient_username
        FROM appointment AS a
        INNER JOIN patients AS p ON a.user_id = p.id
        WHERE a.status = 'pending' AND a.doctor_id = '$doctorId'";

$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Store appointments in an array
        $appointments = array();
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
        // Output JSON response
        echo json_encode(array("success" => true, "appointments" => $appointments));
    } else {
        // Output JSON response if no appointments found
        echo json_encode(array("success" => false, "message" => "No pending appointments found for this doctor"));
    }
} else {
    // Output JSON response if there was an error with the query
    echo json_encode(array("success" => false, "message" => "Error: " . $conn->error));
}

$conn->close();
?>
