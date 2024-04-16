<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/style.css" rel="stylesheet">

</head>
<body class="login-body">
<nav class="navbar navbar-expand-lg nav-header">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color:white">Medicare</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    <a class="nav-link" href="../doctor/home.php">Doctor Login</a>
                    <a class="nav-link" href="../home.php">Contact Us</a>
          
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
      <div class="login-container">
        <h2 class="text-center mb-4"><b>Patient Login</b></h2>
        <form id="loginForm">
          <div class="mb-3">
            <label for="landlordUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="landlordUsername" placeholder="Enter your username">
          </div>
          <div class="mb-3">
            <label for="landlordPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="landlordPassword" placeholder="Enter your password">
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary-login btn-block space" style="margin-bottom:5px">Login</button>
            <button type="submit" class="btn btn-primary btn-block" ><a href="register.php" style="color:white; text-decoration:none">Register</a></button>
          
          </div>
        </form>
      </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#loginForm').submit(function(event) {
  
          event.preventDefault();
          
   
          var landlordUsername = $('#landlordUsername').val();
          var landlordPassword = $('#landlordPassword').val();
          
           console.log(landlordUsername);
           console.log(landlordPassword);

          $.ajax({
            type: 'POST',
            url: '../api/login.php',
            data: {
              username: landlordUsername,
              password: landlordPassword,
              label: 'patient' 
            },
            success: function(response) {

              console.log(response);
           
              if (response.success) {
                window.location.href = 'home.php';
              } else {
                alert(response.message);
              }
            }
          });
        });
      });
    </script>
  </body>
</html>
