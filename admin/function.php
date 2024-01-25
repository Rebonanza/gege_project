<?php 
require_once('config.php');

function dbConnection(){
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

    return $pdo;
}


function checkSession(){
    session_start();

// Periksa apakah session pengguna ada atau tidak
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }

}

function getData($table, $id=null){
    $pdo = dbConnection();
    if($id == null){
        // Fetch all users from the database
        $stmt = $pdo->query("SELECT * FROM ". $table);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }else{
        $stmt = $pdo->prepare("SELECT * FROM ".$table." WHERE UserID = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

}

function insertData($table, $id=null){

}

function hashString($string) {
    $options = [
        'cost' => 12, // You can adjust the cost factor based on your security requirements
    ];
    return password_hash($string, PASSWORD_BCRYPT, $options);
}

// Function to verify a hashed ID
function verifyHash($string, $hash) {
    $data['is_valid'] = password_verify($string, $hash);
    if( password_verify($string, $hash)){
        $data['content'] = $string;
    }else{
        $data['content'] = '';
    }
    return $data;
}


$secretKey = "7bwUat28pL"; // Replace with a strong secret key
$initializationVector = "JWCf6wV3j3kVUA0h";
// Function to encrypt an ID
function encryptID($id)
{
    global $secretKey, $initializationVector;
    $cipher = "aes-256-cbc";
    $options = 0;

    $encrypted = openssl_encrypt($id, $cipher, $secretKey, $options,$initializationVector);

    return base64_encode($encrypted);
}

// Function to decrypt an ID
function decryptID($encryptedID)
{
    global $secretKey, $initializationVector;
    $cipher = "aes-256-cbc";
    $options = 0;

    $decrypted = openssl_decrypt(base64_decode($encryptedID), $cipher, $secretKey, $options, $initializationVector);

    return $decrypted;
}


