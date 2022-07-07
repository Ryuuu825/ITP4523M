<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../js/w3.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <style>
        .list-group-item {
            padding:30px;
        }
        .placeorder {
            position:absolute;
            top:90%;
            height:100px;
        }

        .pointer {
            cursor: pointer;
        }

        .itemid {
            display:none;
        }
    </style>
    <script>
        $(document).ready(function() {
            let id = window.location.search.split("?itemID=")[1];
            getByID(id);
        });
    </script>
    <?php
        if(isset($_GET['orderID'])) {
            $itemid = $_GET['itemid'];
        }
    ?>
</head>
<body onload="w3.includeHTML();">
    <div w3-include-html="header.html"></div>
    <div class="m-5 py-3 border-bottom">
        <span class="h2">Order Created</span>
        
        <span class="h2 float-end mx-3">
            $1000
        </span>
        <span class="h2 float-end mx-3">
            Total: 
        </span>
    </div>

    <div class="w-75 mx-auto">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h3 class="accordion-header" id="header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapse">
                        <h3>Sales Order Items</h3>
                    </button>
                </h3>
                <div id="collapse" class="accordion-collapse collapse show" aria-labelledby="header">
                  <div class="accordion-body">
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Qty</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td>NOVEL NF4091 9”All-way Strong Wind Circulation Fan</td>
                            <td>$500</td>
                            <td>1</td>
                          </tr>
                          <tr>
                            <th scope="row">2</th>
                            <td>CS-RZ24YKA 2.5 HP "Inverter" Split Type Heat Pump Air-Conditioner</td>
                            <td>$20000</td>
                            <td>2</td>
                          </tr>
                          <tr>
                            <th scope="row">3</th>
                            <td>QN100B Neo QLED 2K LED LCD TV</td>
                            <td>$13000</td>
                            <td>3</td>
                          </tr>
                          <tr>
                            <th scope="row">4</th>
                            <td>M33 5G Smartphone</td>
                            <td>$2000</td>
                            <td>4</td>
                          </tr>
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
        </div>

        <div class="sub-form border rounded mt-5">
                <!-- 
                    1.	Order ID
                    2.	Customer’s Email
                    3.	Customer’s Name
                    4.	Customer’s Phone Number
                    5.	Staff ID
                    6.	Staff Name
                    7.	Order Date & Time
                    8.	Delivery Address
                    9.	Delivery Date
                    10.	Item ID
                    11.	Item Name
                    12.	Order Quantity
                    13.	Total Amount
                 -->

                <div class="order-form m-4">
                    <div class="mb-3">
                        <label class="form-label">Order ID</label>
                        <input readonly disabled type="text" class="form-control" value="order132">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Customer Email</label>
                        <input disabled readonly type="text" class="form-control" value="example@domain.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input disabled readonly type="text" class="form-control" value="Mr. Lee">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Customer Phone</label>
                        <input disabled readonly type="number" class="form-control" value="24368333">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Staff ID</label>
                        <input type="text" readonly class="form-control"  value="S0001" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Staff Name</label>
                        <input type="text" readonly class="form-control"  value="Ben Poon" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order Date</label>
                        <input type="text" readonly class="form-control" id="staticEmail" value="Mon Jun 13 2022 05:37:57 GMT+0000" disabled>
                    </div>
                    <div class="mb-3 delivery" id="delivery-picker">
                        <label for="delivery-date" class="form-label">Delivery Date</label>
                        <input readonly disabled type="date" class="form-control" value="2022-06-04">
                    </div>
                    <div class="mb-3 delivery">
                        <label for="delivery-address" class="form-label" >Delivery Address</label>
                        <input readonly disabled type="text" class="form-control" value="120 Tsing Yi Road, · Tsing Yi Island, New Territories">
                    </div>
                </div>
            </div>
            <div>
                <a href="./placeorder.php">
                    <button class="btn btn-primary text-white mx-auto text-center float-end mt-5 " style="margin-bottom:80px;">
                        OK
                    </button>
                </a>
            </div>
    </div>
    <div w3-include-html="footer.html"></div>
</body>
</html>