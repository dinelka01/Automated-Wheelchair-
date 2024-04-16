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
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Add Appointment</h5>
      <form id="addAppointmentForm">
        <div class="mb-3">
          <label for="doctorName" class="form-label">Select Doctor Name:</label>
          <select class="form-select" id="doctorName" name="doctorName">
            <!-- Options will be populated dynamically -->
          </select>
        </div>
        <div class="mb-3">
        <div class="form-check">
  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
  <label class="form-check-label" for="flexCheckDefault">
   Get the Wheelchair
  </label>
</div>

        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description:</label>
          <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Appointment</button>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

function loadDoctors() {
  $.ajax({
    type: 'GET',
    url: '../api/doctorlist.php',
    dataType: 'json',
    success: function(response) {

      var doctorSelect = $('#doctorName');
      doctorSelect.empty(); 
      $.each(response.doctors, function(index, doctor) {
        doctorSelect.append($('<option>', {
          value: doctor.id,
          text: doctor.username
        }));
      });
    },
    error: function(xhr, status, error) {
      console.error('Error loading doctors:', error);
    }
  });
}

loadDoctors();


$('#addAppointmentForm').submit(function(event) {
  event.preventDefault(); 


  var doctorId = $('#doctorName').val();
  var userId = <?php echo $_SESSION['user_id']; ?>;
  var description = $('#description').val();
  var getWheelchair = $('#flexCheckDefault').is(':checked') ? 'yes' : 'no'; 
console.log(getWheelchair);

  $.ajax({
    type: 'POST',
    url: '../api/addapointmnet.php',
    data: { doctor_id: doctorId, user_id: userId, description: description, get_wheelchair: getWheelchair },
    success: function(response) {
      console.log(response);
      alert('Appointment added successfully!');
      
    },
    error: function(xhr, status, error) {
      console.error('Error adding appointment:', error);
    }
  });
});
});

</script>
</body>
</html>
