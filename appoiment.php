<?php

require_once '../func/connection.php';

function insertAppointment($userId, $status, $conn) {
    $userId = mysqli_real_escape_string($conn, $userId);
    $status = mysqli_real_escape_string($conn, $status);

    
    $currentTimestamp = date('Y-m-d H:i:s');

    $sql = "INSERT INTO appointment (user_id, status, created_at) VALUES ('$userId', '$status', '$currentTimestamp')";
    
    if ($conn->query($sql) === TRUE) {
        $response = array("success" => true, "message" => "New record inserted successfully.");
    } else {
        $response = array("success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error);
    }

    return json_encode($response);
}

if (isset($_POST['user_id']) && isset($_POST['status'])) {
    $userId = $_POST['user_id'];
    $status = $_POST['status'];

    echo insertAppointment($userId, $status, $conn);
} else {
    echo json_encode(array("success" => false, "message" => "User ID and status are required."));
}

$conn->close();
?>
