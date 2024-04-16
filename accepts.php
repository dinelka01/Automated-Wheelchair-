<?php

require_once '../func/connection.php';

function updateAppointmentStatus($appointmentId, $label, $conn) {
    $appointmentId = mysqli_real_escape_string($conn, $appointmentId);
    $label = mysqli_real_escape_string($conn, $label);

  
    $status = ($label == 'accept') ? 'accept' : 'rejected';

    $sql = "UPDATE appointment SET status = '$status' WHERE  appointment_id = '$appointmentId'";
    
    if ($conn->query($sql) === TRUE) {
        $response = array("success" => true, "message" => "Appointment status updated to '$status' successfully.");
    } else {
        $response = array("success" => false, "message" => "Error updating appointment status: " . $conn->error);
    }

    return json_encode($response);
}

if (isset($_POST['appointment_id']) && isset($_POST['label'])) {
    $appointmentId = $_POST['appointment_id'];
    $label = $_POST['label'];

    echo updateAppointmentStatus($appointmentId, $label, $conn);
} else {
    echo json_encode(array("success" => false, "message" => "Appointment ID and label are required."));
}

$conn->close();
?>
