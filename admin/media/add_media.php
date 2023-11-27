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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // File upload handling
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        exit();
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo "File already exists.";
        exit();
    }

    // Check file size (max 5MB)
    if ($_FILES["file"]["size"] > 5 * 1024 * 1024) {
        echo "File is too large.";
        exit();
    }

    // Allow certain file formats
    $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo "Invalid file format. Only JPG, JPEG, PNG, and GIF are allowed.";
        exit();
    }

    // Move the file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Insert data into the database
        $stmt = $pdo->prepare("INSERT INTO Images (title, description, filename) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, basename($_FILES["image"]["name"])]);

        echo "Image uploaded successfully.";
    } else {
        echo "Error uploading the file.";
    }
}
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
                  <h4 class="card-title">Add Media</h4>
                
                  <form class="forms-sample" enctype="multipart/form-data" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <div class="form-group">
                      <label for="exampleInputUsername1">Title</label>
                      <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Title" name="title">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Description</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Description" name="description">
                    </div>
                    <div id="drop-area" class="form-group">
                        <span>Image</span>
                        <input type="file" id="file-input" name="image" accept="image/*" style="display: none;" required >
                        <p>Drag and drop or click to select an image</p>
                        <div id="image-preview"></div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a href="/gegeproject/admin/media" class="btn btn-light">Cancel</a>
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
  require_once('../../layout/script.php')
  ?>
</body>

</html>
