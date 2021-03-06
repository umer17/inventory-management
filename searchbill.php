<?php session_start();
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
    <title>Search Bill</title>
  </head>

  <body class="h-100">

    <?php
    include 'controllers/functions.php';
    global $bills;
    $bills = getbills();
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

          <h1 class="text-center">Search Bills</h1>

          <!-- Input fields -->

          <div class="input-group mb-2 mt-5">
            <input type="text" class="form-control searchbill" placeholder="Search Bill" onkeyup="checkemptybar(this)">
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
              global $bills;
              if (isset($_GET['click'])) {
                renderTable($_GET['click']);
              } else { // echo count($xlsx->rows());
                // echo (count($bills));

                $pagecount = ceil(count($bills) / 10);
                // echo ($pagecount);
                echo '<table id="bills"  class="table table-hover table-bordered"><tbody>';
                $i = 1;
                echo "<tr><th>Sr. No</th><th>" . "Invoice Number" . "</th><th>" . "Customer Name" . "</th><th>" . "Grand Total" . "</th><th>" . "Date" . "</th></tr>";

                foreach ($bills as $elt) {

                  if ($i > 0 && $i > 10) {
                    break;
                  } else {

                    echo "<tr class='clickable-row' ><td>" . ($i) . "</td><td>" . $elt['invoicenumber'] .  "</td><td>" . $elt['customername']  .  "</td><td>" . $elt['grandtotal'] . "</td><td>" . strval($elt['date']) . "</td></tr>";
                  }

                  $i++;
                }


                echo '</tbody></table>';
                echo    '<nav aria-label="...">';
                echo '<ul class="pagination ">';


                for ($i = 0; $i < $pagecount; $i++) {
                  echo '<li class="page-item ">';
                  echo "<a class=\"page-link\" href=\"searchbill.php?click=" . ($i + 1) . "\">" . ($i + 1) . "</a>";
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
              global $bills;
              $pagecount = count($bills) / 10;
              // echo ceil($pagecount);
              echo '<table id="bills" class="table  table-hover table-bordered"><tbody>';
              $i = 1;
              echo "<tr><th>Sr. No</th><th>" . "Invoice Number" . "</th><th>" . "Customer Name" . "</th><th>" . "Grand Total" . "</th><th>" . "Date" . "</th></tr>";

              foreach ($bills as $elt) {

                if ($i < $loop_start) {
                  $i++;
                  continue;
                } elseif ($i > $loop_end) {
                  break;
                } else {
                  echo "<tr class='clickable-row' ><td>" . ($i) . "</td><td>" . $elt['invoicenumber'] .  "</td><td>" . $elt['customername']  .  "</td><td>" . $elt['grandtotal'] . "</td><td>" . strval($elt['date']) . "</td></tr>";
                }

                $i++;
              }

              echo '</tbody></table>';
              echo    '<nav aria-label="...">';
              echo '<ul class="pagination ">';


              for ($i = 0; $i < $pagecount; $i++) {
                echo '<li class="page-item ">';
                echo "<a class=\"page-link\" href=\"searchbill.php?click=" . ($i + 1) . "\">" . ($i + 1) . "</a>";
                echo '</li>';
              }
              echo '</ul>
        </nav>';
            }
            renderfirst();

            ?>

          </div>



          <!-- <div class="text-center">
            <button type="submit" name="generateexisting" class="btn btn-primary btn-customized text-center">Generate Bill</button>
          </div> -->


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







  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="controllers/auto.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script>
    let bills = JSON.parse('<?php echo json_encode($bills); ?>');

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

    function checkemptybar(element) {
      if (element.value.trim() == "") {
        location.reload();
      }
    }

    function renderSingle(index) {
      if (index != -1) {
        document.getElementById("bills").childNodes[0].innerHTML = `<tr><th>Sr. No</th><th>
      Invoice Number
      </th><th>
      Customer Name
      </th><th>
      Grand Total
      </th><th>
      Date
      </th></tr><tr class='clickable-row' ><td>1</td><td>${bills[index]['invoicenumber']}
      </td><td>${bills[index]['customername']}
      </td><td>${bills[index]['grandtotal']}
      </td><td>${bills[index]['date']}
      </td></tr>`

        document.getElementsByClassName("pagination")[0].style.visibility = "hidden"
        $(".clickable-row").click(function(element) {
          invoicenumber = element.target.parentElement.childNodes[1].innerHTML
          // window.location = $(this).data("href");
          var payload = {
            invoicenumber: invoicenumber.trim(),
          };
          var form = document.createElement('form');
          form.style.visibility = 'hidden';
          form.method = 'POST';
          form.action = 'bill.php';
          $.each(Object.keys(payload), function(index, key) {
            var input = document.createElement('input');
            input.name = key;
            input.value = payload[key];
            form.appendChild(input)
          });
          document.body.appendChild(form);
          form.submit();

        });
      }
    }
    jQuery(document).ready(function($) {
      $(".clickable-row").click(function(element) {
        invoicenumber = element.target.parentElement.childNodes[1].innerHTML
        // window.location = $(this).data("href");
        var payload = {
          invoicenumber: invoicenumber.trim(),
        };
        var form = document.createElement('form');
        form.style.visibility = 'hidden';
        form.method = 'POST';
        form.action = 'bill.php';
        $.each(Object.keys(payload), function(index, key) {
          var input = document.createElement('input');
          input.name = key;
          input.value = payload[key];
          form.appendChild(input)
        });
        document.body.appendChild(form);
        form.submit();

      });
    });


    invoicenumbers = []
    bills.forEach((element) => {
      invoicenumbers.push(element['invoicenumber']);
    });
    console.log(invoicenumbers);
    $(".searchbill").autocomplete({
      source: invoicenumbers,
      html: true,
      response: function(event, ui) {

        // ui.content is the array that's about to be sent to the response callback.
        if (ui.content.length === 0) {
          var noResult = {
            value: "",
            label: "No Bills Found"
          };
          ui.content.push(noResult);

        } else {
          $("#empty-message").empty();
        }
      },
      select: function(value, data) {
        renderSingle($.inArray(data.item.value, invoicenumbers))

      }
    });
  </script>
  </body>