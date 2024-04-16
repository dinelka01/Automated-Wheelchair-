<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Register</title>

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
                    <a class="nav-link" href="../index.php">About Us</a>

                    <a class="nav-link" href="home.php">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
      <div class="login-container">
        <h2 class="text-center mb-4"><b>Patient Register</b></h2>
        <form id="registerForm" action="register.php" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email" required>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
        </form>
      </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#registerForm').submit(function(event) {
          event.preventDefault();
          var formData = $(this).serialize();
          $.ajax({
            type: 'POST',
            url: '../api/register.php',
            data: formData,
            success: function(response) {
              console.log(response);
            
            },
            error: function(xhr, status, error) {
              console.error('Error:', error);

            }
          });
        });
      });
    </script>
  </body>
</html>
