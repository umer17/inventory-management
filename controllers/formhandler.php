<?php 
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rizwan";
global $conn;
$conn=null;
try {
    $conn = new PDO("mysql:host=$servername;port=3308;dbname=rizwan", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if(isset($_POST['generatenew']))
    {
       generatenew();
    }

    
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

    function generatenew()
    {
        print_r($_POST) ;
//         global $conn;
//         $customername=$_POST['customername'];
// $accountid=$_POST['accountid'];
// $remainingbalance=$_POST['remainingbalance'];
// $stmt = $conn->prepare("INSERT INTO `customers` (`customername`, `accountid`, `remainingbalance`) VALUES (:customername, :accountid, :remainingbalance)");
    
// if($stmt->execute([
//     'customername' => $customername,
//     'accountid' => $accountid,
//     'remainingbalance' => $remainingbalance
    
    
// ])){
//     $message="Your Job Was Posted Successfully";
//     // echo "<script type='text/javascript'>alert('$message');
//     //     window.location.href='http://joblister/post_job.php';
//     //     </script>";
//         echo "<script type='text/javascript'>alert('$message');
        
//         </script>";

// }
// else
// {
//     $message = "There was an error inserting data into table";
//         echo "<script type='text/javascript'>alert('$message');
        
//         </script>";
// }
    }
    $conn = null ;
?>