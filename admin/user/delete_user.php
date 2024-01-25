<?php
// Check if the form is submitted
require_once('../function.php');

$db = dbConnection();
checkSession();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    // Handle the deletion here
    $idDelete = $_POST['id'];
    echo($idDelete);
    $id = decryptID($idDelete); 
    try {
        // Prepare a DELETE statement
        $stmt = $db->prepare("DELETE FROM users WHERE userID = :id");

        // Bind the parameter
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();
        
        // Redirect to a page after successful deletion
        echo "<script>alert('Berhasil menghapus user');</script>";
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        $error = "Error deleting record: " . $e->getMessage();
        echo "<script>alert('".$error."');</script>";
        header('Location: index.php');
        exit();
       
    }
    // After deletion, you may want to redirect or perform other actions
   
}
?>