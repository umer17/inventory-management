<?php session_start();
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']=='1') { ?>
<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/search.css">
    <link rel="stylesheet" href="styles/global.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.9.0/themes/smoothness/jquery-ui.css" />
<style>
    ul.pagination {
    white-space: nowrap;
    overflow-x: auto;
}

ul.pagination li {
    display: inline-block;
    float: none;
}
</style>
    <title>Customer Ledger</title>
</head>

<body class="h-100">
    <?php


    include 'controllers/functions.php';
    global $transactions;
    global $customernames;
    $customernames = getcustomernames();

    $transactions = getcustomertransactions();
    ?>
     
    <div class="m-2">
            <a href="index.php" class="text-decoration-none">
            <img src="images/home.png" class="text-center mx-auto  " alt="Logo" width="40" height="auto">
<p class="font-weight-bold" style="font-size:0.8rem;color:black">HOME</p>
            </a></div>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-10 col-md-10 col-lg-10">
                <!-- Form -->

                <h1 class="text-center">Customer Ledger</h1>

                <!-- Input fields -->

                <div class="input-group mb-2 mt-5">
                    <input type="text" class="form-control searchtransaction" placeholder="Search Transaction" onkeyup="checkempty(this)">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="table-responsive-sm">

                    <?php
                    function renderfirst()
                    {
                        global $transactions;
                        if (isset($_GET['click'])) {

                            renderTable($_GET['click']);
                        } else { // echo count($xlsx->rows());
                            // echo (count($transactions));


                            $pagecount = ceil(count($transactions) / 10);


                            // echo ($pagecount);
                            echo '<table id="transactions"  class="table table-hover table-bordered"><tbody>';
                            $i = 1;
                            echo "<tr><th>Sr. No</th><th>" . "Account ID" . "</th><th>" . "Customer Name" . "</th><th>" . "Date" . "</th><th>" . "Time" . "</th><th>Previous Balance</th><th>Bill</th><th>Total Bill</th><th>Amount Paid</th><th> Remaining Balance</th><th>Remarks</th></tr>";

                            foreach ($transactions as $elt) {

                                if ($i > 0 && $i > 10) {
                                    break;
                                } else {

                                    echo "<tr ><td>" . ($i) . "</td><td>" . $elt['accountid'] .  "</td><td>" . $elt['customername']  .  "</td><td>" . $elt['date'] . "</td><td>" . strval($elt['time']) . "</td><td>" . $elt['previousbalance'] . "</td><td>" . $elt['bill'] . "</td><td>" . $elt['totalbill'] . "</td><td>" . $elt['amountpaid'] . "</td><td>" . $elt['remainingbalance'] . "</td><td>" . $elt['remarks'] . "</td></tr>";
                                }

                                $i++;
                            }


                            echo '</tbody></table>';

                            echo    '<nav  aria-label="...">';
                            echo '<ul class="pagination ">';



                            for ($i = 0; $i < $pagecount; $i++) {
                                echo '<li class="page-item ">';
                                echo "<a class=\"page-link\" href=\"customerledger.php?click=" . ($i + 1) . "\">" . ($i + 1) . "</a>";
                                echo '</li>';
                            }
                            echo '</ul> </nav>';
                        }
                    }
                    function renderTable($number)
                    {
                        $loop_start = ($number * 10) - 9;
                        $loop_end = ($number * 10);


                        // $pagecount = count($xlsx->rows()) / 100;
                        // echo '<table id="inventory"><tbody>';
                        // echo "<tr><th>" . $xlsx->rows()[0][0] . "</th><th>" . $xlsx->rows()[0][1] . "</th><th>" . $xlsx->rows()[0][2] . "</th><th>" . $xlsx->rows()[0][3] . "</th></tr>";
                        // for ($loop_variable; $loop_variable < ($number * 100); $loop_variable++) {
                        //   if (array_key_exists($loop_variable, $xlsx->rows())) {
                        //     echo "<tr><td><input  type=\"text\" value=\"" . $xlsx->rows()[$loop_variable][0] . "\">" . "</td><td><input type=\"text\" value=\"" . $xlsx->rows()[$loop_variable][1] . "\">" .  "</td><td><input type=\"number\" value=\"" . $xlsx->rows()[$loop_variable][2] . "\"></td><td><input type=\"number\" value=\"" . $xlsx->rows()[$loop_variable][3] . "\"></td></tr>";
                        //   } else {
                        //     break;
                        //   }
                        // }
                        // echo '<table id="inventory"><tbody>';
                        // for ($i = 0; $i < $pagecount; $i++) {
                        //   echo"<a href=\"editinventory.php?click=".($i + 1)."\">".($i + 1)."</a>";
                        // }
                        global $transactions;

                        $pagecount = ceil(count($transactions) / 10);

                        // echo ceil($pagecount);
                        echo '<table id="transactions" class="table  table-hover table-bordered"><tbody>';
                        $i = 1;
                        echo "<tr><th>Sr. No</th><th>" . "Account ID" . "</th><th>" . "Customer Name" . "</th><th>" . "Date" . "</th><th>" . "Time" . "</th><th>Previous Balance</th><th>Bill</th><th>Total Bill</th><th>Amount Paid</th><th> Remaining Balance</th><th>Remarks</th></tr>";

                        foreach ($transactions as $elt) {

                            if ($i < $loop_start) {
                                $i++;
                                continue;
                            } elseif ($i > $loop_end) {
                                break;
                            } else {

                                echo "<tr ><td>" . ($i) . "</td><td>" . $elt['accountid'] .  "</td><td>" . $elt['customername']  .  "</td><td>" . $elt['date'] . "</td><td>" . strval($elt['time']) . "</td><td>" . $elt['previousbalance'] . "</td><td>" . $elt['bill'] . "</td><td>" . $elt['totalbill'] . "</td><td>" . $elt['amountpaid'] . "</td><td>" . $elt['remainingbalance'] . "</td><td>" . $elt['remarks'] . "</td></tr>";
                            }

                            $i++;
                        }


                        echo '</tbody></table>';
                        echo    '<nav aria-label="...">';
                        echo '<ul class="pagination  ">';



                        for ($i = 0; $i < $pagecount; $i++) {
                            echo '<li class="page-item ">';
                            echo "<a class=\"page-link\" href=\"customerledger.php?click=" . ($i + 1) . "\">" . ($i + 1) . "</a>";
                            echo '</li>';
                        }
                        echo '</ul></nav>';
                    }
                    renderfirst();

                    ?>

                </div>

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
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="controllers/auto.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script>
        function checkempty(element) {
            if (element.value.trim() == "") {
                location.reload();
            }
        }
    </script>
    <script type="text/javascript">
        let transactions = JSON.parse('<?php echo json_encode($transactions); ?>');



        function createCookie(name, value, days) {
            var expires;
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            } else {
                expires = "";
            }
            document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";

        }

        function renderTransactions(value) {
            if (value.trim() != '') {
                var totalpaid = 0;
                var totalprevious = 0;
                var totalremaining = 0;
                var totalbill = 0;
                var totaltotalbill=0;
                var x = 0;
                var html
                html = `<table id=\"transactions\"  class=\"table table-hover table-bordered\"><tbody>
                <tr><th>Sr. No</th><th>Account ID</th><th>Customer Name</th><th>Date</th><th>Time</th>
                <th>Previous Balance</th><th>Bill</th><th>Total Bill</th><th>Amount Paid</th><th> Remaining Balance</th><th>Remarks</th></tr>
                `
                for (var i = 0; i < transactions.length; i++) {

                    if (transactions[i]['customername'] == value) {
                        x += 1;
                        totalpaid += Number(transactions[i]['amountpaid']);
                        totalprevious += Number(transactions[i]['previousbalance']);
                        totalremaining += Number(transactions[i]['remainingbalance']);
                        totalbill += Number(transactions[i]['bill']);
                        totaltotalbill += Number(transactions[i]['totalbill']);

                        html += `<tr><td>${x}</td><td>${transactions[i]['accountid']}</td>
                        <td>${transactions[i]['customername']}</td><td>${transactions[i]['date']}</td>
                        <td>${transactions[i]['time']}</td> <td>${transactions[i]['previousbalance']}</td>
                        <td>${transactions[i]['bill']}</td><td>${transactions[i]['totalbill']}</td>
                        <td>${transactions[i]['amountpaid']}</td><td>${transactions[i]['remainingbalance']}</td>
                        <td>${transactions[i]['remarks']}</td></tr>`
                    }
                }
                html+=`<tr><td colspan='5'><strong>Total: </strong></td>
                <td><strong>${totalprevious}</strong></td>
                <td><strong>${totalbill}</strong></td><td><strong>${totaltotalbill}</strong></td>
                <td><strong>${totalpaid}</strong></td><td><strong>${totalremaining}</strong></td>
                <td></td></tr>`
                html += `</tbody></table>`;
                console.log(html);
                console.log(document.cookie);
                document.getElementsByClassName("table-responsive-sm")[0].innerHTML = html;


            }
        }

        customernames = []
        customers = JSON.parse('<?php echo json_encode($customernames); ?>');
         customers.forEach((element) => {
            customernames.push(element['customername']);
        });
        console.log(customernames);
        $(".searchtransaction").autocomplete({
            source: customernames,
            html: true,
            response: function(event, ui) {

                // ui.content is the array that's about to be sent to the response callback.
                if (ui.content.length === 0) {
                    var noResult = {
                        value: "",
                        label: "No transactions Found"
                    };
                    ui.content.push(noResult);

                } else {
                    $("#empty-message").empty();
                }
            },
            select: function(value, data) {
                console.log(data.item.value);
                renderTransactions(data.item.value)

            }
        });
    </script>
</body>