<?php

require_once '../func/connection.php';

function insertAppointment($userId, $doctorId, $checkwheelchair, $conn) {
    $userId = mysqli_real_escape_string($conn, $userId);
    $doctorId = mysqli_real_escape_string($conn, $doctorId);

    $wheelchair = ($checkwheelchair === 'yes') ? 'yes' : 'no';
    
    $currentTime = date('Y-m-d H:i:s');

    $sql = "INSERT INTO appointment (user_id, doctor_id, appoiment_time, wheelchair) VALUES ('$userId', '$doctorId', '$currentTime', '$wheelchair')";

    if ($conn->query($sql) === TRUE) {
        $response = array("success" => true, "message" => "New record inserted successfully.");
    } else {
        $response = array("success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error);
    }

    return json_encode($response);
}

if (isset($_POST['user_id']) && isset($_POST['doctor_id'])) {
    $userId = $_POST['user_id'];
    $doctorId = $_POST['doctor_id'];
 
    $checkwheelchair = isset($_POST['get_wheelchair']) ? $_POST['get_wheelchair'] : 'no';

    echo insertAppointment($userId, $doctorId, $checkwheelchair, $conn);
} else {
    echo json_encode(array("success" => false, "message" => "User ID and doctor ID are required."));
}

$conn->close();
?>
