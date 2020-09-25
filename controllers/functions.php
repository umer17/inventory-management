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
    // getitems('8owJewPmpbWLLCBe');
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
function getbills()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM bills");
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
    $stmt = $conn->prepare("SELECT * FROM `items` WHERE `items`.`invoicenumber` = :invoicenumber");
    if ($stmt->execute([
        'invoicenumber' => $invoicenumber,
    ])) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $items[] = $row;
        }
    }
    return($items);
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
function getvendortransactions()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM transactions");
    $transactions = array();
    if ($stmt->execute()) {
        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $transactions[] = $row;
        }
    }
    return $transactions;
}
