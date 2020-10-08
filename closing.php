<?php session_start();
include 'controllers/functions.php';
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == '1') { ?>
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
        <link rel="stylesheet" href="datepicker/css/bootstrap-datepicker.standalone.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>

        <link rel="stylesheet" href="https://code.jquery.com/ui/1.9.0/themes/smoothness/jquery-ui.css" />
        <title>Closing</title>
    </head>

    <body class="h-100">

        <div class="m-2">
            <a href="index.php" class="text-decoration-none">
                <img src="images/home.png" class="text-center mx-auto  " alt="Logo" width="40" height="auto">
                <p class="font-weight-bold" style="font-size:0.8rem;color:black">HOME</p>
            </a></div>
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-10 col-md-10 col-lg-10">
                    <!-- Form -->
                    <h1 class="text-center">Closing</h1>
                    <div class="col-4 input-group date" data-provide="datepicker">


                        <input type="text" autocomplete="off" onchange="updateclosing(this)" class="form-control empty" id="iconified" placeholder="&#xF073;">
                        <div class="input-group-addon">


                        </div>
                    </div>
                    <!-- Input fields -->
                    <div class="table-responsive-sm">
                        <?php

                        global $transactions;
                        // var_dump($transactions);
                        function renderfirst($date = null)
                        {
                            global $transactions;
                            if (is_null($date)) {
                                $date = date("m/d/Y");
                            }
                            $transactions = getcustomertransactionsbydate($date);
                            $total=0;
                            foreach ($transactions as $elt) {
                                $total+=(int)$elt['amountpaid'];
                            }
                            echo "<div class='text-center'><strong class='text-center'>Total Cash: </strong>
                            <strong class='text-center'>$total</strong>
                            </div>";
                            echo '<table id="transactions"  class="table table-hover table-bordered"><tbody>';
                            $i = 1;
                            echo "<tr><th>Sr. No</th><th>" . "Account ID" . "</th><th>" . "Customer Name" . "</th><th>" . "Date" . "</th><th>" . "Time" . "</th><th>Previous Balance</th><th>Bill</th><th>Total Bill</th><th>Amount Paid</th><th> Remaining Balance</th><th>Remarks</th></tr>";
                            foreach ($transactions as $elt) {
                                echo "<tr ><td>" . ($i) . "</td><td>" . $elt['accountid'] .  "</td><td>" . $elt['customername']  .  "</td><td>" . $elt['date'] . "</td><td>" . strval($elt['time']) . "</td><td>" . $elt['previousbalance'] . "</td><td>" . $elt['bill'] . "</td><td>" . $elt['totalbill'] . "</td><td>" . $elt['amountpaid'] . "</td><td>" . $elt['remainingbalance'] . "</td><td>" . $elt['remarks'] . "</td></tr>";
                                $i++;
                            }
                            echo "<tr><td colspan='8'><strong>Total: </strong></td>
                <td colspan='3'><strong>$total</strong></td>
                
                </tr>";
                            echo '</tbody></table>';
                        }
                        if (isset($_GET['date'])) {
                            renderfirst($_GET['date']);
                        } else {
                            renderfirst();
                        }
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
    <script src="datepicker/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
        $('.input-group.date').datepicker({});
        $('#iconified').on('keyup', function() {
            var input = $(this);
            if (input.val().length === 0) {
                input.addClass('empty');
            } else {
                input.removeClass('empty');
            }
        });

        function updateclosing(element) {
            window.location = `closing.php?date=${element.value}`


        }
    </script>
    </body>