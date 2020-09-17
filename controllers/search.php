<?php
include "SimpleXLSX.php";
if ($xlsx = SimpleXLSX::parse('../upload/inventory.xlsx')) {
    $data = array();
    $itemid= array();
    $description= array();
    $quantity= array();
    $rate= array();
    $i = 0;
    foreach ($xlsx->rows() as $elt) {
        if ($i == 0) {
            $i++;
            continue;
        } else {
            array_push($itemid, strval($elt[0]));
            array_push($description, strval($elt[1]));
            // array_push($quantity, $elt[2]);
            array_push($rate, strval($elt[3]));
        }
        $i++;
    }
    array_push($data,$itemid,$description,$rate);
    echo json_encode($data);
} else {
    echo SimpleXLSX::parseError();
}
