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
    <title>Inventory Home Page</title>
</head>

<body class="h-100">

    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-10 col-md-10 col-lg-10">
                <!-- Form -->
                    <h1 class="text-center">Inventory System</h1>






                   




                    <!-- TABLE END -->
                    <div class="text-center ">
                        <a href="billexisting.php" class="d-block m-2"><button type="button" name="billexisting" class=" btn btn-primary btn-customized text-center">Bill Existing Customer</button></a>
                       <a href="billnew.php" class="d-block m-2"> <button type="button" name="billnew" class="btn btn-primary btn-customized text-center">Bill New Customer</button></a>
                       <a href="customertransaction.php" class="d-block m-2"> <button type="button" name="customertransaction" class="btn btn-primary btn-customized text-center">Customer Transaction</button></a>
                       <a href="customerledger.php" class="d-block m-2"> <button type="button" name="customerledger" class="btn btn-primary btn-customized text-center">Customer Ledger</button></a>
                       <a href="importinventory.php" class="d-block m-2"> <button type="button" name="importinventory" class="btn btn-primary btn-customized text-center">Import Inventory</button></a>
                       <a href="addtoinventory.php" class="d-block m-2"> <button type="button" name="additems" class="btn btn-primary btn-customized text-center">Add Items</button></a>
                       <a href="editinventory.php" class="d-block m-2"> <button type="button" name="edititems" class="btn btn-primary btn-customized text-center">Edit Items</button></a>
                       <a href="searchbill.php" class="d-block m-2"> <button type="button" name="searchbill" class="btn btn-primary btn-customized text-center">Search Bill</button></a>
                       <a href="vendorledger.php" class="d-block m-2"> <button type="button" name="vendorledger" class="btn btn-primary btn-customized text-center">Vendor Ledger</button></a>
                       <a href="newvendor.php" class="d-block m-2"> <button type="button" name="newvendor" class="btn btn-primary btn-customized text-center">New Vendor </button></a>
                       <a href="vendortransaction.php" class="d-block m-2"> <button type="button" name="vendortransaction" class="btn btn-primary btn-customized text-center">Vendor Transaction</button></a>
                        <!-- End input fields -->
                    </div>

          
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