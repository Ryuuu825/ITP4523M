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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
        let onEdit = false;

        function editItem() {
            // get all textarea and input
            // remove attribute disabled
            if (!onEdit) {
                editableForm();
            } else {
                alert("Saved");
                resetForm();
            }
        }

        function editableForm() {
            $("textarea").removeAttr("disabled");
            $("input").removeAttr("disabled");
            onEdit = true;
            $("#edit").html("Save");
        }

        function resetForm() {
            onEdit = false;
            $("textarea").attr("disabled", true);
            $("input").attr("disabled", true);
            $("#edit").html("Edit");
        }

        $(document).ready(function() {
            $('#closeBtn').click(function() {
                resetForm();
            });
        });
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
                            <a class="nav-link text-black" href="../account.php">
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
            <a href="./additems.php">
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
                        extract($row);
                    ?>
                        <tr>
                            <th scope="row"><?php echo $itemID ?></th>
                            <td><?php echo $itemName ?></td>
                            <td><?php echo $stockQuantity ?></td>
                            <td><?php echo $price ?></td>
                            <td><a href="#" data-id="itemID" class="link-info" data-bs-toggle="modal" data-bs-target="#data<?php echo $itemID ?>">details</a></td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="data<?php echo $itemID ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="item_detail_label">
                                            Goods Detail
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="fs-5">Goods Name :</div>
                                        <textarea class="form-control" disabled><?php echo $itemName ?></textarea>
                                    </div>
                                    <div class="modal-body">
                                        <div class="fs-5">Description :</div>
                                        <textarea class="form-control" disabled><?php echo $itemDescription ?></textarea>
                                    </div>
                                    <div class="modal-body">
                                        <div class="fs-5">Stock :</div>
                                        <input type="number" class="form-control" value="<?php echo $stockQuantity ?>" disabled />
                                    </div>
                                    <div class="modal-body">
                                        <div class="fs-5">Price :</div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" disabled value="<?php echo $price ?>" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" onclick="editItem(<?php echo $itemID ?>)" id="edit">
                                            Edit
                                        </button>
                                        <button type="button" id="closeBtn" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    mysqli_free_result($result);
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->



    <div w3-include-html="../footer.html"></div>
</body>

</html>