<!doctype html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="styles/table.css"> -->
    <link rel="stylesheet" href="styles/global.css">

    <title>Add Inventory</title>
</head>

<body class="h-100">
    <?php session_start();
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == '1') { ?>
        <!-- SECOND MODAL -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Items Added Successfully</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary text-center" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- SECOND MODAL END-->
        <div class="m-2">
            <a href="home.php" class="text-decoration-none">
            <img src="images/home.png" class="text-center mx-auto  " alt="Logo" width="40" height="auto">
<p class="font-weight-bold" style="font-size:0.8rem;color:black">HOME</p>
            </a></div>
        <div class="container h-100">

            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-10 col-md-10 col-lg-10">
                    <!-- Form -->
                    <form class="form-example table-responsive" onsubmit="func()" method="post">
                        <h1 class="text-center">Add To Inventory</h1>
                        <!-- Input fields -->
                        <!-- TABLE START -->
                        <div class="table-responsive-sm mt-5">
                            <table id="bill-table" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>S. NO</th>
                                        <th>ITEM ID</th>
                                        <th>DESCRIPTION</th>
                                        <th>QUANTITY</th>
                                        <th>RATE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input name="itemid[]" required type="text"></td>
                                        <td><input name="description[]" onkeyup="generateID(this)" required type="text"></td>
                                        <td><input name="quantity[]" required type="number"></td>
                                        <td><input name="rate[]" required type="number"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input name="itemid[]" type="text"></td>
                                        <td><input name="description[]" onkeyup="generateID(this)" type="text"></td>
                                        <td><input name="quantity[]" type="number"></td>
                                        <td><input name="rate[]" type="number"></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><input name="itemid[]" type="text"></td>
                                        <td><input name="description[]" onkeyup="generateID(this)" type="text"></td>
                                        <td><input name="quantity[]" type="number"></td>
                                        <td><input name="rate[]" type="number"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class=" mt-n3">
                                <button type="button" class="btn btn-primary btn-customized" onclick="return addRow()">+</button>
                            </div>
                        </div>
                        <!-- TABLE END -->
                        <div class="text-center">
                            <button type="submit" name="additems" class="btn btn-primary btn-customized text-center">Add Items</button>
                            <!-- End input fields -->
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
    <script type="text/javascript">
        function addRow() {
            var tableRef = document.getElementById('bill-table').getElementsByTagName('tbody')[0];
            console.log(tableRef);
            $("#bill-table").find('tbody').append("<tr><td>" + (tableRef.rows.length + 1) + "</td><td><input  name=\"itemid[]\" type=\"text\"></td><td><input  name=\"description[]\" onkeyup=\"generateID(this)\" type=\"text\"></td><td><input  name=\"quantity[]\" type=\"number\"></td> <td><input  name=\"rate[]\" type=\"number\"></td></tr>");
        }
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script>
        function generateID(element) {
            let values = element.value.split(' ');
            let finalString = "";
            console.log(values);
            // if(Array.isArray(values) && values.length && values[0]!="") {
            values.forEach((item) => {
                finalString += item.substring(0, 1).toUpperCase();
                // element.parentElement.previousElementSibling.childNodes[0].value = item.substring(0,1);
            });
            element.parentElement.previousElementSibling.childNodes[0].value = finalString + makeid(3);
            // }
        }

        function func() {
            event.preventDefault();
            var itemid = $('input[name=\'itemid[]\']').map(function() {
                return $(this).val();
            }).get();
            var description = $('input[name=\'description[]\']').map(function() {
                return $(this).val();
            }).get();
            var quantity = $('input[name=\'quantity[]\']').map(function() {
                return $(this).val();
            }).get();
            var rate = $('input[name=\'rate[]\']').map(function() {
                return $(this).val();
            }).get();
            $.ajax({
                type: 'POST',
                url: 'controllers/formhandler.php',
                data: {
                    additems: 'additems',
                    itemid: itemid,
                    description: description,
                    quantity: quantity,
                    rate: rate,
                },
                datatype: 'JSON',
                success: function(data) {
                    console.log(data)
                },
                error: function(error) {
                    console.log(error)
                },
            });
            $('#confirmModal').modal('toggle');
        }

        function makeid(length) {
            var result = '';
            var characters = '0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
    </script>
</body>