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

<body > 
    <?php
    
    session_start();

    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']=='1') { ?>
 
 <div class="">
            <button type="button" onclick=" logout()" class=" btn btn-outline-primary  btn-customized  stickylogout">LOGOUT</button>
          </div>

        <div class="container  h-100 w-50">
        
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-10 col-md-10 col-lg-10">
                    <!-- Form -->

                    <!-- TABLE END -->
                    <div class="row d-block align-items-center text-center h-100 mb-5">
                        <img src="images/logo.png" class="text-center mx-auto " alt="Logo" width="300" height="100">
                        <h1 class="text-center d-block ">Razzaq Autos Inventory</h1>
                        <!-- <h1 class="text-center">Invoice</h1> -->
                    </div>
                    <div class=" ">
                        <!-- End input fields -->
                        <div class="category m-4 d-block">
                            <h3>BILLING</h3>
                            <a href="billexisting.php" class="d-inline mr-4"><button type="button" name="billexisting" class=" btn btn-outline-secondary  btn-customized text-center">BILL EXISTING CUSTOMER</button></a>
                            <a href="billnew.php" class="d-inline mr-4"> <button type="button" name="billnew" class="btn btn-outline-secondary  btn-customized text-center">BILL NEW CUSTOMER</button></a>
                            <a href="searchbill.php" class="d-inline mr-4"> <button type="button" name="searchbill" class="btn btn-outline-secondary  btn-customized text-center">SEARCH BILL</button></a>
                        </div>
                        <div class="category m-4 d-block">
                            <h3>CUSTOMERS</h3>

                            <a href="customertransaction.php" class="d-inline mr-4"> <button type="button" name="customertransaction" class="btn btn-outline-secondary  btn-customized text-center">CUSTOMER TRANSACTION</button></a>
                            <a href="customerledger.php" class="d-inline mr-4"> <button type="button" name="customerledger" class="btn btn-outline-secondary  btn-customized text-center">CUSTOMER LEDGER</button></a>
                        </div>
                        <div class="category m-4 d-block">
                            <h3>INVENTORY</h3>

                            <a href="importinventory.php" class="d-inline mr-4"> <button type="button" name="importinventory" class="btn btn-outline-secondary  btn-customized text-center">IMPORT INVENTORY</button></a>
                            <a href="addtoinventory.php" class="d-inline mr-4"> <button type="button" name="additems" class="btn btn-outline-secondary  btn-customized text-center">ADD ITEMS</button></a>
                            <a href="editinventory.php" class="d-inline mr-4"> <button type="button" name="edititems" class="btn btn-outline-secondary  btn-customized text-center">EDIT ITEMS</button></a>
                        </div>
                        <div class="category m-4 d-block">
                            <h3>VENDOR</h3>

                            <a href="vendorledger.php" class="d-inline mr-4"> <button type="button" name="vendorledger" class="btn btn-outline-secondary  btn-customized text-center">VENDOR LEDGER</button></a>
                            <a href="newvendor.php" class="d-inline mr-4"> <button type="button" name="newvendor" class="btn btn-outline-secondary  btn-customized text-center">NEW VENDOR</button></a>
                            <a href="vendortransaction.php" class="d-inline mr-4"> <button type="button" name="vendortransaction" class="btn btn-outline-secondary  btn-customized text-center">VENDOR TRANSACTION</button></a>
                        </div>
                    </div>
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
            $("#bill-table").find('tbody').append("<tr><td>" + (tableRef.rows.length + 1) + "</td><td><input type=\"text\"></td><td><input type=\"text\"></td><td><input type=\"number\"></td> <td><input type=\"number\"></td></tr>");
        }
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="controllers/auto.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script>
     function logout()
    {
        
            
            $.ajax({
                type: 'POST',
                url: 'controllers/formhandler.php',
                data: {
                    logout: 'logout',
                  
                },
                datatype: 'JSON',
                success: function(data) {
                   window.location="login.php"
                },
                error: function(error) {
                    console.log(error)
                },
            });
        
        }
</script>
</body>