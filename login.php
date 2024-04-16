<?php

include '../func/connection.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $response = array();

    $username = $_POST['username'];
    $password = $_POST['password'];
    $label = $_POST['label'];

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);


    $sql = "";
    $result = null;


    if ($label == 'super-admin') {
        $sql = "SELECT * FROM superadmin WHERE username = '$username'";
        $result = $conn->query($sql);
    } elseif ($label == 'doctor') {
        $sql = "SELECT * FROM doctors WHERE username = '$username'";
        $result = $conn->query($sql);
    } elseif ($label == 'patient') {
        $sql = "SELECT * FROM patients WHERE username = '$username'";
        $result = $conn->query($sql);
    } 
    

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['label'] = $label;
            $_SESSION['user_id'] = $row['id'];
            $response['success'] = true;
            $response['message'] = "Login successful.";


        } else {
            $response['success'] = false;
            $response['message'] = "Incorrect username or password.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Incorrect username or password.";
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
