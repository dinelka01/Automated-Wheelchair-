<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Home</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/style.css" rel="stylesheet">
  <style>
    .btn-success-accept {
      color: white;
      background-color: #1977cc;
    }

    .btn-success-accept:hover {
      color: white;
      background-color: #02213d;
    }
  </style>
</head>
<body class="login-body">
<nav class="navbar navbar-expand-lg nav-header">
    <div class="container-fluid">
      <a class="navbar-brand" href="#" style="color:white">Medicare</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
              aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto">
          <a class="nav-link active" aria-current="page" href="home.php">Home</a>
          <a class="nav-link" href="addappointment.php">Add Appointment</a>
          <a class="nav-link" href="logout.php">Log Out</a>
        </div>
      </div>
    </div>
  </nav>

<div class="container">
    <h3 style="font-weight: 700;
 
  text-align: center;">My  Appointments Ongoing History</h3><br>
  <div class="row" id="appointmentCards">

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    
    function loadAppointments() {
      $.ajax({
        type: 'GET',
        url: '../api/loadcards.php', 
        dataType: 'json', 
        success: function(response) {
            console.log(response);
          if (response.success) {
            $('#appointmentCards').empty(); // Clear existing cards
            response.cards.forEach(function(card) {
              var cardHtml = `
              <div class="col-md-4">
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Appointment ID: ${card.appointment_id}</h5>
            <p class="card-text">Appointment Time: ${card.appoiment_time}</p>
            <p class="card-text">Doctor Name: ${card.doctor_name}</p>
            <p class="card-text"> Status: <span class="badge text-bg-success">${card.switch}</span></p>
            <button class="btn btn-danger emergencyButton" data-appointment-id="${card.appointment_id}">Emergency</button>
            <button class="btn btn-warning emergencyButton" data-appointment-id="${card.appointment_id}">Toilet</button>
        </div>
    </div>
</div>

              `;
              $('#appointmentCards').append(cardHtml);
            });
          } else {
            // Handle error if appointments couldn't be loaded
            console.error('Error loading appointments:', response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error('Error:', error);
        }
      });
    }

    // Load appointments when the page loads
    loadAppointments();

    // Handle Emergency button click event
    $(document).on('click', '.emergencyButton', function() {
      var appointmentId = $(this).data('appointment-id');
      console.log('Emergency button clicked for appointment ID:', appointmentId);
      // Add your emergency handling logic here
    });
  });
</script>
</body>
</html>
