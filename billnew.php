<!doctype html>
<html lang="en" class="h-100">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles/global.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="styles/table.css"> -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/smoothness/jquery-ui.css" />
    <title>Bill New Customer</title>
</head>

<body class="h-100">

    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-10 col-md-10 col-lg-10">
                <!-- Form -->
                <form class="form-example table-responsive" action="controllers/formhandler.php" method="post">
                    <h1 class="text-center">Bill New Customer</h1>

                    <!-- Input fields -->
                    <div class="form-group">
                        <label for="customer_name">Customer Name:</label>
                        <input required type="text" class="form-control customer_name" id="customer_name" placeholder="Customer Name" name="customername">
                    </div>
                    <div class="form-group">
                        <label for="AccountID">Account ID:</label>
                        <input required type="AccountID" class="form-control AccountID" id="AccountID" placeholder="Account ID" name="accountid">
                    </div>
                    <div class="form-group">
                        <label for="remainingbalance">Remaining Balance:</label>
                        <input class="form-control remainingbalance" type="number" placeholder="Remaining Balance" name="remainingbalance">

                    </div>
                    <div class="form-group">
                        <label id="date" for="date">Date: </label>
                        <!-- Default unchecked -->
                        <div class="float-right">
                            <label for="transactiontype">Transaction: </label>
                            <div class="custom-control custom-radio d-inline">
                                <input type="radio" class="custom-control-input" id="bank" onclick="return toggleinput()" value="bank" name="transactiontype" checked>
                                <label class="custom-control-label" for="bank">Bank</label>
                            </div>

                            <!-- Default checked -->
                            <div class="custom-control custom-radio d-inline">
                                <input type="radio" class="custom-control-input" id="easypaisa" onclick="return toggleinput()" value="easypaisa" name="transactiontype">
                                <label class="custom-control-label" for="easypaisa">Easypaisa</label>
                            </div>
                            <div class="custom-control custom-radio d-inline">
                                <input type="radio" class="custom-control-input" id="cash" onclick="return toggleinput()" value="cash" name="transactiontype">
                                <label class="custom-control-label" for="cash">Cash</label>
                            </div>


                        </div>
                    </div>

                    <div class="form-group">
                        <label id="time" for="date">Time: </label>
                        <div id="transactionnumberdiv" class="float-right form-inline">
                            <label for="transactionnumber">Transaction Number: </label>
                            <input required class="form-control  ml-2" type="text" placeholder="Transaction Number" id="transactionnumber" name="transactionnumber">
                        </div>
                    </div>
                    <div class="form-inline mb-2">
                        <label for="receivername">Receiver Name:</label>
                        <input required type="text" class="form-control ml-2  receivername" id="receivername" placeholder="Receiver Name" name="receivername">
                    </div>

                    <div class="form-inline">
                        <label for="carton">Carton: </label>
                        <input class="form-control ml-2" id="carton" type="number" onkeyup="getTotalCartons()" placeholder="Carton" name="carton">
                    </div>
                    <div class="form-inline mt-2">
                        <label for="bundle">Bundle: </label>
                        <input class="form-control ml-2" id="bundle" type="number" onkeyup="getTotalCartons()" placeholder="Bundle" name="bundle">
                    </div>
                    <div class="form-inline mt-2">
                        <label for="totalcartonbundle">Total: </label>
                        <input readonly class="form-control ml-2 mb-2" id="totalcartonbundle" type="text" name="totalcartonbundle">
                    </div>
                    <!-- TABLE START -->
                    <div class="table-responsive-sm">
                        <table id="bill-table" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>S. NO</th>
                                    <th>ITEM ID</th>
                                    <th>DESCRIPTION</th>
                                    <th>QUANTITY</th>
                                    <th>RATE</th>
                                    <th>AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><input name="itemid[]" onkeyup="searchDescription(this)" class="itemids" required type="text"></td>
                                    <td><input name="description[]" onkeyup="searchId(this)" class="description" required type="text"></td>
                                    <td><input name="quantity[]" required type="number"></td>
                                    <td><input type="hidden" name="rate[]" required type="number"></td>
                                    <td><input type="hidden" name="amount[]" required type="number"></td>


                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><input name="itemid[]" onkeyup="searchDescription(this)" class="itemids" type="text"></td>
                                    <td><input name="description[]" onkeyup="searchId(this)" class="description" type="text"></td>
                                    <td><input name="quantity[]" type="number"></td>
                                    <td><input type="hidden" name="rate[]" type="number"></td>
                                    <td><input type="hidden" name="amount[]" type="number"></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><input name="itemid[]" onkeyup="searchDescription(this)" class="itemids" type="text"></td>
                                    <td><input name="description[]" onkeyup="searchId(this)" class="description" type="text"></td>
                                    <td><input name="quantity[]" type="number"></td>
                                    <td><input type="hidden" name="rate[]" type="number"></td>
                                    <td><input type="hidden" name="amount[]" type="number"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group float-right">
                            <label class="d-block" id="total" for="total">Total: </label>
                            <label class="d-block" id="previousbalance" for="previousbalance">Previous Balance: </label>
                            <label class="d-block" id="grandtotal" for="grandtotal">Grand Total: </label>
                        </div>
                        <div class=" mt-n3">
                            <button type="button" class="btn btn-primary btn-customized" onclick="return addRow()">+</button>
                        </div>
                    </div>




                    <!-- TABLE END -->
                    <div class="text-center">
                        <button type="submit" name="generatenew" class="btn btn-primary btn-customized text-center">Generate Bill</button>
                        <!-- End input fields -->
                    </div>

                </form>
                <!-- Form end -->


            </div>
        </div>
    </div>

    <script type="text/javascript">
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;
        document.getElementById("date").innerHTML = "Date: " + today
        document.getElementById("time").innerHTML = "Time: " + formatAMPM(new Date)



        function addRow() {
            var tableRef = document.getElementById('bill-table').getElementsByTagName('tbody')[0];
            $("#bill-table").find('tbody').append("<tr><td>" + (tableRef.rows.length + 1) + "</td><td><input class=\"itemids\" name=\"itemid[]\" onkeyup=\"searchDescription(this)\" type=\"text\"></td><td><input  onkeyup=\"searchId(this)\" name=\"description[]\" class=\"description\" type=\"text\"></td><td><input name=\"quantity[]\" type=\"number\"></td> <td><input type=\"hidden\" name=\"rate[]\" type=\"number\"></td><td><input type=\"hidden\" name=\"amount[]\" type=\"number\"></td></tr>");

        }

        function formatAMPM(date) {
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }

        function toggleinput() {
            if (document.getElementById("easypaisa").checked || document.getElementById("bank").checked) {
                document.getElementById("transactionnumberdiv").style.visibility = "visible"
                document.getElementById("transactionnumber").required = true

            } else {
                document.getElementById("transactionnumberdiv").style.visibility = "hidden"
                document.getElementById("transactionnumber").required = false


            }
        }

        function getTotalCartons() {
            var cartons = Number(document.getElementById("carton").value)
            var bundles = Number(document.getElementById("bundle").value)
            total = cartons + bundles
            document.getElementById("totalcartonbundle").value = String(cartons + bundles);
        }

        function showResult(str) {
            if (str.length == 0) {
                // document.getElementById("livesearch").innerHTML = "";
                // document.getElementById("livesearch").style.border = "0px";
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("livesearch").innerHTML = this.responseText;
                    document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "livesearch.php?q=" + str, true);
            xmlhttp.send();
        }

        function myFunction() {
            console.log("DONE");
        }
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script>
        MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
        var data;
        var itemid;
        var description;

        function searchDescription(element, value) {


            let descriptionIndex;
            for (var i = 0; i < data[0].length; i++) {
                if (value == undefined) {
                    if (element.value == data[0][i])

                    {
                        descriptionIndex = i;
                        break;
                    }
                } else {
                    if (value == data[0][i])

                    {
                        descriptionIndex = i;
                        break;
                    }
                }
            }
            if (descriptionIndex != undefined) {
                element.parentElement.nextElementSibling.childNodes[0].value = data[1][descriptionIndex];
                element.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.childNodes[0].value = data[2][descriptionIndex];
                element.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML = data[2][descriptionIndex];
            }
        }

        function searchId(element, value) {

            let idIndex;
            for (var i = 0; i < data[0].length; i++) {
                if (value == undefined) {
                    if (element.value == data[1][i])

                    {
                        idIndex = i;
                        break;
                    }
                } else {
                    if (value == data[1][i])

                    {
                        idIndex = i;
                        break;
                    }
                }
            }
            if (idIndex != undefined) {
                element.parentElement.previousElementSibling.childNodes[0].value = data[0][idIndex];
                element.parentElement.nextElementSibling.nextElementSibling.childNodes[0].value = data[2][idIndex];
                element.parentElement.nextElementSibling.nextElementSibling.innerHTML = data[2][idIndex];
            }
        }
        var observer = new MutationObserver(function(mutations, observer) {
            // fired when a mutation occurs

            try {
                $(".itemids").autocomplete({
                    source: data[0],
                    select: function(value, data) {
                        // console.log(value.target,data.item.value);
                        searchDescription(value.target, data.item.value);
                    }
                });
                $(".description").autocomplete({
                    source: data[1],
                    select: function(value, data) {
                        searchId(value.target, data.item.value);
                    }
                });
            } catch (error) {
                console.log(error);
            }


            // ...
        });
        observer.observe(document, {
            // attributes: true,
            childList: true,
            // characterData: true,
            subtree: true
            //...
        });
        $(document).ready(function() {

            $.ajax({
                type: 'get',
                url: 'controllers/search.php',
                dataType: 'json',
                cache: false,
                success: function(result) {
                    data = result;
                    $(".itemids").autocomplete({
                        source: data[0],
                        select: function(value, data) {
                            searchDescription(value.target, data.item.value);
                        }
                    });
                    $(".description").autocomplete({
                        source: data[1],
                        select: function(value, data) {
                            searchId(value.target, data.item.value);
                        }
                    });
                },
            });

        });
    </script>

</body>