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
$stmt = $pdo->query("SELECT * FROM media");
$galerys = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_once('../../layout/header.php')
  ?>
  <style>
        #drop-area {
            border: 2px dashed #ccc;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }

        #drop-area.highlight {
            border-color: #218838;
            background-color: #f8f9fa;
        }

        #image-preview {
            max-width: 100%;
            max-height: 200px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php
          require_once('../../layout/navbar.php');
        ?>
    
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      <?php
          require_once('../../layout/sidebar.php');
        ?>
     
      <!-- partial -->
      <div class="main-panel ">        
        <div class="content-wrapper portfolio">
            <div class="row ">
            <div class="col-lg-12 grid-margin stretch-card  ">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">All Gallery</h4>
                  <a href="" class="btn btn-primary">Add Gallery</a>
                  <div class="row portfolio-container mt-5">
                      <?php
                         
                          foreach ($gallerys as $gallery) :
                        ?>
                    <div class="col-lg-4 col-md-6 portfolio-item filter-app wow fadeInUp">
                      <div class="portfolio-wrap">
                        <figure>
                          <img src="../../assets/img/portfolio/<?=$gallery['image']?>" class="img-fluid" alt="">
                          <a href="../../assets/img/portfolio/<?=$gallery['image']?>" data-gallery="portfolioGallery" class="link-preview portfolio-lightbox" title="Preview"><i class="bx bx-plus"></i></a>
                          <a href="portfolio-details.html" class="link-details" title="More Details"><i class="bx bx-link"></i></a>
                        </figure>

                        <div class="portfolio-info">
                          <h4><a href=""><?=$gallery['title']?></a></h4>
                          <p><?=$gallery['description']?></p>
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
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <?php
          require_once('../../layout/footer.php');
        ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <script>
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('file-input');
    const imagePreview = document.getElementById('image-preview');

    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.classList.add('highlight');
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('highlight');
    });

    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('highlight');
        const file = e.dataTransfer.files[0];
        displayImage(file);
        fileInput.files = e.dataTransfer.files;
    });

    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        displayImage(file);
    });

    function displayImage(file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            // Create an image element
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100%';  // Limit the width of the image
            img.style.maxHeight = '200px';  // Limit the height of the image

            // Append the image to the image preview div
            imagePreview.innerHTML = '';
            imagePreview.appendChild(img);
        };
        reader.readAsDataURL(file);
    }

    // Add an event listener to the form for handling form submission
    document.getElementById('upload-form').addEventListener('submit', function (e) {
        e.preventDefault();
        // Add your code here to handle the form submission, e.g., using AJAX or submitting the form normally.
        // You can access form data using FormData() and send it to the server.
    });
</script>
<?php
require_once('../../layout/script.php');
?>
</body>

</html>
