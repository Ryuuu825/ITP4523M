<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Items</title>
    <link rel="stylesheet" href="../../css/bootstrap.css" />
    <link rel="stylesheet" href="../../css/style.css" />
    <script src="../../js/w3.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
        function editItem() {
            let onEdit = false;
            let onSave = false;

            var textarea = document.getElementsByTagName("textarea");
            var input = document.getElementsByTagName("input");
            // get all textarea and input
            // remove attribute disabled
            if (!onEdit) {
                for (var i = 0; i < textarea.length; i++) {
                    textarea[i].removeAttribute("disabled");
                }
                for (var i = 0; i < input.length; i++) {
                    input[i].removeAttribute("disabled");
                }

                onEdit = true;
                document.getElementById("edit").innerHTML = "Save";
            } else {
                onSave = true;
            }

            if (onSave) {
                alert("Saved");
                onSave = false;
                onEdit = false;

                for (var i = 0; i < textarea.length; i++) {
                    textarea[i].setAttribute("disabled", "disabled");
                }
                for (var i = 0; i < input.length; i++) {
                    input[i].setAttribute("disabled", "disabled");
                }
                document.getElementById("edit").innerHTML = "Edit";
            }
        }
    </script>
</head>

<body onload="w3.includeHTML();">
    <div class="w-100">
        <nav class="navbar navbar-expand-lg py-4" style="background-color: #e4e4e4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../../assert/main.png" alt="" width="30" height="24" class="d-inline-block align-text-top" />
                    The Better Limited
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active text-black" aria-current="page" href="#">
                                Items
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="../placeorder.php.html">
                                Place Order
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="../account.php.html">
                                Accounts
                            </a>
                        </li>
                        <li class="nav-item text-black">
                            <a class="nav-link text-black" href="../order.php.html">
                                Orders
                            </a>
                        </li>
                    </ul>
                    <span>
                        <a href="../../index.html" class="nav-link">
                            <span class="text-black fs-5 mx-3">Staff - Ken</span>
                            <span class="text-black">Logout</span>
                        </a>
                    </span>
                </div>
            </div>
        </nav>
    </div>

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <span class="text-primary h1">Goods</span>
            <a href="./additems.php.html">
                <button class="btn btn-primary text-white fs-6 py-3">
                    Add Item
                </button>
            </a>
        </div>

        <div class="border p-3 rounded border-primary">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Price</th>
                        <th scope="col">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once('../../php/conn.php');
                    $conn = get_db_connection();
                    $sql = "SELECT * FROM item";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo <<<EOD
                        <tr>
                          <th scope="row">{$row['itemID']}</th>
                          <td>{$row['itemName']}</td>
                          <td>{$row['stockQuantity']}</td>
                          <td>{$row['price']}</td>
                          <td><a href="" class="link-info" data-bs-toggle="modal" data-bs-target="#data{$row['itemID']}">details</a></td>
                        </tr>
                        EOD;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="data<?php echo $row['itemID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <?php
                    $sql = "SELECT * FROM item WHERE itemID='<?php echo $itemID?>'";
                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    $rc = mysqli_fetch_assoc($result);
                    extract($rc);
                echo <<<EOD
                    <div class="modal-header">
                        <h5 class="modal-title" id="item_detail_label">
                            Goods Detail
                            {$itemName}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="fs-5">Description :</div>
                        <textarea class="form-control" disabled>{$itemDescription}</textarea>
                    </div>
                    <div class="modal-body">
                        <div class="fs-5">Stock :</div>
                        <input type="number" class="form-control" value="{$stockQuantity}" disabled />
                    </div>
                    <div class="modal-body">
                        <div class="fs-5">Price :</div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" disabled value="{$price}" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="editItem({$itemID})" id="edit">
                            Edit
                        </button>
                        <!-- <button type="button" class="btn btn-secondary" onclick="editItem(<?php echo id ?>)">Edit</button> -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                EOD;
                mysqli_free_result($result);
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>

    <div w3-include-html="../footer.html"></div>
</body>

</html>