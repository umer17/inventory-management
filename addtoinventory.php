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

    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-10 col-md-10 col-lg-10">
                <!-- Form -->
                <form class="form-example table-responsive" action="controllers/formhandler.php" method="post">
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
                                    <td><input type="text" name="remainingbalance2"></td>
                                    <td><input type="text"></td>
                                    <td><input type="number"></td>
                                    <td><input type="number"></td>



                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="number"></td>
                                    <td><input type="number"></td>

                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="number"></td>
                                    <td><input type="number"></td>

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

    <script type="text/javascript">
        function addRow() {
            var tableRef = document.getElementById('bill-table').getElementsByTagName('tbody')[0];
            console.log(tableRef);
            $("#bill-table").find('tbody').append("<tr><td>" + (tableRef.rows.length + 1) + "</td><td><input type=\"text\"></td><td><input type=\"text\"></td><td><input type=\"number\"></td> <td><input type=\"number\"></td></tr>");

        }
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>