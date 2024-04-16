<?php

require_once '../func/connection.php';


$sql = "SELECT a.appointment_id, a.user_id, a.status, p.username AS patient_username
        FROM appointment AS a
        INNER JOIN patients AS p ON a.user_id = p.id
        WHERE a.status = 'accept'";

$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
     
        $appointments = array();
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
    
        echo json_encode(array("success" => true, "appointments" => $appointments));
    } else {
     
        echo json_encode(array("success" => false, "message" => "No pending appointments found"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Error: " . $conn->error));
}

$conn->close();
?>
