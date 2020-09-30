<!doctype html>
<html lang="en" class="h-100">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/global.css">

  <title>Import Inventory</title>
</head>

<body class="h-100">
  <!-- MODAL START -->

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Enter Password</h5>

          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-example table-responsive" onsubmit="func()" method="post">
            <div class="form-group">
              <label for="password">Password:</label>
              <input name="password" class="form-control" id="password" placeholder="Password" required type="password">
            </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- MODAL END -->



  
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      $('#exampleModal').modal({
        backdrop: 'static',
        keyboard: false
      });
     



    });

    function func() {
      event.preventDefault();
      console.log("asd");
      var password = $('#password').val();
      $.ajax({
        type: 'POST',
        url: 'controllers/formhandler.php',
        data: {
          inventorypassword: 'inventorypassword',
          password: password,

        },
        datatype: 'JSON',
        success: function(result) {
          console.log(result)
          if (JSON.parse(result) == true) {
            $('#exampleModal').modal('hide');
            html=`<div class="m-2">
    <a href="home.php" class="text-decoration-none">
      <img src="images/home.png" class="text-center mx-auto  " alt="Logo" width="40" height="auto">
      <p class="font-weight-bold" style="font-size:0.8rem;color:black">HOME</p>
    </a></div>
  <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-10 col-md-8 col-lg-6">
        <form class="text-center" action="controllers/upload.php" method="post" enctype="multipart/form-data">
          <h2 class="text-center mt-2">Import Inventory</h2>
          <!-- <label for="fileSelect">Filename:</label> -->
          <input  class="mt-2 " type="file" name="excel" id="fileSelect">
          <input class="mt-2 " type="submit" name="submit" value="Upload">
          <p class="mt-2"><strong>Note:</strong> Only Excel files are allowed </p>
        </form>
        <a href="upload/inventory.xlsx" class="d-block text-center m-2"> <button type="button" name="download" class="btn btn-primary text-center">Export Excel</button></a>

      </div>
    </div>
  </div>`
  document.getElementsByTagName('body')[0].innerHTML=html;
          } else {
            alert("Incorrect Password");
          }
        },
        error: function(error) {
          console.log(error)
        },
      });


    }
  </script>
</body>