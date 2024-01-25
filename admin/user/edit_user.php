<?php
require_once('../config.php');
require_once('../function.php');
session_start();

// Periksa apakah session pengguna ada atau tidak
if (!isset($_SESSION['user'])) {
    header('Location: ../dashboard/login.php');
    exit();
}

// Database configuration
$hostname = 'localhost';
$database = 'gege_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Handle user update form submission
  $username = htmlspecialchars( $_POST['username'], ENT_QUOTES, 'UTF-8');
  $password = htmlspecialchars( $_POST['password'], ENT_QUOTES, 'UTF-8');
  $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
  $userID = $_POST['id'];
  $password = $_POST['password'];
  $password = hashString($password);
 

  // Perform validation and update
  $stmt = $pdo->prepare("UPDATE users SET Username = ?, Password = ?, Email = ? WHERE userID = ?");
  $stmt->execute([$username, $password, $email, $userID]);

  // Redirect to user list page after successful update
  echo '<script>
  alert("Berhasil Mengubah User");
  window.location.href="index.php";
  </script>';
  exit();
}else{
  if (!isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
      echo "<script>alert('ERROR')</script>";
      exit();
  }

  $userID = $_GET['id'];
  $userID = decryptID($userID);


  // Fetch user data based on the provided ID
  $stmt = $pdo->prepare("SELECT * FROM users WHERE UserID = ?");
  $stmt->execute([$userID]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check if the user exists
  if (!$user) {
      echo "User not found.";
      exit();
  }
}

// Check if user ID is provided in the URL



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    require_once('../../layout/header.php');
  ?>
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <?php require_once('../../layout/sidebar.php');?>

        </div>
       <div class="col py-5">
          <div class="my-3 p-5 bg-body rounded shadow-sm">
            <h3 class=" pb-2 mb-2">Edit a User</h3>
              <form action="" method="POST">
                            <input type="hidden" name="id" value="<?=encryptID($user['UserID'])?>">
                            <div class="mb-3">
                              <label for="exampleInputUsername1" class="form-label">Username</label>
                              <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Username" name="username" value="<?=$user['Username']?>">
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Email address</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email" value="<?=$user['Email']?>">
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Password</label>
                              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" >
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a class="btn btn-danger" href="index.php">Cancel</a>
                </form>
          </div>
       </div>
      </div>
    </div>
      <!-- partial -->
   
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php 
          require_once('../../layout/footer.php');
        ?>
        <!-- partial -->
 
  </div>
  <!-- container-scroller -->

  <?php 
    require_once('../../layout/script.php');
  ?>
</body>

</html>