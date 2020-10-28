<?php session_start();
include 'config.php';
require '../vendor/autoload.php';
date_default_timezone_set("Asia/Karachi");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
?>


<?php
// $servername = "localhost";
// $username = "id15011618_root";
// $password = "}8R~xB}b8e0jXD%7";
// $dbname = "id15011618_rizwan";
global $conn;
$conn = null;
try {
    $conn = new PDO("mysql:host=$servername;port=3308;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['generatenew'])) {
        generatenew();
    } else if (isset($_POST['additems'])) {
        additems();
    } else if (isset($_POST['addsingleitem'])) {
        addsingleitem();
    } else if (isset($_POST['generateexisting'])) {
        generateexisting();
    } else if (isset($_POST['editexcel'])) {
        editexcel();
    } else if (isset($_POST['addvendor'])) {
        addvendor();
    } else if (isset($_POST['addtransaction'])) {
        addtransaction();
    } else if (isset($_POST['addtransactioncustomer'])) {
        addtransactioncustomer();
    } else if (isset($_POST['login'])) {
        login();
    } else if (isset($_POST['logout'])) {
        logout();
    } else if (isset($_POST['inventorypassword'])) {
        inventorypassword();
    } else if (isset($_POST['editbill'])) {
        generateexisting(true);
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
function generatenew()
{
    
    $invoicenumber = getRandomString();

    $date = date("m/d/Y");
    $time = date('h:i a');
    $accountid = $_POST["accountid"];

    $customername = $_POST['customername'];

    $transactiontype = $_POST['transactiontype'];

    $transactionnumber = $_POST['transactionnumber'];
    $carton = $_POST['carton'];

    $bundle = $_POST['bundle'];

    $totalcartonbundle = $_POST['totalcartonbundle'];

    $total = $_POST['total'];

    $previousbalance = $_POST['previousbalance'];

    $grandtotal = $_POST['grandtotal'];

    $remainingbalance = $_POST['remainingbalance'];
    $amountpaid = $_POST['amountpaid'];
    $discount = $_POST['discount'];

    $receivername = $_POST['receivername'];

    // var_dump($_POST);
    $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../upload/inventory.xlsx");
    $sheet = $spreadsheet->getActiveSheet();
    // $value = $sheet->getCell("A"."1")->getValue();
    // echo $value;
    $indexes = explode(",", $_POST["indexes"][0]);
    // print_r($indexes);
    $length = count($indexes);
    // for ($i = 0; $i < $length; $i++) {
    //     $quantity = $sheet->getCell("C" . ($indexes[$i] + 2))->getValue();
    //     $new_quantity = $quantity - $_POST["quantity"][$i];
    //     $sheet->setCellValue("C" . ($indexes[$i] + 2), $new_quantity);
    // }
    // //load spreadsheet
    // $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../upload/inventory.xlsx"); 
    // //change it
    // $sheet = $spreadsheet->getActiveSheet();
    // $sheet->setCellValue('A1', 'New Value');
    //write it again to Filesystem with the same name (=replace)
    $writer = new Xlsx($spreadsheet);
    $writer->save('../upload/inventory.xlsx');
    global $conn;
    $stmt = $conn->prepare("INSERT INTO `customers` (`customername`, `accountid`, `remainingbalance`) VALUES (:customername, :accountid, :remainingbalance)");
    if ($stmt->execute([
        'customername' => $customername,
        'accountid' => $accountid,
        'remainingbalance' => ((int)$grandtotal - (int)$amountpaid)
    ])) {
    } else {
        $message = "There was an error inserting data into customers table";
        echo "<script type='text/javascript'>alert('$message');
            </script>";
    }
    $stmt = $conn->prepare("INSERT INTO `bills` (`invoicenumber`, `date`, `time`, `accountid`, `customername`, `transactiontype`, `transactionnumber`, `carton`, `bundle`, `totalcartonbundle`, `total`, `previousbalance`, `grandtotal`, `amountpaid`, `receivername`, `discount`) VALUES (:invoicenumber, :date, :time, :accountid, :customername, :transactiontype, :transactionnumber, :carton, :bundle, :totalcartonbundle, :total, :remainingbalance, :grandtotal, :amountpaid, :receivername, :discount)");
    if ($stmt->execute([
        'invoicenumber' => $invoicenumber,
        'date' => $date,
        'time' => $time,
        'accountid' => $accountid,
        'customername' => $customername,
        'transactiontype' => $transactiontype,
        'transactionnumber' => $transactionnumber,
        'carton' => $carton,
        'bundle' => $bundle,
        'totalcartonbundle' => $totalcartonbundle,
        'total' => $total,
        'remainingbalance' => $remainingbalance,
        'grandtotal' => $grandtotal,
        'amountpaid' => $amountpaid,
        'receivername' => $receivername,
        'discount'=>$discount
    ])) {
    } else {
        $message = "There was an error inserting data into bills table";
        echo "<script type='text/javascript'>alert('$message');
            </script>";
    }
    for ($i = 0; $i < $length; $i++) {
        $stmt = $conn->prepare("INSERT INTO `items` (`invoicenumber`, `itemid`, `description`,`quantity`,`rate`,`amount`) VALUES (:invoicenumber, :itemid, :description, :quantity, :rate, :amount)");
        if ($stmt->execute([
            'invoicenumber' => $invoicenumber,
            'itemid' => $_POST["itemid"][$i],
            'description' => $_POST["description"][$i],
            'quantity' => $_POST["quantity"][$i],
            'rate' => $_POST["rate"][$i],
            'amount' => $_POST["amount"][$i],
        ])) {
            if ($i == ($length - 1)) {
                $stmt = $conn->prepare("INSERT INTO `transactioncustomer` (`invoicenumber`,`date`, `time`, `customername`, `accountid`, `previousbalance`, `amountpaid`, `bill`,`totalbill`, `remainingbalance`, `remarks`) VALUES (:invoicenumber, :date, :time, :customername, :accountid, :previousbalance, :amountpaid, :bill, :totalbill, :remainingbalance, :remarks)");
                if ($stmt->execute([
                    'invoicenumber' => $invoicenumber,
                    'date' => $date,
                    'time' => $time,
                    'customername' => $customername,
                    'accountid' => $accountid,
                    'previousbalance' => $remainingbalance,
                    'amountpaid' => $amountpaid,
                    'bill' => $total,
                    'totalbill' => $grandtotal,
                    'remainingbalance' => ((int)$grandtotal - (int)$amountpaid),
                    'remarks' => ''
                ])) {
                    printPage($invoicenumber);
                } else {
                    echo json_encode(false);
                }
            }
        } else {
            $message = "There was an error inserting data into items table";
            echo "<script type='text/javascript'>alert('$message');
                </script>";
        }
    }
}
function generateexisting($edit = false)
{
    global $conn;

    $date = date("m/d/Y");
    $time = date('h:i a');

    $accountid = $_POST["accountid"];

    $customername = $_POST['customername'];

    $transactiontype = $_POST['transactiontype'];

    $transactionnumber = $_POST['transactionnumber'];

    $carton = $_POST['carton'];

    $bundle = $_POST['bundle'];

    $totalcartonbundle = $_POST['totalcartonbundle'];

    $total = $_POST['total'];

    $previousbalance = $_POST['previousbalance'];

    $grandtotal = $_POST['grandtotal'];

    $amountpaid = $_POST['amountpaid'];
    $discount = $_POST['discount'];

    $receivername = $_POST['receivername'];

    if ($edit == true) {
        $invoicenumber = $_POST['invoicenumber'];
        $stmt = $conn->prepare("DELETE FROM `items` WHERE `items`.`invoicenumber` = :invoicenumber");
        if ($stmt->execute([
            'invoicenumber' => $invoicenumber,
        ])) {
            $stmt = $conn->prepare("DELETE FROM `bills` WHERE `bills`.`invoicenumber` = :invoicenumber");
            if ($stmt->execute([
                'invoicenumber' => $invoicenumber,
            ])) {
                $stmt = $conn->prepare("DELETE FROM `transactioncustomer` WHERE `transactioncustomer`.`invoicenumber` = :invoicenumber");
                if ($stmt->execute([
                    'invoicenumber' => $invoicenumber,
                ])) {
                } else {
                }
            } else {
            }
        } else {
            $message = "There was an error inserting data into bills table";
            echo "<script type='text/javascript'>alert('$message');
                    </script>";
        }
    } else {
        $invoicenumber = getRandomString();
    }
    // var_dump($_POST);
    $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../upload/inventory.xlsx");
    $sheet = $spreadsheet->getActiveSheet();
    // $value = $sheet->getCell("A"."1")->getValue();
    // echo $value;
    $indexes = explode(",", $_POST["indexes"][0]);
    // print_r($indexes);
    $length = count($indexes);
    // for ($i = 0; $i < $length; $i++) {
    //     $quantity = $sheet->getCell("C" . ($indexes[$i] + 2))->getValue();
    //     $new_quantity = $quantity - $_POST["quantity"][$i];
    //     $sheet->setCellValue("C" . ($indexes[$i] + 2), $new_quantity);
    // }
    // //load spreadsheet
    // $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../upload/inventory.xlsx"); 
    // //change it
    // $sheet = $spreadsheet->getActiveSheet();
    // $sheet->setCellValue('A1', 'New Value');
    //write it again to Filesystem with the same name (=replace)
    $writer = new Xlsx($spreadsheet);
    $writer->save('../upload/inventory.xlsx');

    $stmt = $conn->prepare("UPDATE `customers` SET `remainingbalance` = :amountpaid WHERE `customers`.`accountid` = :accountid");
    if ($stmt->execute([
        'accountid' => $accountid,
        'amountpaid' => ((int)$grandtotal - (int)$amountpaid)
    ])) {
        $message = "Update  Successfully";
        // echo "<script type='text/javascript'>alert('$message');
        //     window.location.href='http://joblister/post_job.php';
        //     </script>";
        // echo "<script type='text/javascript'>alert('$message');
        //         </script>";
    } else {
        $message = "There was an error inserting data into bills table";
        echo "<script type='text/javascript'>alert('$message');
                </script>";
    }
    $stmt = $conn->prepare("INSERT INTO `bills` (`invoicenumber`, `date`, `time`, `accountid`, `customername`, `transactiontype`, `transactionnumber`, `carton`, `bundle`, `totalcartonbundle`, `total`, `previousbalance`, `grandtotal`, `amountpaid`, `receivername`, `discount`) VALUES (:invoicenumber, :date, :time, :accountid, :customername, :transactiontype, :transactionnumber, :carton, :bundle, :totalcartonbundle, :total, :previousbalance, :grandtotal, :amountpaid, :receivername, :discount)");
    if ($stmt->execute([
        'invoicenumber' => $invoicenumber,
        'date' => $date,
        'time' => $time,
        'accountid' => $accountid,
        'customername' => $customername,
        'transactiontype' => $transactiontype,
        'transactionnumber' => $transactionnumber,
        'carton' => $carton,
        'bundle' => $bundle,
        'totalcartonbundle' => $totalcartonbundle,
        'total' => $total,
        'previousbalance' => $previousbalance,
        'grandtotal' => $grandtotal,
        'amountpaid' => $amountpaid,
        'receivername' => $receivername,
        'discount' => $discount,
    ])) {
    } else {
        $message = "There was an error inserting data into bills table";
        echo "<script type='text/javascript'>alert('$message');
            </script>";
    }
    for ($i = 0; $i < $length; $i++) {
        $stmt = $conn->prepare("INSERT INTO `items` (`invoicenumber`, `itemid`, `description`,`quantity`,`rate`,`amount`) VALUES (:invoicenumber, :itemid, :description, :quantity, :rate, :amount)");
        if ($stmt->execute([
            'invoicenumber' => $invoicenumber,
            'itemid' => $_POST["itemid"][$i],
            'description' => $_POST["description"][$i],
            'quantity' => $_POST["quantity"][$i],
            'rate' => $_POST["rate"][$i],
            'amount' => $_POST["amount"][$i],
        ])) {
            if ($i == ($length - 1)) {
                $stmt = $conn->prepare("INSERT INTO `transactioncustomer` (`invoicenumber`,`date`, `time`, `customername`, `accountid`, `previousbalance`, `amountpaid`, `bill`,`totalbill`, `remainingbalance`, `remarks`) VALUES (:invoicenumber, :date, :time, :customername, :accountid, :previousbalance, :amountpaid, :bill, :totalbill, :remainingbalance, :remarks)");
                if ($stmt->execute([
                    'invoicenumber' => $invoicenumber,
                    'date' => $date,
                    'time' => $time,
                    'customername' => $customername,
                    'accountid' => $accountid,
                    'previousbalance' => $previousbalance,
                    'amountpaid' => $amountpaid,
                    'bill' => $total,
                    'totalbill' => $grandtotal,
                    'remainingbalance' => ((int)$grandtotal - (int)$amountpaid),
                    'remarks' => ''
                ])) {
                    printPage($invoicenumber);
                } else {
                    echo json_encode(false);
                }
            }
        } else {
            $message = "There was an error inserting data into items table";
            echo "<script type='text/javascript'>alert('$message');
                </script>";
        }
    }
    // $stmt = $conn->prepare("UPDATE `transactioncustomer` SET `remainingbalance` = :remainingbalance WHERE `transactioncustomer`.`accountid` = :accountid");
    // if ($stmt->execute([
    //     'remainingbalance' => ($amountpaid - $previousbalance),
    //     'accountid' => $accountid,

    // ])) {
    //     $stmt = $conn->prepare("INSERT INTO `transactioncustomer` (`date`, `time`, `customername`, `accountid`, `previousbalance`, `amountpaid`, `remainingbalance`) VALUES (:date, :time, :customername, :accountid, :previousbalance, :amountpaid, :remainingbalance)");
    //     if ($stmt->execute([
    //         'date' => $date,
    //         'time' => $time,
    //         'customername' => $customername,
    //         'accountid' => $accountid,
    //         'previousbalance' => $previousbalance,
    //         'amountpaid' => $amountpaid,
    //         'remainingbalance' => (  $amountpaid - $previousbalance)
    //     ])) {
    //         echo json_encode(true);
    //     } else {
    //         echo json_encode(false);
    //     }
    // } else {
    //     echo json_encode(false);
    // }


}
function additems()
{
    $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../upload/inventory.xlsx");
    $sheet = $spreadsheet->getActiveSheet();
    $items = $_POST['itemid'];
    $length = count($items);
    for ($i = 0; $i < $length; $i++) {
        if (empty(trim($items[$i]))) {
        } else {
            $row = $sheet->getHighestRow() + 1;
            $sheet->insertNewRowBefore($row);
            $sheet->setCellValue('A' . $row, $_POST['itemid'][$i]);
            $sheet->setCellValue('B' . $row, $_POST['description'][$i]);
            $sheet->setCellValue('C' . $row, $_POST['quantity'][$i]);
            $sheet->setCellValue('D' . $row, $_POST['rate'][$i]);
        }
        // $quantity = $sheet->getCell("C" . ($indexes[$i] + 2))->getValue();
        // $new_quantity = $quantity - $_POST["quantity"][$i];
        // $sheet->setCellValue("C" . ($indexes[$i] + 2), $new_quantity);
    }
    // $row = $sheet->getHighestRow()+1;
    // $sheet->insertNewRowBefore($row);
    // $sheet->setCellValue('A'.$row, 'Updated');
    $writer = new Xlsx($spreadsheet);
    $writer->save('../upload/inventory.xlsx');
}
function addsingleitem()
{

    $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../upload/inventory.xlsx");
    $sheet = $spreadsheet->getActiveSheet();
    $row = $sheet->getHighestRow() + 1;
    $sheet->insertNewRowBefore($row);
    $sheet->setCellValue('A' . $row, $_POST['itemid']);
    $sheet->setCellValue('B' . $row, $_POST['description']);
    $sheet->setCellValue('C' . $row, $_POST['quantity']);
    $sheet->setCellValue('D' . $row, $_POST['rate']);
    $writer = new Xlsx($spreadsheet);
    $writer->save('../upload/inventory.xlsx');
}
function getRandomString($length = 4)
{
    $characters = '0123456789';
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
}
function printPage($invoicenumber)
{
    echo "<body></body>";
    echo '<script src="https://code.jquery.com/jquery-1.12.4.js"></script>';
    echo '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>';
    echo "<script>
    var payload = {
        invoicenumber: '$invoicenumber',
      };
      var form = document.createElement('form');
      form.style.visibility = 'hidden';
      form.method = 'POST';
      form.action = '../bill.php';
      $.each(Object.keys(payload), function(index, key) {
      var input = document.createElement('input');
          input.name = key;
          input.value = payload[key];
          form.appendChild(input)
      });
      document.body.appendChild(form);
      form.submit();       
    </script>";
}
function editexcel()
{

    $indexes = $_POST['indexes'];
    $itemid = $_POST["itemid"];
    $description = $_POST["description"];
    $quantity = $_POST["quantity"];
    $rate = $_POST["rate"];
    $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../upload/inventory.xlsx");
    $sheet = $spreadsheet->getActiveSheet();
    // $row = $sheet->getHighestRow() + 1;
    // $sheet->insertNewRowBefore($row);
    // $sheet->setCellValue('A' . $row, $_POST['itemid']);
    // $sheet->setCellValue('B' . $row, $_POST['description']);
    // $sheet->setCellValue('C' . $row, $_POST['quantity']);
    // $sheet->setCellValue('D' . $row, $_POST['rate']);
    // $writer = new Xlsx($spreadsheet);
    // $writer->save('../upload/inventory.xlsx');
    $length = count($indexes);
    for ($i = 0; $i < $length; $i++) {
        $sheet->setCellValue("A" . ($indexes[$i] + 2), $itemid[$i]);
        $sheet->setCellValue("B" . ($indexes[$i] + 2), $description[$i]);
        $sheet->setCellValue("C" . ($indexes[$i] + 2), $quantity[$i]);
        $sheet->setCellValue("D" . ($indexes[$i] + 2), $rate[$i]);
    }
    $writer = new Xlsx($spreadsheet);
    $writer->save('../upload/inventory.xlsx');
}
function addvendor()
{
    $date = date("m/d/Y");
    $time = date('h:i a');
    $vendorname = $_POST['vendorname'];
    $vendorid = $_POST['vendorid'];
    $remainingbalance = $_POST['remainingbalance'];
    global $conn;
    $stmt = $conn->prepare("INSERT INTO `vendors` (`date`, `time`, `vendorname`, `vendorid`, `remainingbalance`) VALUES (:date, :time, :vendorname, :vendorid, :remainingbalance)");
    if ($stmt->execute([
        'date' => $date,
        'time' => $time,
        'vendorname' => $vendorname,
        'vendorid' => $vendorid,
        'remainingbalance' => $remainingbalance,
    ])) {
        echo json_encode(true);
    } else {
        echo json_encode(false);
    }
}
function addtransaction()
{
    $date = date("m/d/Y");
    $time = date('h:i a');
    $vendorname = $_POST['vendorname'];
    $vendorid = $_POST['vendorid'];
    $previousbalance = $_POST['previousbalance'];
    $amountpaid = $_POST['amountpaid'];
    $remarks = $_POST['remarks'];
    global $conn;

    $stmt = $conn->prepare("INSERT INTO `transactions` (`date`, `time`, `vendorname`, `vendorid`, `previousbalance`, `amountpaid`, `remainingbalance`, `remarks`) VALUES (:date, :time, :vendorname, :vendorid, :previousbalance, :amountpaid, :remainingbalance, :remarks)");
    if ($stmt->execute([
        'date' => $date,
        'time' => $time,
        'vendorname' => $vendorname,
        'vendorid' => $vendorid,
        'previousbalance' => $previousbalance,
        'amountpaid' => $amountpaid,
        'remainingbalance' => ((int)$previousbalance - (int)$amountpaid),
        'remarks' => $remarks,
    ])) {
        $stmt = $conn->prepare("UPDATE `vendors` SET `remainingbalance` = :amountpaid WHERE `vendors`.`vendorid` = :accountid");
        if ($stmt->execute([
            'accountid' => $vendorid,
            'amountpaid' => ((int)$previousbalance - (int)$amountpaid)
        ])) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    } else {
        echo json_encode(false);
    }
}
function addtransactioncustomer()
{
    $date = date("m/d/Y");
    $time = date('h:i a');
    $customername = $_POST['customername'];
    $accountid = $_POST['accountid'];
    $previousbalance = $_POST['previousbalance'];
    $amountpaid = $_POST['amountpaid'];
    $remarks = $_POST['remarks'];
    global $conn;
    $stmt = $conn->prepare("INSERT INTO `transactioncustomer` (`date`, `time`, `customername`, `accountid`, `previousbalance`, `amountpaid`, `bill`,`totalbill`, `remainingbalance`,`remarks`) VALUES (:date, :time, :customername, :accountid, :previousbalance, :amountpaid, :bill, :totalbill, :remainingbalance,:remarks)");
    if ($stmt->execute([
        'date' => $date,
        'time' => $time,
        'customername' => $customername,
        'accountid' => $accountid,
        'previousbalance' => $previousbalance,
        'amountpaid' => $amountpaid,
        'bill' => $previousbalance,
        'totalbill' => $previousbalance,
        'remainingbalance' => ((int)$previousbalance - (int)$amountpaid),
        'remarks' => $remarks
    ])) {
        $stmt = $conn->prepare("UPDATE `customers` SET `remainingbalance` = :amountpaid WHERE `customers`.`accountid` = :accountid");
        if ($stmt->execute([
            'accountid' => $accountid,
            'amountpaid' => ((int)$previousbalance - (int)$amountpaid)
        ])) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    } else {
    }
}
function login()
{
    global $conn;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT username,password FROM users WHERE username=:username AND password =:password");
    $stmt->execute([

        'username' => $username,
        'password' => $password,
    ]);
    if ($stmt->rowCount() == 0) {
        $message = "login details are incorrect";
        echo "<script type='text/javascript'>alert('$message');
            window.history.go(-1);
            </script>";
    } else {

        $_SESSION['logged_in'] = '1';
        echo "<script type='text/javascript'>
            window.location.href='../index.php';
            </script>";

        // header("Location:../index.php");
    }
}
function logout()
{
    $_SESSION['logged_in'] = '0';
}
function inventorypassword()
{
    global $conn;
    $username = 'Rizwan';
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT username,password FROM inventorycred WHERE username=:username AND password =:password");
    $stmt->execute([

        'username' => $username,
        'password' => $password,
    ]);
    if ($stmt->rowCount() == 0) {

        echo json_encode(false);
    } else {

        echo json_encode(true);
    }
}

$conn = null;
