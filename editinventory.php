<!doctype html>
<html lang="en" class="h-100">

<head>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->

  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
  <link rel="stylesheet" href="styles/search.css">
  <link rel="stylesheet" href="styles/table.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="styles/table.css"> -->
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/smoothness/jquery-ui.css" />

  <link rel="stylesheet" href="styles/global.css">
  <title>Edit Inventory</title>
</head>

<body class="h-100">
  <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-10 col-md-10 col-lg-10">
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
                <p class="text-center">Inventory Edited Successfully</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary text-center" data-dismiss="modal">Ok</button>

              </div>
            </div>
          </div>
        </div>
        <!-- SECOND MODAL END-->
        <h1 class="text-center">Edit Inventory</h1>
        <div class="input-group mb-2 mt-5">
          <input type="text" class="form-control has-search description" onkeyup="checkemptybar(this)" placeholder="Search Item">
          <div class="input-group-append">
            <button class="btn btn-secondary" type="button">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
        <div class="text-center">
          <button type="button" onclick=" saveExcel(this)" class="btn btn-primary btn-customized text-center sticky">Save Records</button>
        </div>

        <div class="table-responsive-sm">
          <?php

          include "controllers/SimpleXLSX.php";
          if ($xlsx = SimpleXLSX::parse('upload/inventory.xlsx')) {
            if (isset($_GET['click'])) {
              renderTable($_GET['click'], $xlsx);
            } else { // echo count($xlsx->rows());

              $pagecount = count($xlsx->rows()) / 100;
              // echo ceil($pagecount);
              echo '<table id="inventory"  class="table table-hover table-bordered"><tbody>';
              $i = 0;

              foreach ($xlsx->rows() as $elt) {
                if ($i == 0) {
                  echo "<tr><th>Sr. No</th><th>" . $elt[0] . "</th><th>" . $elt[1] . "</th><th>" . $elt[2] . "</th><th>" . $elt[3] . "</th></tr>";
                } elseif ($i > 0 && $i > 100) {
                  break;
                } else {
                  echo "<tr><td>" . $i . "</td><td><input name='itemid[]' type=\"text\" value=\"" . $elt[0] . "\">" . "</td><td><input name='description[]' type=\"text\" value=\"" . $elt[1] . "\">" .  "</td><td><input name='quantity[]' type=\"number\" value=\"" . $elt[2] . "\"></td><td><input name='rate[]' type=\"number\" value=\"" . $elt[3] . "\"></td></tr>";
                }

                $i++;
              }


              echo '</tbody></table>';
              echo    '<nav aria-label="...">';
              echo '<ul class="pagination justify-content-center">';


              for ($i = 0; $i < $pagecount; $i++) {
                echo '<li class="page-item ">';
                echo "<a  class=\"page-link\" onclick=' saveExcel(this)' href=\"editinventory.php?click=" . ($i + 1) . "\" >" . ($i + 1) . "</a>";
                echo '</li>';
              }
              echo '</ul> </nav>';
            }
          } else {
            echo SimpleXLSX::parseError();
          }
          function renderTable($number, $xlsx)
          {
            $loop_start = ($number * 100) - 99;
            $loop_end = ($number * 100);


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

            $pagecount = count($xlsx->rows()) / 100;
            // echo ceil($pagecount);
            echo '<table id="inventory" class="table w-auto table-hover table-bordered"><tbody>';
            $i = 0;

            foreach ($xlsx->rows() as $elt) {
              if ($i == 0) {
                echo "<tr><th>Sr. No</th></th><th>" . $elt[0] . "</th><th>" . $elt[1] . "</th><th>" . $elt[2] . "</th><th>" . $elt[3] . "</th></tr>";
              } elseif ($i < $loop_start) {
                $i++;
                continue;
              } elseif ($i > $loop_end) {
                break;
              } else {
                echo "<tr><td>" . $i . "</td><td><input name='itemid[]' type=\"text\" value=\"" . $elt[0] . "\">" . "</td><td><input name='description[]' type=\"text\" value=\"" . $elt[1] . "\">" .  "</td><td><input name='quantity[]' type=\"number\" value=\"" . $elt[2] . "\"></td><td><input name='rate[]' type=\"number\" value=\"" . $elt[3] . "\"></td></tr>";
              }

              $i++;
            }

            echo '</tbody></table>';
            echo    '<nav aria-label="...">';
            echo '<ul class="pagination  justify-content-center">';


            for ($i = 0; $i < $pagecount; $i++) {
              echo '<li class="page-item ">';
              echo "<a onclick='saveExcel(this)' class=\"page-link\" href=\"editinventory.php?click=" . ($i + 1) . "\">" . ($i + 1) . "</a>";
              echo '</li>';
            }
            echo '</ul>
        </nav>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="controllers/auto.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script>
    var data;
    var originalids = [];



    function saveExcel(element) {

      // $('#confirmModal').modal('toggle');
      event.preventDefault();
      let indexes = getIndexes();
      console.log(originalids);

      console.log(indexes);
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
          editexcel: 'editexcel',
          itemid: itemid,
          description: description,
          quantity: quantity,
          rate: rate,
          indexes: indexes,
        },
        datatype: 'JSON',
        success: function(data) {
          if (element != null) {
            if (element.type == "button") {
              $('#confirmModal').modal('toggle');
            } else if (element.type == "text") {

            } else {
              let href = element.href;
              window.location = href;
            }
          }
        },
        error: function(error) {
          console.log(error)
        },
      });



    }

    function checkemptybar(element) {
      if (element.value.trim() == "") {
        saveExcel(element);
        location.reload();
      }
    }

    function renderSingle(index) {

      if (index != -1) {
        saveExcel(null);
        document.getElementById("inventory").childNodes[0].innerHTML = `<tr><th>Sr. No</th><th>
      Item ID
      </th><th>
      Description
      </th><th>
      Quantity
      </th><th>
      Rate
      </th></tr><tr><td>1</td><td><input name='itemid[]' type="text" value=${data[0][index]}></td><td><input name='description[]' type="text" value="${data[1][index]}"></td>
      <td><input name='quantity[]' type="number" value=${data[2][index]}></td>
      <td><input name='rate[]' type="number" value=${data[3][index]}>
      </td></tr>`
        document.getElementsByClassName("pagination")[0].style.visibility = "hidden"
        originalids=[data[0][index]]
        console.log(originalids);
      }

    }

    function getIndexes() {
      let indexes = [];


      let idIndex;
      for (var i = 0; i < originalids.length; i++) {


        for (var j = 0; j < data[0].length; j++) {
          if (originalids[i] != undefined) {
            if (originalids[i] == data[0][j])

            {
              idIndex = j;
              indexes.push(idIndex);
              break;

            }
          }
        }

      }
      // $('input:hidden[name=\'indexes[]\']').val(indexes);

      return indexes;


    }
    $(document).ready(function() {
      console.log("READY");
      var originalidinput = document.getElementsByName('itemid[]');
      for (var i = 0; i < originalidinput.length; i++) {
        originalids.push(originalidinput[i].value);
      }
      $.ajax({
        type: 'get',
        url: 'controllers/search.php',
        dataType: 'json',
        cache: false,
        success: function(result) {

          data = result;


          $(".description").autocomplete({
            source: data[1],
            html: true,
            response: function(event, ui) {


              if (ui.content.length === 0) {
                var noResult = {
                  value: "",
                  label: "Item Not Found"
                };
                ui.content.push(noResult);

              } else {
                $("#empty-message").empty();
              }
            },
            select: function(value, data2) {
              // searchDescription(value.target, data.item.value);

              renderSingle($.inArray(data2.item.value, data[1]))
            }
          });

        },

      });

    });
  </script>
</body>