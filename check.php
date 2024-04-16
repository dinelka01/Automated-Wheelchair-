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
  <title>Doctor Checking</title>

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
          <a class="nav-link" href="check.php">Check By Doctor</a>
          <a class="nav-link" href="logout.php">Log Out</a>
        </div>
      </div>
    </div>
  </nav>

<div class="container">
  <div class="card">
    <table class="table table-striped">
      <thead>
      <tr>
        <th>Appointment ID</th>
        <th>Patient Name</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody id="appointmentTableBody">
  
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    
    function loadAppointments() {
      $.ajax({
        type: 'GET',
        url: '../api/check.php', 
        dataType: 'json', 
        success: function(response) {
  
          $('#appointmentTableBody').empty();

        
          $.each(response.appointments, function(index, appointment) {
            var row = '<tr>' +
              '<td>' + appointment.appointment_id + '</td>' +
              '<td>' + appointment.patient_username + '</td>' +
              '<td>' +
              '<button class="btn btn-success-accept acceptButton" data-appointment-id="' + appointment.appointment_id + '">Scan</button> ' +
              '<button class="btn btn-danger rejectButton" data-appointment-id="' + appointment.appointment_id + '">Close</button>' +
              '</td>' +
              '</tr>';
            $('#appointmentTableBody').append(row);
          });
        }
      });
    }

 
    loadAppointments();

   
    $(document).on('click', '.acceptButton', function() {
    var appointmentId = $(this).data('appointment-id');
    var doctorId = getDoctorId(); // Retrieve doctor's ID from session

    // Update appointment status and set destination to doctor's ID in Firebase
    if (doctorId !== '') {
      $.ajax({
        type: 'POST',
        url: '../api/accepts.php',
        data: { appointment_id: appointmentId, label: 'accept' },
        success: function(response) {
          // Send success response to Firebase
          var wheelchairRef = firebase.database().ref('wheelchairs/wheelchair1'); // Change to appropriate wheelchair ID
          wheelchairRef.update({ destination: doctorId }).then(function() {
            console.log('Destination set to doctor ID: ' + doctorId);
          }).catch(function(error) {
            console.error('Error setting destination: ', error);
          });
        }
      });
    } else {
      console.error('Doctor ID not found in session.');
    }
  });

    $(document).on('click', '.rejectButton', function() {
      var appointmentId = $(this).data('appointment-id');

      $.ajax({
        type: 'POST',
        url: '../api/accepts.php', 
        data: { appointment_id: appointmentId, label: 'rejected' }, 
        success: function(response) {
          alert("Rejected appointment");
          loadAppointments();
        }
      });
    });
  });
</script>

<!-- Include the Firebase JavaScript SDK -->
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
    
<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyDjHi4nce2s2nXMo4t0jKfZT2__g3B9ytA",
    authDomain: "automediwheel.firebaseapp.com",
    projectId: "automediwheel",
    storageBucket: "automediwheel.appspot.com",
    messagingSenderId: "220624559426",
    appId: "1:220624559426:web:2d373ec65993588ba6fcdb"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);

  function getDoctorId() {

    return "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>";
  }

  function checkWheelchairAvailability() {
    return new Promise((resolve, reject) => {
      // Reference to the 'wheelchairs' node in Firebase Realtime Database
      const wheelchairsRef = firebase.database().ref('wheelchairs');

      // Query to check if any wheelchair is available
      wheelchairsRef.once('value', (snapshot) => {
        // Check if any wheelchair is available
        const wheelchairs = snapshot.val();
        let isAvailable = false;
        if (wheelchairs) {
          // Iterate through wheelchairs
          Object.keys(wheelchairs).forEach(key => {
            if (wheelchairs[key].status === 'off') {
              // If status is 'off', wheelchair is available
              isAvailable = true;
              return; // Exit loop early since we found an available wheelchair
            }
          });
        }
        resolve(isAvailable); // Resolve promise with availability status
      }, (error) => {
        reject(error); // Reject promise if there is an error
      });
    });
  }

  // Example usage:
  checkWheelchairAvailability().then((isAvailable) => {
    if (isAvailable) {
      console.log('Wheelchair is available');
    } else {
      console.log('No wheelchair available');
    }
  }).catch((error) => {
    console.error('Error checking wheelchair availability:', error);
  });
</script>

</body>
</html>
