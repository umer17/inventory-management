<?php session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == '1') { ?>
    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="styles/tableborder.css">
        <title>Bill</title>
        <style></style>
    </head>

    <body style="font-size:15px">

        <div class="m-2 d-print-none">
            <a href="index.php" class="text-decoration-none">

                <img src="images/home.png" class="text-center mx-auto  " alt="Logo" width="40" height="auto">
                <p class="font-weight-bold" style="font-size:0.8rem;color:black">HOME</p>
            </a>


        </div>
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-12 col-md-12 col-lg-12">

                    <?php
                    include 'controllers/functions.php';
                    // $bill = getbill('Okhf8GAvDOj0aNIL');
                    // $items = getitems('Okhf8GAvDOj0aNIL');
                    $bill = getbill($_POST['invoicenumber']);
                    $items = getitems($_POST['invoicenumber']);
                    ?>
                    <!-- <div id="divToPrint"> -->
                    <?php
                    $numberofitems = count($items);
                    $pages = ceil($numberofitems / 5);
                    $item = 0;
                    // for ($i = 0; $i < $pages; $i++) {

                    echo "<div class='align-items-center row w-100 text-center col-12' >";


                    echo "<div style='flex:1'>";
                    echo "<p><strong>Invoice Number: " . $_POST['invoicenumber'] . "</strong></p>";
                    echo "<p><strong>Date: " . $bill[0]['date'] . ", " . $bill[0]['time'] . "</strong></p>";
                    // echo "<p><strong>Time: </strong>" . $bill[0]['time'] . "</p>";
                    // echo "<p><strong>Received By: </strong>" . $bill[0]['receivername'] . "</p>";
                    echo "</div>";



                    echo ' <div style="flex:1" class="row align-items-center  text-center h-100">
                    <img src="images/logo.png" class="text-center mx-auto " alt="Logo" width="120" height="60">
                    <!-- <h1 class="text-center">Invoice</h1> -->
                </div>';


                    echo "<div style='flex:1'>";
                    echo "<p><strong>Account ID: " . $bill[0]['accountid'] . " </strong></p>";

                    // echo "<p ><strong>Transaction Type: </strong>" . $bill[0]['transactiontype'] . "</p>";
                    // if ($bill[0]['transactiontype'] != "cash") {
                    //     echo "<p><strong>Transaction Number: </strong>" . $bill[0]['transactionnumber'] . "</p>";
                    // }
                    echo "<p><strong>Title: " . $bill[0]['customername'] . "</strong></p>";

                    // echo "<p ><strong>Carton: </strong>" . $bill[0]['carton'] . "</p>";
                    // echo "<p ><strong>Bundle: </strong>" . $bill[0]['bundle'] . "</p>";
                    // echo "<p ><strong>Total: </strong>" . $bill[0]['totalcartonbundle'] . "</p>";
                    echo "</div>";
                    echo "</div>";

                    echo "<div>";
                    echo '<div class="align-items-center text-center"><button  type="button" onclick="editbill()" class="btn d-print-none  btn-primary">Edit Bill</button> </div>';

                    echo '<table id="bills"  class="table table-sm table-hover table-bordered"><tbody>';
                    echo "<tr ><th >S. NO</th><th >" . "ITEM ID" . "</th><th >" . "DESCRIPTION" . "</th><th >" . "QTY" . "</th><th>" . "RATE" . "</th><th >AMOUNT</th></tr>";
                    $totalquantity = 0;
                    for ($j = 0; $j < $numberofitems; $j++) {
                        // if ($item < count($items)) {
                        if ($items[$j]['itemid'] != '') {
                            echo "<tr ><td ><strong>" . ($j + 1) . "</strong></td><td ><strong>" . $items[$j]['itemid'] .  "</strong></td><td ><strong>" . strtoupper($items[$j]['description'])  .  "</strong></td><td ><strong>" . $items[$j]['quantity'] . "</strong></td><td ><strong>" . $items[$j]['rate'] . "</strong></td><td ><strong>" . $items[$j]['amount'] . "</strong></td></tr>";
                            $totalquantity += $items[$j]['quantity'];
                            // $j += 1;
                            // }
                        }
                    }
                    echo "<tr><td colspan='3'><strong>Total: </td><td colspan='3' ></strong><strong>" . $totalquantity . "</strong></td></tr>";
                    echo '</tbody></table>';
                    echo "</div>";
                    // if ($i + 1 != $pages) {
                    //     echo '<div class="pagebreak"></div>';
                    // }
                    // }
                    echo "<div class='float-right  '>";
                    echo "<strong class='ml-2'>Total: " . $bill[0]['total'] . '</strong><br>';
                    echo "<strong class='ml-2'>Previous Balance: " . $bill[0]['previousbalance'] . '</strong><br>';
                    echo "<strong class='ml-2'>Discount: " . $bill[0]['discount'] . '</strong><br>';
                    echo "<strong class='ml-2'>Grand Total: " . $bill[0]['grandtotal'] . '</strong><br>';
                    echo "<strong class='ml-2'>Amount Paid: " . $bill[0]['amountpaid'] . '</strong><br>';
                    echo "<strong class='ml-2'>Remaining Balance: " . strval($bill[0]['grandtotal'] - $bill[0]['amountpaid']) . '</strong><br>';
                    echo "</div>";
                    ?>
                    <!-- </div> -->
                    <!-- <div>
                    <input type="button" value="print" onclick="PrintDiv();" />
                </div> -->
                </div>
            </div>
        </div>
    <?php } else {
    $message = 'You must login to see this page';
    echo
        "<script type='text/javascript'>

alert('$message');
window.location.href = 'login.php';	
            </script>";
} ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
    <script type="text/javascript">
        function PrintDiv() {
            var divToPrint = document.getElementsByClassName('container')[0];
            var popupWin = window.open('', '_blank', 'width=300,height=300');
            popupWin.document.open();
            popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
            // window.print()
        }

        function editbill() {

            var payload = {
                invoicenumber: <?php echo json_encode($_POST['invoicenumber']) ?>,
            };
            var form = document.createElement('form');
            form.style.visibility = 'hidden';
            form.method = 'POST';
            form.action = 'editbill.php';
            $.each(Object.keys(payload), function(index, key) {
                var input = document.createElement('input');
                input.name = key;
                input.value = payload[key];
                form.appendChild(input)
            });
            document.body.appendChild(form);
            form.submit();

        }
    </script>