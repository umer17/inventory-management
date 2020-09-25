<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles/global.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-10 col-md-10 col-lg-10">
                <div class="row align-items-center text-center h-100"> 
                    <img src="images/logo.jpg" class="text-center mx-auto " alt="Logo" width="300" height="100">

                    <!-- <h1 class="text-center">Invoice</h1> -->
                </div>
                <?php
                include 'controllers/functions.php';
                // $bill = getbill('Okhf8GAvDOj0aNIL');
                // $items = getitems('Okhf8GAvDOj0aNIL');
                $bill = getbill($_POST['invoicenumber']);
                $items = getitems($_POST['invoicenumber']);

                ?>

                <div id="divToPrint">
                    <?php
                    echo "<div>";
                    echo "<div class='float-left'>";
                    echo "<p><strong>Invoice Number:</strong> " . $_POST['invoicenumber'] . "</p>";
                    echo "<p><strong>Date: </strong>" . $bill[0]['date'] . "</p>";
                    echo "<p><strong>Time: </strong>" . $bill[0]['time'] . "</p>";
                    echo "<p><strong>Account ID: </strong>" . $bill[0]['accountid'] . "</p>";
                    echo "<p><strong>Title: </strong>" . $bill[0]['customername'] . "</p>";
                    echo "<p><strong>Received By: </strong>" . $bill[0]['receivername'] . "</p>";
                    echo "</div>";



                    echo "<div class='float-right' style='page-break-after: always'>";
                    echo "<p ><strong>Transaction Type: </strong>" . $bill[0]['transactiontype'] . "</p>";
                    if ($bill[0]['transactiontype'] != "cash") {

                        echo "<p><strong>Transaction Number: </strong>" . $bill[0]['transactionnumber'] . "</p>";
                    }
                    echo "<p ><strong>Carton: </strong>" . $bill[0]['carton'] . "</p>";
                    echo "<p ><strong>Bundle: </strong>" . $bill[0]['bundle'] . "</p>";
                    echo "<p ><strong>Total: </strong>" . $bill[0]['totalcartonbundle'] . "</p>";

                    echo "</div>";
                    echo "</div>";


                    echo "<div>";
                    echo '<table id="bills"  class="table table-hover table-bordered"><tbody>';

                    echo "<tr><th>S. NO</th><th>" . "ITEM ID" . "</th><th>" . "DESCRIPTION" . "</th><th>" . "QTY" . "</th><th>" . "RATE" . "</th><th>AMOUNT</th></tr>";
                    $totalquantity = 0;
                    for ($i = 0; $i < count($items); $i++) {
                        echo "<tr><td>" . ($i + 1) . "</td><td>" . $items[$i]['itemid'] .  "</td><td>" . $items[$i]['description']  .  "</td><td>" . $items[$i]['quantity'] . "</td><td>" . $items[$i]['rate'] . "</td><td>" . $items[$i]['amount'] . "</td></tr>";
                        $totalquantity += $items[$i]['quantity'];
                        echo "<div class='pagebreak'> </div>";
                    }
                    echo "<tr><td colspan='3' class='border-right-0'>Total: </td><td colspan='3' class='border-left-0'>" . $totalquantity . "</td></tr>";
                    echo '</tbody></table>';
                    echo "</div>";


                    echo "<div class='float-right'>";
                    echo "<p ><strong>Total: </strong>" . $bill[0]['total'] . "</p>";
                    echo "<p ><strong>Previous Balance: </strong>" . $bill[0]['previousbalance'] . "</p>";
                    echo "<p ><strong>Grand Total: </strong>" . $bill[0]['grandtotal'] . "</p>";
                    echo "<p ><strong>Amount Paid: </strong>" . $bill[0]['amountpaid'] . "</p>";

                    echo "</div>";
                    ?>

                </div>
                <!-- <div>
                    <input type="button" value="print" onclick="PrintDiv();" />
                </div> -->
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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
</script>