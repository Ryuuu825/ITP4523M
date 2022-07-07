<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../../js/w3.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        <?php
        session_start();
        if (empty($_SESSION["username"])) {
            header("Location: ../401.html");
            exit;
        }
        ?>
        //add itme to database
        function addItem() {
            var itemName = $("#name").val();
            var itemDescription = $("#desc").val();
            var stockQuantity = $("#qty").val();
            var price = $("#price").val();
            if (itemName == "" || stockQuantity == "" || price == "") {
                alert("Please fill out the form correctly.");
                return;
            }
            $.ajax({
                type: "POST",
                url: "../../php/itemController.php",
                data: {
                    itemName: itemName,
                    itemDescription: itemDescription,
                    stockQuantity: stockQuantity,
                    price: price
                },
                success: function(data) {
                    if (data == "Error") {
                        alert("Add item failed.");
                    } else {
                        alert("Add item successfully.");
                        window.location.href = "additem-result.html?itemID=" + data;
                    }
                }
            });
        }
    </script>
</head>

<body onload="w3.includeHTML();">

    <div class="w-100 mb-5">
        <nav class="navbar navbar-expand-lg py-4" style="background-color:#e4e4e4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../../assert/main.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
                    The Better Limited
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav  me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active text-black" aria-current="page" href="#">
                                Items
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="../placeorder.php">
                                Place Order
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="../account.php">
                                Accounts
                            </a>
                        </li>
                        <li class="nav-item text-black">
                            <a class="nav-link text-black">
                                Orders
                            </a>
                        </li>

                    </ul>
                    <span>
                        <span class="text-black fs-5 mx-3">Staff - Ken</span>
                        <a href="../../login.php" class="nav-link d-inline">
                            <span class="text-black">Logout</span>
                        </a>
                    </span>
                </div>
            </div>
        </nav>
    </div>
    <div class="d-flex text-center justify-content-center align-content-center flex-column" style="height:80vh;">
        <div class="mt-5">
            <h1 class="text-center">Add Items</h1>
        </div>
        <div class="mx-auto mt-5 border rounded p-3 border-3" style="width:40%">
            <div class="form-group mb-3">
                <label for="itemname" class="mb-2">Item Name*</label>
                <textarea type="text" class="form-control" id="name" name="itemName" style="resize:none" rows="2" required placeholder="Item Name"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="desc" class="mb-2">Item Description</label>
                <textarea class="form-control" placeholder="Description of the product ... " id="desc" name="itemDescription" style="resize:none" rows="5"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="qty" class="mb-2">Stock Quantity*</label>
                <input type="number" class="form-control" id="qty" name="stockQuantity" required placeholder="Item Price">
            </div>
            <div class="form-group">
                <label for="itemprice" class="mb-2 block">Price*</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="price" name="price" placeholder="price" required id="itemprice">
                </div>
            </div>
            <div>
                <button onclick="addItem();" class="btn btn-primary text-white">Add Item</button>
            </div>
        </div>
    </div>

    <div w3-include-html="../footer.html" style="margin-top:200px"></div>
</body>

</html>