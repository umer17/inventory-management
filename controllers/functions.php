<?php
include 'config.php';

// $servername = "localhost";
// $username = "id15011618_root";
// $password = "}8R~xB}b8e0jXD%7";
// $dbname = "id15011618_rizwan";
global $conn;
$conn = null;

try {
    $conn = new PDO("mysql:host=$servername;port=3308;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // getitems('8owJewPmpbWLLCBe');
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
function getbills()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM bills   order by `date` DESC, `time` DESC");
    $bills = array();
    if ($stmt->execute()) {
        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $bills[] = $row;
        }
    }
    return $bills;
}
function getbill($invoicenumber)
{

    global $conn;
    $bill = array();
    $stmt = $conn->prepare("SELECT * FROM `bills` WHERE `bills`.`invoicenumber` = :invoicenumber");
    if ($stmt->execute([
        'invoicenumber' => $invoicenumber,
    ])) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $bill[] = $row;
        }
    }
    return $bill;
}
function getitems($invoicenumber)
{
    global $conn;
    $items = array();
    $stmt = $conn->prepare("SELECT * FROM `items` WHERE `items`.`invoicenumber` = :invoicenumber order by `description`");
    if ($stmt->execute([
        'invoicenumber' => $invoicenumber,
    ])) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $items[] = $row;
        }
    }
    return ($items);
}
function getvendors()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM vendors");
    $vendors = array();
    if ($stmt->execute()) {
        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vendors[] = $row;
        }
    }
    return $vendors;
}
function getvendornames()
{
    global $conn;
    $stmt = $conn->prepare("SELECT `vendorname` FROM vendors");
    $vendors = array();
    if ($stmt->execute()) {
        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vendors[] = $row;
        }
    }
    return $vendors;
}
function getcustomernames()
{
    global $conn;
    $stmt = $conn->prepare("SELECT `customername` FROM customers");
    $customers = array();
    if ($stmt->execute()) {
        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $customers[] = $row;
        }
    }
    return $customers;
}
function getvendortransactions()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM transactions   order by `date` DESC, `time` DESC");
    $transactions = array();
    if ($stmt->execute()) {
        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $transactions[] = $row;
        }
    }
    return $transactions;
}
function getcustomertransactions()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM transactioncustomer   order by `date` DESC, `time` DESC");
    $transactions = array();
    if ($stmt->execute()) {
        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $transactions[] = $row;
        }
    }
    return $transactions;
}
function getcustomers()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM customers");
    $customers = array();
    if ($stmt->execute()) {
        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $customers[] = $row;
        }
    }
    return $customers;
}
function getcustomertransactionsbydate($date)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM transactioncustomer WHERE `transactioncustomer`.`date` = :date");
    $transactions = array();
    if ($stmt->execute(['date' => $date,])) {
        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $transactions[] = $row;
        }
    }
    return $transactions;
}
