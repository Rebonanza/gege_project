<?php
require_once('../config.php');
require_once('../function.php');
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
$stmt = $pdo->query("SELECT * FROM gallery");
$gallerys = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Gege Admin - Dashboard</title>
  <link href="../../assets/css/style.css" rel="stylesheet">
 
 
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
            <h3 class=" pb-2 mb-2">Gallery</h3>
            <a href="add_media.php" class="btn btn-success">Add Media</a>
                <div class="row portfolio-container mt-4">
                                <?php
                                  foreach ($gallerys as $gallery) :
                                ?>
                                  <div class="col">
                                    <div class="card shadow border-0" style="width: 20rem;">
                                    <img src="../../uploads/<?=$gallery['image']?>" class="card-img-top" alt="...">
                                      <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text"><?=$gallery['description']?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                          <div class="btn-group">
                                          <a href="edit_media.php?id=<?=encryptID($gallery['id'])?>"class="btn btn-warning p-2 me-2"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                                            <form action="delete_media.php" class="d-inline mx-0" method="post">
                                              <input type="hidden" name="id" value="<?=encryptID($gallery['id'])?>">
                                              <button type="submit" name="delete" class="btn btn-danger p-2" onclick="return confirm('Yakin ingin delete gambar ini ?')" ><i class="fa-regular fa-pen-to-square"></i> Delete</button></form>
                                          </div>
                                         
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php
                                endforeach;
                                ?>
                  </div>
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
    
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->


 
  
  <?php 
    require_once('../../layout/script.php');
  ?>
  <!-- End custom js for this page-->
</body>

</html>