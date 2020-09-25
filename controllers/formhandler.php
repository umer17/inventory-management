<?php

require '../vendor/autoload.php';
date_default_timezone_set("Asia/Karachi");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rizwan";
global $conn;
$conn = null;
try {
    $conn = new PDO("mysql:host=$servername;port=3308;dbname=rizwan", $username, $password);
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
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
function generatenew()
{
    var_dump($_POST);
    $invoicenumber = getRandomString();
    echo "INVOICE NUMBER: " . $invoicenumber;
    echo "<br>";
    $date = date("m/d/Y");
    $time = date('h:i a');
    $accountid = $_POST["accountid"];
    echo "Account ID: " . $accountid;
    echo "<br>";
    $customername = $_POST['customername'];
    echo "Customer Name:" . $customername;
    echo "<br>";
    $transactiontype = $_POST['transactiontype'];
    echo "Transaction Type: " . $transactiontype;
    echo "<br>";
    $transactionnumber = $_POST['transactionnumber'];
    echo "Transaction Number: " . $transactionnumber;
    echo "<br>";
    $carton = $_POST['carton'];
    echo "Carton: " . $carton;
    echo "<br>";
    $bundle = $_POST['bundle'];
    echo "Bundle: " . $bundle;
    echo "<br>";
    $totalcartonbundle = $_POST['totalcartonbundle'];
    echo "Total: " . $totalcartonbundle;
    echo "<br>";
    $total = $_POST['total'];
    echo "Total: " . $total;
    echo "<br>";
    $previousbalance = $_POST['previousbalance'];
    echo "Previous Balance: " . $previousbalance;
    echo "<br>";
    $grandtotal = $_POST['grandtotal'];
    echo "Grand Total: " . $grandtotal;
    echo "<br>";
    $remainingbalance = $_POST['remainingbalance'];
    echo "Remaining Balance: " . $remainingbalance;
    echo "<br>";
    $amountpaid = $_POST['amountpaid'];
    echo "Amount Paid: " . $amountpaid;
    echo "<br>";
    $receivername = $_POST['receivername'];
    echo "Receiver Name: " . $receivername;
    echo "<br>";
    // var_dump($_POST);
    $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../upload/inventory.xlsx");
    $sheet = $spreadsheet->getActiveSheet();
    // $value = $sheet->getCell("A"."1")->getValue();
    // echo $value;
    $indexes = explode(",", $_POST["indexes"][0]);
    // print_r($indexes);
    $length = count($indexes);
    for ($i = 0; $i < $length; $i++) {
        $quantity = $sheet->getCell("C" . ($indexes[$i] + 2))->getValue();
        $new_quantity = $quantity - $_POST["quantity"][$i];
        $sheet->setCellValue("C" . ($indexes[$i] + 2), $new_quantity);
    }
    // //load spreadsheet
    // $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../upload/inventory.xlsx"); 
    // //change it
    // $sheet = $spreadsheet->getActiveSheet();
    // $sheet->setCellValue('A1', 'New Value');
    //write it again to Filesystem with the same name (=replace)
    $writer = new Xlsx($spreadsheet);
    $writer->save('yourspreadsheet.xlsx');
    global $conn;
    $stmt = $conn->prepare("INSERT INTO `customers` (`customername`, `accountid`, `remainingbalance`) VALUES (:customername, :accountid, :remainingbalance)");
    if ($stmt->execute([
        'customername' => $customername,
        'accountid' => $accountid,
        'remainingbalance' => ($grandtotal - $amountpaid)
    ])) {
    } else {
        $message = "There was an error inserting data into customers table";
        echo "<script type='text/javascript'>alert('$message');
            </script>";
    }
    $stmt = $conn->prepare("INSERT INTO `bills` (`invoicenumber`, `date`, `time`, `accountid`, `customername`, `transactiontype`, `transactionnumber`, `carton`, `bundle`, `totalcartonbundle`, `total`, `previousbalance`, `grandtotal`, `amountpaid`, `receivername`) VALUES (:invoicenumber, :date, :time, :accountid, :customername, :transactiontype, :transactionnumber, :carton, :bundle, :totalcartonbundle, :total, :remainingbalance, :grandtotal, :amountpaid, :receivername)");
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
                printPage($invoicenumber);
            }
        } else {
            $message = "There was an error inserting data into items table";
            echo "<script type='text/javascript'>alert('$message');
                </script>";
        }
    }
}
function generateexisting()
{
    var_dump($_POST);
    $invoicenumber = getRandomString();
    echo "INVOICE NUMBER: " . $invoicenumber;
    echo "<br>";
    $date = date("m/d/Y");
    $time = date('h:i a');
    echo $time;
    $accountid = $_POST["accountid"];
    echo "Account ID: " . $accountid;
    echo "<br>";
    $customername = $_POST['customername'];
    echo "Customer Name:" . $customername;
    echo "<br>";
    $transactiontype = $_POST['transactiontype'];
    echo "Transaction Type: " . $transactiontype;
    echo "<br>";
    $transactionnumber = $_POST['transactionnumber'];
    echo "Transaction Number: " . $transactionnumber;
    echo "<br>";
    $carton = $_POST['carton'];
    echo "Carton: " . $carton;
    echo "<br>";
    $bundle = $_POST['bundle'];
    echo "Bundle: " . $bundle;
    echo "<br>";
    $totalcartonbundle = $_POST['totalcartonbundle'];
    echo "Total: " . $totalcartonbundle;
    echo "<br>";
    $total = $_POST['total'];
    echo "Total: " . $total;
    echo "<br>";
    $previousbalance = $_POST['previousbalance'];
    echo "Previous Balance: " . $previousbalance;
    echo "<br>";
    $grandtotal = $_POST['grandtotal'];
    echo "Grand Total: " . $grandtotal;
    echo "<br>";
    $amountpaid = $_POST['amountpaid'];
    echo "Amount Paid: " . $amountpaid;
    echo "<br>";
    $receivername = $_POST['receivername'];
    echo "Receiver Name: " . $receivername;
    echo "<br>";
    // var_dump($_POST);
    $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../upload/inventory.xlsx");
    $sheet = $spreadsheet->getActiveSheet();
    // $value = $sheet->getCell("A"."1")->getValue();
    // echo $value;
    $indexes = explode(",", $_POST["indexes"][0]);
    // print_r($indexes);
    $length = count($indexes);
    for ($i = 0; $i < $length; $i++) {
        $quantity = $sheet->getCell("C" . ($indexes[$i] + 2))->getValue();
        $new_quantity = $quantity - $_POST["quantity"][$i];
        $sheet->setCellValue("C" . ($indexes[$i] + 2), $new_quantity);
    }
    // //load spreadsheet
    // $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../upload/inventory.xlsx"); 
    // //change it
    // $sheet = $spreadsheet->getActiveSheet();
    // $sheet->setCellValue('A1', 'New Value');
    //write it again to Filesystem with the same name (=replace)
    $writer = new Xlsx($spreadsheet);
    $writer->save('yourspreadsheet.xlsx');
    global $conn;
    $stmt = $conn->prepare("UPDATE `customers` SET `remainingbalance` = :amountpaid WHERE `customers`.`accountid` = :accountid");
    if ($stmt->execute([
        'accountid' => $accountid,
        'amountpaid' => ($grandtotal - $amountpaid)
    ])) {
        $message = "Update  Successfully";
        // echo "<script type='text/javascript'>alert('$message');
        //     window.location.href='http://joblister/post_job.php';
        //     </script>";
        echo "<script type='text/javascript'>alert('$message');
                </script>";
    } else {
        $message = "There was an error inserting data into bills table";
        echo "<script type='text/javascript'>alert('$message');
                </script>";
    }
    $stmt = $conn->prepare("INSERT INTO `bills` (`invoicenumber`, `date`, `time`, `accountid`, `customername`, `transactiontype`, `transactionnumber`, `carton`, `bundle`, `totalcartonbundle`, `total`, `previousbalance`, `grandtotal`, `amountpaid`, `receivername`) VALUES (:invoicenumber, :date, :time, :accountid, :customername, :transactiontype, :transactionnumber, :carton, :bundle, :totalcartonbundle, :total, :previousbalance, :grandtotal, :amountpaid, :receivername)");
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
                printPage($invoicenumber);
            }
        } else {
            $message = "There was an error inserting data into items table";
            echo "<script type='text/javascript'>alert('$message');
                </script>";
        }
    }
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
    $writer->save('yourspreadsheet.xlsx');
}
function addsingleitem()
{
    // var_dump($_POST);
    $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load("../upload/inventory.xlsx");
    $sheet = $spreadsheet->getActiveSheet();
    $row = $sheet->getHighestRow() + 1;
    $sheet->insertNewRowBefore($row);
    $sheet->setCellValue('A' . $row, $_POST['itemid']);
    $sheet->setCellValue('B' . $row, $_POST['description']);
    $sheet->setCellValue('C' . $row, $_POST['quantity']);
    $sheet->setCellValue('D' . $row, $_POST['rate']);
    $writer = new Xlsx($spreadsheet);
    $writer->save('yourspreadsheet.xlsx');
}
function getRandomString($length = 16)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
}
function printPage($invoicenumber)
{
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
    var_dump($_POST);
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
    // $writer->save('yourspreadsheet.xlsx');
    $length = count($indexes);
    for ($i = 0; $i < $length; $i++) {
        $sheet->setCellValue("A" . ($indexes[$i] + 2), $itemid[$i]);
        $sheet->setCellValue("B" . ($indexes[$i] + 2), $description[$i]);
        $sheet->setCellValue("C" . ($indexes[$i] + 2), $quantity[$i]);
        $sheet->setCellValue("D" . ($indexes[$i] + 2), $rate[$i]);
    }
    $writer = new Xlsx($spreadsheet);
    $writer->save('yourspreadsheet.xlsx');
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
    global $conn;
    $stmt = $conn->prepare("UPDATE `vendors` SET `remainingbalance` = :remainingbalance WHERE `vendors`.`vendorid` = :vendorid");
    if ($stmt->execute([
        'remainingbalance' => ($previousbalance - $amountpaid),
        'vendorid' => $vendorid,

    ])) {
        $stmt = $conn->prepare("INSERT INTO `transactions` (`date`, `time`, `vendorname`, `vendorid`, `previousbalance`, `amountpaid`, `remainingbalance`) VALUES (:date, :time, :vendorname, :vendorid, :previousbalance, :amountpaid, :remainingbalance)");
        if ($stmt->execute([
            'date' => $date,
            'time' => $time,
            'vendorname' => $vendorname,
            'vendorid' => $vendorid,
            'previousbalance' => $previousbalance,
            'amountpaid' => $amountpaid,
            'remainingbalance' => ($previousbalance - $amountpaid)
        ])) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    } else {
        echo json_encode(false);
    }
}
$conn = null;
