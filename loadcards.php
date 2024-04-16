<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../func/connection.php';

$patientId = $_SESSION['user_id'];

$sql = "SELECT a.appointment_id, a.appoiment_time, a.`switch`, d.username AS doctor_name
        FROM appointment AS a
        INNER JOIN doctors AS d ON a.doctor_id = d.id
        WHERE a.user_id = $patientId AND a.`switch` = 'ongoing'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $cards = array();
    while ($row = $result->fetch_assoc()) {
        $cards[] = $row;
    }

    echo json_encode(array("success" => true, "cards" => $cards));
} else {
    echo json_encode(array("success" => false, "message" => "No ongoing appointments found for this patient"));
}

$conn->close();
?>
