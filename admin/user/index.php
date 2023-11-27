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

// Fetch all users from the database
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
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
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">All User</h4>
                  <a href="create_user.php" class="btn btn-primary">Add User</a>
                  <div class="table-responsive mt-3">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $number = 1;
                          foreach ($users as $user) :
                        ?>
                        <tr>
                          <td class="py-1"><?=$number++?></td>
                          <td><?=$user['Username']?></td>
                          <td><?=$user['Email']?></td>
                          <td>
                            <a href="edit_user.php?id=<?=$user['UserID']?>" class="btn btn-warning"><i class='bx bx-edit-alt'></i></a>
                            <a href="delete?id=<?=$user['UserID']?>" class="btn btn-danger"><i class='bx bx-trash'></i></a>
                          </td>
                        </tr>
                        <?php 
                        endforeach
                        ?>
                      </tbody>
                    </table>
                  </div>
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

  <?php
  require_once('../../layout/script.php')
  ?>
  
</body>

</html>
