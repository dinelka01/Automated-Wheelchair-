<?php

require_once '../func/connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];


    $getLastIdSql = "SELECT id FROM patients ORDER BY id DESC LIMIT 1";
    $result = $conn->query($getLastIdSql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $nextId = $row['id'] + 1;
    } else {
       
        $nextId = 1;
    }


    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO patients (id, username, password) VALUES ($nextId, '$username', '$hashedPassword')";
    
    if ($conn->query($sql) === TRUE) {
   
        echo json_encode(array("success" => true, "message" => "Registration successful"));
    } else {

        echo json_encode(array("success" => false, "message" => "Registration failed"));
    }


    $conn->close();
} else {

    header("Location: register.php");
    exit;
}
?>
