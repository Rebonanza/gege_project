<?php
require_once('../config.php');

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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars( $_POST['title'] , ENT_QUOTES, 'UTF-8');
    $description =   htmlspecialchars( $_POST['description'] , ENT_QUOTES, 'UTF-8');

    // File upload handling
    $currentDateTime = date('Ymd_His');
    $targetDirectory = '../../uploads/';
    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $newFileName = 'image_' . $currentDateTime . '.' . $fileExtension;
    $targetFile = $targetDirectory .  $newFileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File is not an image !!');</script>";
        exit();
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo "<script>alert('File already exists !!');</script>";
        exit();
    }

    // Check file size (max 5MB)
    if ($_FILES["image"]["size"] > 5 * 1024 * 1024) {
        echo "<script>alert('File is too large !!');</script>";
        exit();
    }

    // Allow certain file formats
    $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo "<script>alert('Invalid file format. Only JPG, JPEG, PNG, and GIF are allowed !!');</script>";
       
        exit();
    }

    // Move the file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Insert data into the database
        $stmt = $pdo->prepare("INSERT INTO gallery (title, description, image) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $newFileName]);
        echo '<script>
        alert("Berhasil Menambahkan Gambar");
        window.location.href="index.php";
        </script>';
        exit();
    } else {
        echo '<script>
        alert("Error Uploading File");
        window.location.href="index.php";
        </script>';
       
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
<?php 
    require_once('../../layout/header.php');
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
    
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <?php require_once('../../layout/sidebar.php');?>

        </div>
       <div class="col py-5">
       <div class="my-3 p-5 bg-body rounded shadow-sm">
            <h3 class=" pb-2 mb-2">Add New Media</h3>
            <form  action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                              <label for="exampleInputUsername1" class="form-label">Title</label>
                              <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title" name="title">
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Description</label>
                              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="description" name="description">
                            </div>
                            <label for="exampleInputEmail1" class="form-label">Image</label>
                            <div id="drop-area" class="form-group">
                              
                                <input type="file" id="file-input" name="image" accept="image/*" style="display: none;" required >
                                <p>Drag and drop or click to select an image</p>
                                <div id="image-preview"></div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2 mt-3">Submit</button>
                            <a class="btn btn-danger mt-3" href="index.php">Cancel</a>
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
      
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
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
