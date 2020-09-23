<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rizwan";
global $conn;
$conn = null;
try {
    $conn = new PDO("mysql:host=$servername;port=3308;dbname=rizwan", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
function getbills()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM bills");
    $bills = array();
    if($stmt->execute()){
    // set the resulting array to associative
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $bills[] = $row;
    }
    }
    return $bills;
}
