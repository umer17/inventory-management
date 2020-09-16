<!doctype html>
<html lang="en" class="h-100">

<head>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
  <link rel="stylesheet" href="styles/search.css">
  <link rel="stylesheet" href="styles/table.css">

  <link rel="stylesheet" href="styles/global.css">
  <title>Edit Inventory</title>
</head>

<body class="h-100">
  <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-10 col-md-10 col-lg-10">
      <h1 class="text-center">Edit Inventory</h1>
        <div class="input-group mb-2 mt-5">
          <input type="text" class="form-control has-search" placeholder="Search Item">
          <div class="input-group-append">
            <button class="btn btn-secondary" type="button">
              <i class="fa fa-search"></i>
            </button>
          </div>
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
                echo "<tr><td>".$i."</td><td><input  type=\"text\" value=\"" . $elt[0] . "\">" . "</td><td><input type=\"text\" value=\"" . $elt[1] . "\">" .  "</td><td><input type=\"number\" value=\"" . $elt[2] . "\"></td><td><input type=\"number\" value=\"" . $elt[3] . "\"></td></tr>";
              }

              $i++;
            }


            echo '</tbody></table>';
            echo    '<nav aria-label="...">';
  echo '<ul class="pagination justify-content-center">';
   
  
          for ($i = 0; $i < $pagecount; $i++) {
            echo '<li class="page-item ">';
            echo "<a class=\"page-link\" href=\"editinventory.php?click=" . ($i + 1) . "\">" . ($i + 1) . "</a>";
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
              echo "<tr><td>".$i."</td><td><input  type=\"text\" value=\"" . $elt[0] . "\">" . "</td><td><input  type=\"text\" value=\"" . $elt[1] . "\">" .  "</td><td><input type=\"number\" value=\"" . $elt[2] . "\"></td><td><input type=\"number\" value=\"" . $elt[3] . "\"></td></tr>";
            }

            $i++;
          }

          echo '</tbody></table>';
      echo    '<nav aria-label="...">';
  echo '<ul class="pagination  justify-content-center">';
   
  
          for ($i = 0; $i < $pagecount; $i++) {
            echo '<li class="page-item ">';
            echo "<a class=\"page-link\" href=\"editinventory.php?click=" . ($i + 1) . "\">" . ($i + 1) . "</a>";
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
  <script type="text/javascript">

  </script>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>