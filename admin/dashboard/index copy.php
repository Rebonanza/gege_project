<?php

require_once('../config.php');

session_start();

// Periksa apakah session pengguna ada atau tidak
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
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
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php
      require_once('../../layout/navbar.php');
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php
        require_once('../../layout/sidebar.php');
      ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome Admin</h3>
                  <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have</h6>
                </div>
              </div>
            </div>
        </div>
      </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
          <?php
            require_once('../../layout/footer.php');
          ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <?php
    require_once('../../layout/script.php');
  ?>
</body>

</html>

