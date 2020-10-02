<?php session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == '1') { ?>
    <!doctype html>
    <html lang="en" class="h-100">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.9.0/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="styles/global.css">

        <title>Add New Vendor</title>
    </head>

    <body class="h-100">

        <!-- Modal Start-->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title " id="exampleModalLabel">Success</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Vendor Added Successfully</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary text-center" onClick='window.location.reload()' data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-2">
            <a href="index.php" class="text-decoration-none">
                <img src="images/home.png" class="text-center mx-auto  " alt="Logo" width="40" height="auto">
                <p class="font-weight-bold" style="font-size:0.8rem;color:black">HOME</p>
            </a></div>
        <!-- Modal End -->
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-10 col-md-10 col-lg-10">
                    <!-- Form -->
                    <form class="form-example table-responsive" onsubmit="addVendor()" method="post">
                        <h1 class="text-center">Add New Vendor</h1>
                        <!-- Input fields -->
                        <div class="form-group">
                            <label for="vendorname">Vendor Name:</label>
                            <input required type="text" class="form-control" id="vendorname" placeholder="Vendor Name" name="vendorname">
                        </div>
                        <div class="form-group">
                            <label for="vendorid">Vendor ID:</label>
                            <input required type="text" class="form-control" id="vendorid" placeholder="Vendor ID" name="vendorid">
                        </div>
                        <div class="form-group">
                            <label for="remainingbalance">Remaining Balance:</label>
                            <input class="form-control" type="number" id="remainingbalance" placeholder="Remaining Balance" name="remainingbalance">
                        </div>
                        <div class="form-group">
                            <label id="time" for="date">Time: </label>
                        </div>
                        <div class="form-group">
                            <label id="date" for="date">Date: </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="addvendor" class="btn btn-primary btn-customized text-center">Add Vendor</button>
                        </div>
                    </form>
                    <!-- Form end -->
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
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="controllers/auto.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script>
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = mm + '/' + dd + '/' + yyyy;
        document.getElementById("date").innerHTML = "Date: " + today
        document.getElementById("time").innerHTML = "Time: " + formatAMPM(new Date)

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

        function addVendor() {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'controllers/formhandler.php',
                data: {
                    addvendor: 'asd',
                    vendorname: document.getElementById("vendorname").value,
                    vendorid: document.getElementById("vendorid").value,
                    remainingbalance: Number(document.getElementById("remainingbalance").value),
                },
                datatype: 'JSON',
                success: function(data) {
                    console.log(data)
                    if (JSON.parse(data) == true) {
                        $('#confirmModal').modal('toggle');
                    } else {
                        alert("There was an error inserting data in vendors table")
                    }

                },
                error: function(error) {
                    alert(error)
                },
            });
        }
    </script>
    </body>