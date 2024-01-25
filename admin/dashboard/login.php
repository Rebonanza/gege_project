<?php
require_once('../function.php');

session_start();
// Periksa apakah session pengguna ada atau tidak
if (isset($_SESSION['user'])) {
  header('Location: index.php');
  exit();
}

// Database configuration
$pdo = dbConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Handle login form submission
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    
    // Perform validation and authentication
    $stmt = $pdo->prepare("SELECT * FROM users WHERE Username = ?");
    $stmt->execute([$username]); // Replace with password hashing in a real-world scenario
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
      if(password_verify($password, $user['Password'])){
        // Set session variable to indicate user is logged in
        $session['id'] = hashString($user['UserID']);
        $session['username'] = $user['Username'];
        $session['email'] = $user['email'];
        $_SESSION['user'] = $session;
        
        echo '<script>
        alert("Login Berhasil");
        window.location.href="index.php";
        </script>';
        exit();
      }else{
        echo "<script>alert('Invalid username or password. Please try again.');</script>";
      }
    } else {
        echo "<script>alert('User account not found !!');</script>";
      
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GEGE Admin - Login</title>
  <!-- plugins:css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/835e07eb5f.js" crossorigin="anonymous"></script>
</head>

<body class="bg-body-secondary">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center justify-content-center auth px-0 vh-100">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto px-5">
          <div class=" p-5 bg-body rounded shadow-sm">
            <h3 class=" text-center">GEGE Admin</h3>
            <form class="mt-2" action="" method="POST">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" name="username" placeholder="name@example.com">
                  <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating">
                  <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                  <label for="floatingPassword">Password</label>
                </div>
                
                <div class="d-grid gap-2 mt-3">
                    <button class="btn btn-primary" type="submit">Sign In</button>
                  
                  </div>
              </form>
          </div>

          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
 
  <!-- endinject -->
</body>

</html>

