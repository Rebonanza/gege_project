<?php
session_start();

// Periksa apakah session pengguna ada atau tidak
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
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

// Check if user ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "User ID not provided.";
    exit();
}

$userID = $_GET['id'];

// Fetch user data based on the provided ID
$stmt = $pdo->prepare("SELECT * FROM users WHERE UserID = ?");
$stmt->execute([$userID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user exists
if (!$user) {
    echo "User not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle user update form submission
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Perform validation and update
    $stmt = $pdo->prepare("UPDATE users SET Username = ?, Password = ?, Email = ?, Role = ? WHERE id = ?");
    $stmt->execute([$username, $password, $email, $role, $userID]);

    // Redirect to user list page after successful update
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
    require_once('../../layout/header.php')
  ?>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php
      require_once('../../layout/navbar.php')
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      <?php
        require_once('../../layout/sidebar.php')
      ?>
      <!-- partial -->
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add User</h4>
                
                  <form class="forms-sample" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <div class="form-group">
                      <label for="exampleInputUsername1">Username</label>
                      <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Username" name="username" value="<?=$user['Username']?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email address</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email" value="<?=$user['Email']?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password"  value="<?=$user['Password']?>">
                    </div>
                   
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a href="index.php" class="btn btn-light">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <?php
          require_once('../../layout/footer.php')
        ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <?php
  require_once('../../layout/script.php')
  ?>
</body>

</html>
