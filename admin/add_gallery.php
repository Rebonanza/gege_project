<?php
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
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
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
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        // Insert data into the database
        $stmt = $pdo->prepare("INSERT INTO Images (title, description, filename) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, basename($_FILES["file"]["name"])]);

        echo "Image uploaded successfully.";
    } else {
        echo "Error uploading the file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Image Upload Form</title>
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

<div class="container">
    <h2>Image Upload Form</h2>
    <form id="upload-form" enctype="multipart/form-data" method="post" action="upload.php">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div id="drop-area" class="form-group">
            <input type="file" id="file-input" name="file" accept="image/*" style="display: none;" required>
            <p>Drag and drop or click to select an image</p>
            <div id="image-preview"></div>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
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
            imagePreview.innerHTML = `<img src="${e.target.result}" alt="Image Preview" class="img-fluid">`;
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

</body>
</html>
