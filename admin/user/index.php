<?php

require_once('../config.php');
require_once('../function.php');
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ../dashboard/login.php');
  exit();
}

// Database configuration
dbConnection();

// Fetch all users from the database
$users = getData('users');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    require_once('../../layout/header.php');
  ?>
</head>
<body >
  <div class="container-scroller">
  <div class="container-fluid page-body-wrapper">
       <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <?php require_once('../../layout/sidebar.php');?>

        </div>
       <div class="col py-5">
          <div class="my-3 p-5 bg-body rounded shadow-sm">
            <h3 class=" pb-2 mb-2">Users List</h3>
            <a href="create_user.php" class="btn btn-success border-bottom mb-3">Add User</a>
            <div class="table-responsive">
                              <table class="table table-hover">
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
                                    $counter = 0;
                                    foreach($users as $user):
                                    $counter++;
                                  ?>
                                    <tr>
                                      <td><?=$counter?></td>
                                      <td><?=$user['Username']?></td>
                                      <td><?=$user['Email']?></td>
                                      <td>
                                        <a href="edit_user.php?id=<?=encryptID($user['UserID'])?>"class="btn btn-warning p-2"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                                        <form action="delete_user.php" class="d-inline mx-0" method="post">
                                          <input type="hidden" name="id" value="<?=encryptID($user['UserID'])?>">
                                          <button type="submit" name="delete" class="btn btn-danger p-2" onclick="return confirm('Yakin ingin hapus user ini ?')"><i class="fa-regular fa-pen-to-square"></i> Delete</button></form>
                                      </td>
                                    </tr>
                                  <?php
                                    endforeach;
                                  ?>  
                                </tbody>
                              </table>
              </div>
          </div>
        </div>
      </div>
    </div>
      <!-- partial
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Users</h3>
                
                </div>

                <div class="col-lg-12 grid-margin stretch-card mt-3">
                    <div class="card">
                          <div class="card-body">
                            <h4 class="card-title">Users List</h4>
                            <a href="create_user.php" class="btn btn-success">Add User</a>
                            <div class="table-responsive">
                              <table class="table table-hover">
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
                                    $counter = 0;
                                    foreach($users as $user):
                                    $counter++;
                                  ?>
                                    <tr>
                                      <td><?=$counter?></td>
                                      <td><?=$user['Username']?></td>
                                      <td><?=$user['Email']?></td>
                                      <td>
                                        <a href="edit_user.php?id=<?=encryptID($user['UserID'])?>"class="btn btn-warning p-3"><i class='bx bx-edit'></i></a>
                                        <form action="delete_user.php" class="d-inline mx-0" method="post">
                                          <input type="hidden" name="id" value="<?=encryptID($user['UserID'])?>">
                                          <button type="submit" class="btn btn-danger p-3"><i class='bx bx-trash'></i></button></form>
                                      </td>
                                    </tr>
                                  <?php
                                    endforeach;
                                  ?>  
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
            </div>
        </div>
      </div> -->
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php 
          require_once('../../layout/footer.php');
        ?>
        <!-- partial -->
      </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <?php 
    require_once('../../layout/script.php');
  ?>
</body>

</html>