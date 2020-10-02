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
    <title>Edit Bill</title>
  </head>

  <body class="h-100">
    <?php
    include 'controllers/functions.php';
    // $bill = getbill('Okhf8GAvDOj0aNIL');
    // $items = getitems('Okhf8GAvDOj0aNIL');
    $bill = getbill($_POST['invoicenumber']);
    $items = getitems($_POST['invoicenumber']);
    ?>
    <!-- Modal Start-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="form-example table-responsive" onsubmit="func()" method="post">
              <div class="form-group">
                <label for="itemid1">Item ID:</label>
                <input name="itemid" class="form-control" id="itemid1" placeholder="Item ID" required type="text">
              </div>
              <div class="form-group">
                <label for="description1">Descritpion:</label>
                <input name="description" class="form-control" id="description1" onkeyup="generateID(this)" placeholder="Description" required type="text">
              </div>
              <div class="form-group">
                <label for="quantity1">Quantity:</label>
                <input name="quantity" class="form-control" id="quantity1" placeholder="Quantity" required type="number">
              </div>
              <div class="form-group">
                <label for="rate1">Rate:</label>
                <input name="rate" class="form-control" id="rate1" placeholder="Rate" required type="number">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add Item</button>
          </div>
          </form>
        </div>
      </div>
    </div>
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
            <p class="text-center">Item Added Successfully</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary text-center" data-dismiss="modal">Ok</button>
          </div>
        </div>
      </div>
    </div>
    <!-- SECOND MODAL END-->
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
        document.getElementById("itemid1").value = finalString + makeid(3);
        // }
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
    <!-- Modal End -->
    <div class="m-2">
      <a href="index.php" class="text-decoration-none">
        <img src="images/home.png" class="text-center mx-auto  " alt="Logo" width="40" height="auto">
        <p class="font-weight-bold" style="font-size:0.8rem;color:black">HOME</p>
      </a></div>
    <div class="container h-100">
      <div class="row h-100 justify-content-center align-items-center">
        <div class="col-10 col-md-10 col-lg-10">
          <!-- Form -->
          <form class="form-example table-responsive" action="controllers/formhandler.php" method="post">
            <input type="hidden" name="accountid" id="accountid" type="text">
            <h1 class="text-center">Edit Bill</h1>
            <!-- Input fields -->

            <div class="form-group">
              <?php echo "<p><strong>Invoice Number:</strong> " . $_POST['invoicenumber'] . "</p><input type='hidden' id='invoicenumber' name='invoicenumber' type='text'value='" . $_POST['invoicenumber'] . "'>"; ?>
              <?php echo "<p><strong>Customer Name:</strong> " .  $bill[0]['customername'] . "</p><input type='hidden' id='customername' name='customername' type='text' value='" . $bill[0]['customername'] . "'>"; ?>
              <?php echo "<p><strong>Account ID:</strong> " .  $bill[0]['accountid'] . "</p><input type='hidden' id='accountid' name='accountid' type='text' value='" . $bill[0]['accountid'] . "'>"; ?>

              <label id="date" for="date">Date: </label>
              <!-- Default unchecked -->
              <div class="float-right">
                <label for="transactiontype">Transaction: </label>
                <div class="custom-control custom-radio d-inline">
                  <input type="radio" class="custom-control-input" id="bank" onclick="return toggleinput()" value="bank" name="transactiontype" checked>
                  <label class="custom-control-label" for="bank">Bank</label>
                </div>
                <!-- Default checked -->
                <div class="custom-control custom-radio d-inline">
                  <input type="radio" class="custom-control-input" id="easypaisa" onclick="return toggleinput()" value="easypaisa" name="transactiontype">
                  <label class="custom-control-label" for="easypaisa">Easypaisa</label>
                </div>
                <div class="custom-control custom-radio d-inline">
                  <input type="radio" class="custom-control-input" id="cash" onclick="return toggleinput()" value="cash" name="transactiontype">
                  <label class="custom-control-label" for="cash">Cash</label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label id="time" for="date">Time: </label>
              <div id="transactionnumberdiv" class="float-right form-inline">
                <label for="transactionnumber">Transaction Number: </label>
                <input required class="form-control  ml-2" type="text" placeholder="Transaction Number" id="transactionnumber" name="transactionnumber" value=<?php if ($bill[0]['transactiontype'] != "cash") {
                                                                                                                                                                  echo json_encode($bill[0]['transactionnumber']);
                                                                                                                                                                } ?>>
              </div>
            </div>
            <div class="form-inline mb-2">
              <label for="receivername">Receiver Name:</label>
              <input type="text" class="form-control ml-2  receivername" id="receivername" placeholder="Receiver Name" value=<?php echo $bill[0]['receivername']; ?> name="receivername">
            </div>
            <div class="form-inline">
              <label for="carton">Carton: </label>
              <input class="form-control ml-2" id="carton" type="number" onkeyup="getTotalCartons()" placeholder="Carton" value=<?php echo $bill[0]['carton']; ?> name="carton">
            </div>
            <div class="form-inline mt-2">
              <label for="bundle">Bundle: </label>
              <input class="form-control ml-2" id="bundle" type="number" onkeyup="getTotalCartons()" placeholder="Bundle" value=<?php echo $bill[0]['bundle']; ?> name="bundle">
            </div>
            <div class="form-inline mt-2">
              <label for="totalcartonbundle">Total: </label>
              <input readonly class="form-control ml-2 mb-2" id="totalcartonbundle" value=<?php echo $bill[0]['totalcartonbundle']; ?> type="text" name="totalcartonbundle">
            </div>
            <!-- TABLE START -->
            <div class="table-responsive-sm">
              <table id="bill-table" class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>S. NO</th>
                    <th>ITEM ID</th>
                    <th>DESCRIPTION</th>
                    <th>QUANTITY</th>
                    <th>RATE</th>
                    <th>AMOUNT</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  for ($j = 0; $j < count($items); $j++) {

                    echo "<tr>
                      <td>" . ($j + 1) . "</td>
                      <td><input name='itemid[]' onkeyup='searchDescription(this)' class='itemids' required type='text' value='" . $items[$j]['itemid'] . "'>"  . "</td>
                      <td><input name='description[]' onkeyup='searchId(this)' class='description' required type='text' value='" . $items[$j]['description'] . "'>"  . "</td>
                      <td><input name='quantity[]' onkeyup='updateAmount(this)'  required type='number' value='" . $items[$j]['quantity'] . "'>"  . "</td>
                      <td><input type='hidden' name='rate[]' type='number' value='" . $items[$j]['rate'] . "'>
                      <p class='text-center'>" . $items[$j]['rate'] . "</p></td>
                      <td><input type='hidden' name='amount[]' type='number' value='" . $items[$j]['amount'] . "'>
                      <p class='text-center'>" . $items[$j]['amount'] . "</p></td>
                      </tr>";
                  }
                  ?>




                </tbody>
              </table>
              <div class="form-group float-right">
                <label class="d-block" id="total" for="total">
                  <p>Total: <?php echo $bill[0]['total']; ?> </p><input type="hidden" name="total" type="number" value=<?php echo $bill[0]['total']; ?>>
                </label>
                <label class="d-block" for="previousbalance">
                  <p class="previousbalance">Previous Balance: <?php echo $bill[0]['previousbalance']; ?> </p><input type="hidden" id="previousbalance" name="previousbalance" type="number" value=<?php echo $bill[0]['previousbalance']; ?>>
                </label>
                <label class="d-block" id="grandtotal" for="grandtotal">
                  <p>Grand Total: <?php echo $bill[0]['grandtotal']; ?></p><input type="hidden" name="grandtotal" type="number" value=<?php echo $bill[0]['grandtotal']; ?>>
                </label>
                <div class="form-inline mt-2">
                  <label for="amountpaid">Amount Paid: </label>
                  <input class="form-control ml-2 mb-2" id="amountpaid" type="number" name="amountpaid" value=<?php echo $bill[0]['amountpaid']; ?>>
                </div>
              </div>
              <div class=" mt-n3">
                <button type="button" class="btn btn-primary btn-customized" onclick="return addRow()">+</button>
              </div>
            </div>
            <input type="hidden" name="indexes[]" type="number">
            <!-- TABLE END -->
            <div class="text-center">
              <button type="submit" name="editbill" onclick="return setIndexes()" class="btn btn-primary btn-customized text-center">Generate Bill</button>
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
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = mm + '/' + dd + '/' + yyyy;
    document.getElementById("date").innerHTML = "Date: " + today
    document.getElementById("time").innerHTML = "Time: " + formatAMPM(new Date)

    function addRow() {
      var tableRef = document.getElementById('bill-table').getElementsByTagName('tbody')[0];
      $("#bill-table").find('tbody').append("<tr><td>" + (tableRef.rows.length + 1) + "</td><td><input class=\"itemids\" name=\"itemid[]\" onkeyup=\"searchDescription(this)\" type=\"text\"></td><td><input  onkeyup=\"searchId(this)\" name=\"description[]\" class=\"description\" type=\"text\"></td><td><input name=\"quantity[]\" onkeyup=\"updateAmount(this)\" type=\"number\"></td> <td><input type=\"hidden\" name=\"rate[]\" type=\"number\"><p class=\"text-center\"></p></td><td><input type=\"hidden\" name=\"amount[]\" type=\"number\"><p class=\"text-center\"></p></td></tr>");
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
        document.getElementById("transactionnumber").required = true
      } else {
        document.getElementById("transactionnumberdiv").style.visibility = "hidden"
        document.getElementById("transactionnumber").required = false
      }
    }

    function getTotalCartons() {
      var cartons = Number(document.getElementById("carton").value)
      var bundles = Number(document.getElementById("bundle").value)
      total = cartons + bundles
      document.getElementById("totalcartonbundle").value = String(cartons + bundles);
    }

    function showResult(str) {
      if (str.length == 0) {
        // document.getElementById("livesearch").innerHTML = "";
        // document.getElementById("livesearch").style.border = "0px";
        return;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("livesearch").innerHTML = this.responseText;
          document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
        }
      }
      xmlhttp.open("GET", "livesearch.php?q=" + str, true);
      xmlhttp.send();
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
    MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
    var data = [];
    var data2 = [];
    var itemid;
    var description;

    function searchDescription(element, value) {
      let descriptionIndex;
      for (var i = 0; i < data[0].length; i++) {
        if (value == undefined) {
          if (element.value == data[0][i]) {
            descriptionIndex = i;
            break;
          }
        } else {
          if (value == data[0][i]) {
            descriptionIndex = i;
            break;
          }
        }
      }
      if (descriptionIndex != undefined) {
        element.parentElement.nextElementSibling.childNodes[0].value = data[1][descriptionIndex];
        element.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.childNodes[0].value = data[3][descriptionIndex];
        console.log(element.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.childNodes);
        element.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.getElementsByClassName("text-center")[0].innerHTML = data[3][descriptionIndex];
      } else {
        element.parentElement.nextElementSibling.childNodes[0].value = "";
        element.parentElement.nextElementSibling.nextElementSibling.childNodes[0].value = "";
        element.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.childNodes[0].value = "";
        element.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.getElementsByClassName("text-center")[0].innerHTML = "";
        element.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.childNodes[0].value = "";
        element.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.getElementsByClassName("text-center")[0].innerHTML = "";
      }
    }

    function searchId(element, value) {
      let idIndex;
      for (var i = 0; i < data[0].length; i++) {
        if (value == undefined) {
          if (element.value == data[1][i]) {
            idIndex = i;
            break;
          }
        } else {
          if (value == data[1][i]) {
            idIndex = i;
            break;
          }
        }
      }
      if (idIndex != undefined) {
        element.parentElement.previousElementSibling.childNodes[0].value = data[0][idIndex];
        element.parentElement.nextElementSibling.nextElementSibling.childNodes[0].value = data[3][idIndex];
        element.parentElement.nextElementSibling.nextElementSibling.getElementsByClassName("text-center")[0].innerHTML = data[3][idIndex];
      } else {
        element.parentElement.previousElementSibling.childNodes[0].value = "";
        element.parentElement.nextElementSibling.childNodes[0].value = "";
        element.parentElement.nextElementSibling.nextElementSibling.childNodes[0].value = "";
        element.parentElement.nextElementSibling.nextElementSibling.getElementsByClassName("text-center")[0].innerHTML = "";
        element.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.childNodes[0].value = "";
        element.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.getElementsByClassName("text-center")[0].innerHTML = "";
      }
    }

    function updateAmount(element) {
      value = element.parentElement.previousElementSibling.previousElementSibling.childNodes[0].value;
      let idIndex;
      for (var i = 0; i < data[0].length; i++) {
        if (value == data[0][i]) {
          idIndex = i;
          break;
        }
      }
      allowed_quantity = data[2][idIndex];
      if (element.value > allowed_quantity) {
        element.value = allowed_quantity;
      } else {
        let rate = element.parentElement.nextElementSibling.childNodes[0].value;
        let amount = rate * element.value;
        if (amount != 0) {
          // console.log( element.parentElement.nextElementSibling.nextElementSibling.childNodes()[0].value=amount);
          element.parentElement.nextElementSibling.nextElementSibling.getElementsByClassName("text-center")[0].innerHTML = amount;
          element.parentElement.nextElementSibling.nextElementSibling.childNodes[0].value = amount
          calculateTotal();
        } else {
          element.parentElement.nextElementSibling.nextElementSibling.getElementsByClassName("text-center")[0].innerHTML = "";
          element.parentElement.nextElementSibling.nextElementSibling.childNodes[0].value = "";
          //Set Total To Zero
          calculateTotal()
        }
      }
    }

    function calculateTotal() {
      values = document.getElementsByName("amount[]");
      total = 0;
      for (var i = 0; i < values.length; i++) {
        total += Number(values[i].value);
      }
      document.getElementById("total").getElementsByTagName("p")[0].innerHTML = "Total: " + Number(total);
      document.getElementsByName("total")[0].value = total;
      document.getElementById("grandtotal").getElementsByTagName("p")[0].innerHTML = "Grand Total: " + (Number(total) + Number(document.getElementById("previousbalance").value));
      document.getElementsByName("grandtotal")[0].value = Number(total) + Number(document.getElementById("previousbalance").value);
    }

    function setPreviousBalance() {
      // document.getElementById("previousbalance").getElementsByTagName("p")[0].innerHTML = "Previous Balance: " + document.getElementsByName("remainingbalance")[0].value;
    }

    function setCustomer(index) {
      document.getElementById("previousbalance").value = data2[2][index];
      document.getElementsByClassName("previousbalance")[0].innerHTML = "Previous Balance: " + data2[2][index];
      document.getElementById("accountid").value = data2[1][index];
    }

    function setIndexes() {
      let indexes = [];
      var input = document.getElementsByName('itemid[]');
      let idIndex;
      for (var i = 0; i < input.length; i++) {
        for (var j = 0; j < data[0].length; j++) {
          if (input[i].value != undefined) {
            if (input[i].value == data[0][j]) {
              idIndex = j;
              indexes.push(idIndex);
              break;
            }
          }
        }
      }
      $('input:hidden[name=\'indexes[]\']').val(indexes);
      return true;
    }

    function func() {
      event.preventDefault();
      var itemid = $('#itemid1').val();
      var description = $('#description1').val();
      var quantity = $('#quantity1').val();
      var rate = $('#rate1').val();
      $.ajax({
        type: 'POST',
        url: 'controllers/formhandler.php',
        data: {
          addsingleitem: 'addsingleitem',
          itemid: itemid,
          description: description,
          quantity: quantity,
          rate: rate,
        },
        datatype: 'JSON',
        success: function(result) {
          $.ajax({
            type: 'get',
            url: 'controllers/search.php',
            dataType: 'json',
            cache: false,
            success: function(result) {
              data = result
              console.log("success")
            }
          });
        },
        error: function(error) {
          console.log(error)
        },
      });
      $('#exampleModal').modal('toggle');
      $('#confirmModal').modal('toggle');
    }
    $(document).ready(function() {
      $.ajax({
        type: 'post',
        url: 'controllers/search.php',
        data: {
          getcustomers: 'getcustomers',
        },
        dataType: 'json',
        cache: false,
        success: function(result) {
          console.log(result[0]);
          data2 = result;
          $(".searchbox").autocomplete({
            source: data2[0],
            html: true,
            response: function(event, ui) {
              // ui.content is the array that's about to be sent to the response callback.
              if (ui.content.length === 0) {
                var noResult = {
                  value: "",
                  label: "User Not Found"
                };
                ui.content.push(noResult);
              } else {
                $("#empty-message").empty();
              }
            },
            select: function(value, data) {
              setCustomer($.inArray(data.item.value, data2[0]));
              // alert($.inArray(data.item.value, data2[0]));
            }
          });
        },
      });
      $.ajax({
        type: 'get',
        url: 'controllers/search.php',
        dataType: 'json',
        cache: false,
        success: function(result) {
          data = result;
          //MUTATION START
          var observer = new MutationObserver(function(mutations, observer) {
            // fired when a mutation occurs
            try {
              $(".itemids").autocomplete({
                source: data[0],
                html: true,
                response: function(event, ui) {
                  // ui.content is the array that's about to be sent to the response callback.
                  if (ui.content.length === 0) {
                    var noResult = {
                      value: "",
                      label: "<button type=\"button\" class=\"btn btn-light btn-sm\" data-toggle=\"modal\" data-target=\"#exampleModal\" >Item not found, click to add</button>"
                    };
                    ui.content.push(noResult);
                  } else {
                    $("#empty-message").empty();
                  }
                },
                select: function(value, data) {
                  // console.log(value.target,data.item.value);
                  searchDescription(value.target, data.item.value);
                }
              });
              $(".description").autocomplete({
                source: data[1],
                html: true,
                response: function(event, ui) {
                  // ui.content is the array that's about to be sent to the response callback.
                  if (ui.content.length === 0) {
                    var noResult = {
                      value: "",
                      label: "<button type=\"button\" class=\"btn btn-light btn-sm\" data-toggle=\"modal\" data-target=\"#exampleModal\" >Item not found, click to add</button>"
                    };
                    ui.content.push(noResult);
                  } else {
                    $("#empty-message").empty();
                  }
                },
                select: function(value, data) {
                  searchId(value.target, data.item.value);
                }
              });
            } catch (error) {
              console.log(error);
            }
            // ...
          });
          observer.observe(document, {
            // attributes: true,
            childList: true,
            // characterData: true,
            subtree: true
            //...
          });
          //MUTATION END
          $(".itemids").autocomplete({
            source: data[0],
            html: true,
            response: function(event, ui) {
              // ui.content is the array that's about to be sent to the response callback.
              if (ui.content.length === 0) {
                var noResult = {
                  value: "",
                  label: "<button type=\"button\" class=\"btn btn-light btn-sm\" data-toggle=\"modal\" data-target=\"#exampleModal\" >Item not found, click to add</button>"
                };
                ui.content.push(noResult);
              } else {
                $("#empty-message").empty();
              }
            },
            select: function(value, data) {
              searchDescription(value.target, data.item.value);
            }
          });
          $(".description").autocomplete({
            source: data[1],
            html: true,
            response: function(event, ui) {
              // ui.content is the array that's about to be sent to the response callback.
              if (ui.content.length === 0) {
                var noResult = {
                  value: "",
                  label: "<button type=\"button\" class=\"btn btn-light btn-sm\" data-toggle=\"modal\" data-target=\"#exampleModal\" >Item not found, click to add</button>"
                };
                ui.content.push(noResult);
              } else {
                $("#empty-message").empty();
              }
            },
            select: function(value, data) {
              searchId(value.target, data.item.value);
            }
          });
        },
      });
    });
  </script>
  </body>