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

  <title>Search Bill</title>
</head>

<body class="h-100">

  <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-10 col-md-10 col-lg-10">
        <!-- Form -->
        <form class="form-example table-responsive" action="controllers/formhandler.php" method="post">
          <h1 class="text-center">Search Bills</h1>

          <!-- Input fields -->

          <div class="input-group mb-2 mt-5">
            <input type="text" class="form-control" placeholder="Search Bill">
            <div class="input-group-append">
              <button class="btn btn-secondary" type="button">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>


         



          <!-- <div class="text-center">
            <button type="submit" name="generateexisting" class="btn btn-primary btn-customized text-center">Generate Bill</button>
          </div> -->

        </form>
        <!-- Form end -->


      </div>
    </div>
  </div>




  <?php

  // include "SimpleXLSX.php";
  // if ( $xlsx = SimpleXLSX::parse('upload/inventory.xlsx') ) {
  //     echo '<table><tbody>';
  //     $i = 0;

  //     foreach ($xlsx->rows() as $elt) {
  //       if ($i == 0) {
  //         echo "<tr><th>" . $elt[0] . "</th><th>" . $elt[1] . "</th><th>" . $elt[2] . "</th><th>" . $elt[3] ."</th></tr>";
  //       } else {
  //         echo "<tr><td>" . $elt[0] . "</td><td>" . $elt[1] .  "</td><td>" . $elt[2] . "</td><td>" . $elt[3] ."</td></tr>";
  //       }      

  //       $i++;
  //     }

  //     echo "</tbody></table>";

  //   } else {
  //     echo SimpleXLSX::parseError();
  //   }

  ?>

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
      console.log(tableRef);
      $("#bill-table").find('tbody').append("<tr><td>" + (tableRef.rows.length + 1) + "</td><td><input type=\"text\"></td><td><input type=\"text\"></td><td><input type=\"number\"></td> <td></td><td></td></tr>");

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

      } else {
        document.getElementById("transactionnumberdiv").style.visibility = "hidden"

      }
    }

    function getTotalCartons() {
      var cartons = Number(document.getElementById("carton").value)
      var bundles = Number(document.getElementById("bundle").value)
      total = cartons + bundles
      document.getElementById("totalcartons").innerHTML = "Total: " + (cartons + bundles);
    }
  </script>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>