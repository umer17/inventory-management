<?php
include "SimpleXLSX.php";
include "config.php";
if (isset($_POST['getcustomers'])) {
    // $servername = "localhost";
    // $username = "id15011618_root";
    // $password = "}8R~xB}b8e0jXD%7";
    // $dbname = "id15011618_rizwan";
    global $conn;
    $conn = null;
    try {
        $conn = new PDO("mysql:host=$servername;port=3308;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM customers");
        $customername = array();
        $accountids = array();
        $remainingbalance = array();
        $mainarray = array();
        if ($stmt->execute()) {
            // set the resulting array to associative
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($customername,$row['customername']);
               array_push($accountids,$row['accountid']);
                array_push($remainingbalance,$row['remainingbalance']);
              
            }
        array_push($mainarray,$customername, $accountids, $remainingbalance);

        }
        echo json_encode($mainarray) ;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    if ($xlsx = SimpleXLSX::parse('../upload/inventory.xlsx')) {
        $data = array();
        $itemid = array();
        $description = array();
        $quantity = array();
        $rate = array();
        $i = 0;
        foreach ($xlsx->rows() as $elt) {
            if ($i == 0) {
                $i++;
                continue;
            } else {
                array_push($itemid, strval($elt[0]));
                array_push($description, strval($elt[1]));
                array_push($quantity, $elt[2]);
                array_push($rate, strval($elt[3]));
            }
            $i++;
        }
        array_push($data, $itemid, $description, $quantity, $rate);
        echo json_encode($data);
    } else {
        echo SimpleXLSX::parseError();
    }
}
