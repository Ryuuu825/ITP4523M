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
            padding: 30px;
        }

        .placeorder {
            position: absolute;
            top: 90%;
            height: 100px;
        }

        .pointer {
            cursor: pointer;
        }

        .itemid {
            display: none;
        }
    </style>
    <script>
        function showDeliveryPickerForm() {
            var deliveryPicker = document.getElementsByClassName("delivery")
            for (var i = 0; i < deliveryPicker.length; i++) {
                if (deliveryPicker[i].style.display == "none") {
                    deliveryPicker[i].style.display = "block";
                } else {
                    deliveryPicker[i].style.display = "none";
                }
            }
        }

        function submitForm() {
            $("form").submit();
        }

        function createOrder() {
            $.ajax({
                type: "POST",
                url: "../php/CreateOrder.php",
                data: {
                    itemName: itemName,
                    itemDescription: itemDescription,
                    stockQuantity: stockQuantity,
                    price: price
                },
                success: function(data) {
                    if (data == "Error") {
                        alert("Create order failed.");
                    } else {
                        alert("Create order successfully.");
                        window.location.href = "order_detail.php?id=" + data;
                    }
                }
            });
        }
    </script>
    <?php
    include_once("../php/helper.php");
    check_is_login();
    ?>
</head>

<body onload="w3.includeHTML();">
    <?php include_once "./header.php"; ?>
    <div class="m-5 py-3 border-bottom">
        <span class="h2">Place Order</span>
        <button class="btn btn-primary float-end" onclick="submitForm();">
            <span class="text-white">Place</span>
        </button>

        <span class="h2 float-end mx-3">
            <?php
            if (!empty($_POST)) {
                extract($_POST);
                include_once("../php/conn.php");
                include_once("../php/CallDiscount.php");
                $conn = get_db_connection();
                $orderItems = array();
                $totalAmount = 0.0;
                foreach ($_POST as $oiID => $qty) {
                    $orderItems[] = array(
                        "oiID" => $oiID,
                        "qty" => $qty
                    );
                    $sql = "SELECT price*{$qty} AS `Amount` FROM item WHERE itemId = {$oiID}";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $totalAmount += (float)($row['Amount']);
                }
                $discount = getDiscount($totalAmount);
                $preDiscount = 1 - $discount;
                $totalAmount *= $preDiscount;
                echo "$" . $totalAmount;
            ?>
        </span>
        <span class="h2 float-end mx-3">
            Total:
        </span>
    </div>
    <a href="./placeorder.php">
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
                                    <th scope="col" style="text-align: center;">Price</th>
                                    <th scope="col" style="text-align: center;">Qty</th>
                                    <th scope="col" style="text-align: center;">Sold Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ois = array();
                            for ($i = 1; $i <= count($orderItems); $i++) {
                                $oiID = $orderItems[$i - 1]["oiID"];
                                $qty = $orderItems[$i - 1]["qty"];
                                $sql = "SELECT `itemName`,`price`, price*{$qty}*{$preDiscount} AS `soldPrice` FROM item WHERE itemId = {$oiID}";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $ois[] = array(
                                    "oiID" => $oiID,
                                    "qty" => $qty,
                                    "soldPrice" => $row["soldPrice"]
                                );
                                echo <<<EOD
                                    <tr>
                                    <th scope="row">{$i}</th>
                                    <td>{$row['itemName']}</td>
                                    <td style="text-align: center;">{$row['price']}</td>
                                    <td style="text-align: center;">{$qty}</td>
                                    <td style="text-align: center;">{$row['soldPrice']}</td>
                                    </tr>
                                EOD;
                            }
                        }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="sub-form border rounded mt-5" style="margin-bottom:100px;">
            <form class="mx-4 my-5" action="../php/CreateOrder.php" method="post">
                <!-- 
                    2.	Customer’s Email
                    3.	Staff ID
                    4.	Order Date & Time
                    5.	Delivery Address (optional)
                    6.	Delivery Date (optional)
                 -->
                <input type="hidden" name="orderItems" value='<?php echo json_encode($ois); ?>'>
                <input type="hidden" name="orderAmount" value='<?php echo $totalAmount; ?>'>
                <div class="mb-3">
                    <label for="cusName" class="form-label">Customer Name</label>
                    <input type="text" class="form-control" id="cusName" placeholder="e.g Chan Tai Man" name="customerName" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Customer Email</label>
                    <input type="email" class="form-control" id="email" placeholder="example@domain.com" name="customerEmail" required>
                </div>
                <div class="mb-3">
                    <label for="cusPhone" class="form-label">Customer Phone</label>
                    <input type="number" class="form-control" id="cusPhone" placeholder="e.g 12345678" name="phoneNumber">
                </div>
                <div class="mb-3">
                    <label for="staticEmail" class="form-label">Staff ID</label>
                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo $_SESSION['username']; ?>" disabled name="staff_id">
                </div>
                <!-- checkbox -->
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="checkbox_delivery" onchange="showDeliveryPickerForm()">
                    <label class="custom-control-label" for="checkbox_delivery">need Delivery?</label>
                </div>

                <div class="mb-3 delivery" id="delivery-picker" style="display: none;">
                    <label for="delivery_date" class="form-label">Delivery Date</label>
                    <input type="date" class="form-control" id="delivery_date" require name="delivery_date">
                </div>
                <div class="mb-3 delivery" style="display: none;">
                    <label for="delivery_address" class="form-label">Delivery Address</label>
                    <input type="text" class="form-control" id="delivery_address" require placeholder="1234 Main St" name="address">
                </div>
            </form>
        </div>
    </div>
    <div w3-include-html="footer.html"></div>
</body>

</html>