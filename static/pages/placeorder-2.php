<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
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
        function showDeliveryPickerForm()
        {
            var deliveryPicker = document.getElementsByClassName("delivery")
            for(var i = 0; i < deliveryPicker.length; i++)
            {
                if (deliveryPicker[i].style.display == "none")
                {
                    deliveryPicker[i].style.display = "block";
                }
                else
                {
                    deliveryPicker[i].style.display = "none";
                }
            }
        }
    </script>
</head>
<body onload="w3.includeHTML();">
    <div w3-include-html="header.html"></div>
    <div class="m-5 py-3 border-bottom">
        <span class="h2">Place Order</span>
        <a href="./placeorder-3.php.html">
            <button class="btn btn-primary float-end">
                <span class="text-white">Place</span>
            </button>
        </a>
        
        <span class="h2 float-end mx-3">
            $1000
        </span>
        <span class="h2 float-end mx-3">
            Total: 
        </span>
    </div>
    <a href="./placeorder.php.html">
        <button class="btn btn-secondary mx-5">
            Back
        </button>
    </a>

    <div class="w-75 mx-auto">
        <div class="accordion">
            <div class="accordion-item">
                <h3 class="accordion-header" id="panels-h1">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panels-close" aria-expanded="true" aria-controls="panels-close">
                    <h3>Sales Order Items</h3>
                    </button>
                </h3>
                <div id="panels-close" class="accordion-collapse collapse show" aria-labelledby="panels-h1">
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
            <form class="mx-4 my-5" action="./placeorder-3.php" method="POST">
                <!-- 
                    2.	Customer’s Email
                    3.	Staff ID
                    4.	Order Date & Time
                    5.	Delivery Address (optional)
                    6.	Delivery Date (optional)
                 -->

                <div class="mb-3">
                    <label for="email" class="form-label">Customer Email</label>
                    <input type="email" class="form-control" id="email" placeholder="example@domain.com" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="staticEmail" class="form-label">Staff ID</label>
                    <input type="text" readonly class="form-control" id="staticEmail" value="S0001" disabled name="staff_id">
                </div>
                <div class="mb-3">
                    <label class="form-label">Order Date</label>
                    <input type="text" readonly class="form-control" value="Mon Jun 13 2022 05:37:57 GMT+0000" disabled name="order_date">
                </div>
                <!-- checkbox -->
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="checkbox_delivery" onchange="showDeliveryPickerForm()">
                    <label class="custom-control-label" for="checkbox_delivery">need Delivery?</label>
                </div>

                <div class="mb-3 delivery" id="delivery-picker" style="display: none;">
                    <label for="delivery_date" class="form-label">Delivery Date</label>
                    <input type="date" class="form-control" id="delivery_date" name="delivery_date">
                </div>
                <div class="mb-3 delivery" style="display: none;">
                    <label for="delivery_address" class="form-label" >Delivery Address</label>
                    <input type="text" class="form-control" id="delivery_address" placeholder="1234 Main St" name="address">
                </div>
                
                <button type="submit" class="btn btn-primary text-white">Submit</button>
              </form>
        </div>
    </div>
    <div w3-include-html="footer.html"></div>
</body>
</html>