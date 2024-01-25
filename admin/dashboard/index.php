<?php

require_once('../config.php');

session_start();

// Periksa apakah session pengguna ada atau tidak
// if (!isset($_SESSION['user'])) {
//     header('Location: login.php');
//     exit();
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    require_once('../../layout/header.php');
  ?>
</head>
<body class="vh-100">

<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark shadow-sm">
            <?php require_once('../../layout/sidebar.php');?>

        </div>
       <div class="col py-5">
           <h2>Welcome back, Admin</h2>
        </div>
    </div>
</div>  


    
  
     

  <?php
    require_once('../../layout/script.php');
  ?>
</body>

</html>

