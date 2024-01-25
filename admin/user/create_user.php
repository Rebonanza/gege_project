<?php
require_once('../config.php');
require_once('../function.php');
session_start();

//Periksa apakah session pengguna ada atau tidak
if (!isset($_SESSION['user'])) {
    header('Location: ../dashboard/login.php');
    exit();
}


$pdo = dbConnection();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle registration form submission
    
    $username = htmlspecialchars( $_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars( $_POST['password'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if ($email === false) {
    // Invalid email format
      echo "<script>alert('Invalid email format !!');</script>"; 
    }
    // Perform validation and registration (you should hash the password in a real-world scenario)
    // For simplicity, this example uses plain text passwords, which is not secure.
    $password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (Username, Password, Email) VALUES (?, ?, ?)");

    $stmt->execute([$username, $password, $email]); // Replace '' with the user's email
    
    // Redirect to login page after successful registration
    echo '<script>
    alert("Berhasil Menambahkan User");
    window.location.href="index.php";
    </script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    require_once('../../layout/header.php');
  ?>
</head>
<body class="bg-body-tertiary">
  <div class="container-scroller">
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <?php require_once('../../layout/sidebar.php');?>

        </div>
       <div class="col py-5">
       <div class="my-3 p-5 bg-body rounded shadow-sm">
            <h3 class=" pb-2 mb-2">Add New User</h3>
            <form  action="" method="POST">
                            <div class="mb-3">
                              <label for="exampleInputUsername1" class="form-label">Username</label>
                              <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Username" name="username">
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Email address</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email">
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Password</label>
                              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a class="btn btn-danger" href="index.php">Cancel</a>
              </form>
          </div>
       </div>
      </div>
    </div>
        <!-- partial:partials/_footer.html -->
        <?php 
          require_once('../../layout/footer.php');
        ?>
        
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

 
  <?php 
    require_once('../../layout/script.php');
  ?>
</body>

</html>

