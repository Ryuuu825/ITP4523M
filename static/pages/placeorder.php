<?php 
    include_once("../php/helper.php");
    check_is_login();
?>
<?php 
    include_once("../php/conn.php");
    $conn = get_db_connection();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        <link rel="stylesheet" href="../css/bootstrap.css" />
        <link rel="stylesheet" href="../css/style.css" />
        <script src="../js/w3.js"></script>
        <!-- JavaScript Bundle with Popper -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"
        ></script>
        <!-- cdn of jquery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link rel="shortcut icon" href="../main.ico" type="image/x-icon">
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
            
            function check_enough_stock(id)
            {
                const stock = $(`input[name=${id}_stock]`).val();

                quantity = 1;

                if ($("#2_qty").text() != "")
                {
                    quantity = parseInt($(`#${id}_qty`).text()) + 1;
                }


                if(stock - quantity < 0)
                {
                    alert("Not enough stock");
                    return false;
                }
                else
                {
                    return true;
                }
            }
            function changeQty(id , qty)
            {
                if (!check_enough_stock(id)) return;

                real_qty = parseInt($("#" + id + "_qty").text()) + parseInt(qty);
                $("#" + id + "_qty").text(real_qty ); 
                $("#cart_form input[name=" + id + "]").val(real_qty);
            }

            cart = [];
            total = 0;
            total_price = 0;

            function addToCart(itemid , item_name , price ) {
                if (!check_enough_stock(itemid)) 
                    return;
                

                total_price+= parseInt(price);
                // get the discount from api
                $.ajax({
                    url:"http://127.0.0.1:8080/api/discountCalculator?discount="+(total_price),
                    type:"GET",
                    dataTpye : "json",
                    crossDomin: true,
                    success:function(data)
                    {
                        new_price = (total_price) * (1- data.discount);
                        new_price = Math.floor(new_price * 100) / 100;
                        
                        if (data.discount != 0)
                        {
                            // disable the new_price to be some many float
                            $("#price").html(new_price+`<span class='fs-6 mx-3'>discount: ${data.discount*100}%<span>`);
                        }
                        else 
                        {
                            $("#price").html(new_price);
                        }
                        $("#price_modal").text(new_price);
                    }
                 })
                

                // check if the item is already in the cart
                var isInCart = false;
                for (var i = 0; i < cart.length; i++) {
                    if (cart[i] == itemid) {
                        isInCart = true;
                        break;
                    }
                }
                if (isInCart)
                {
                    changeQty(itemid, 1);
                    return;
                }
                

                cart.push(itemid);

                var listGroup = document.getElementsByClassName("list-group");
                // add item to list-group
                var item = document.getElementById(itemid);
                var z = document.createElement("div"); // is a node
                z.innerHTML = `
                <li class="list-group-item">
                    <h5 class="card-title">${item_name}</h5>
                    <div class="itemid">1000</div>
                    <div class="float-end">
                        <svg onclick="changeQty(${itemid} , -1);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle mx-3 pointer text-primary" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> 
                            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                        </svg>
                        <p class="card-text d-inline qty"  id="${itemid}_qty">1</p>
                        <svg onclick="changeQty(${itemid} , 1);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle mx-3 pointer text-primary" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                    </div>
                </li>
            `;
                listGroup[0].appendChild(z);
                // add item to the form cart
                $("#form_data").append(`<input type='hidden' name='${itemid}'  value='${1}'>`)
            }

            function search()
            {
                $.ajax({
                    accepts: "application/json",
                    method: "GET",
                    dataType:"json",
                    url: "../php/itemController.php?name="+$("input[name=name]").val(),
                    success: (data) => {
                        if (data == "Items not found")
                        {
                            $("#items_list").html("")
                        }
                        console.log($("#item_list").html())
                        str = "";
                        console.log(data)
                        $("#items_list").html("")
                        
                        for(i = 0 ; i < data.length ; i++)
                        {
                            //  $item_name =  str_replace("\"", " ", $item_name);
                            name = data[i].itemName;
                            name = name.replace(/\"/g, " ");
                            str += `
                                <div class="card col-3 mx-2 my-2" style="width: 18rem">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                ${name}
                                            </h5>
                                            <input type="hidden" value="${data[i].stockQuantity}" name="${data[i].itemID}_stock">
                                            <a
                                                href="#"
                                                class="btn btn-primary text-white"
                                                onclick="addToCart('${data[i].itemID}' , '${name}' , '${data[i].price}')"
                                                >Add to cart</a
                                            >
                                        </div>
                                    </div>
                            `;
                        }
                        $("#items_list").html(str)
                    }
                });
            }

            function clearCart() {
                var cart_ = document.getElementById("cart");
                cart_.innerHTML = "";
                cart = [];
                $("#price").text("0");
            }

            function send_request()
            {
                // send a post request to the server
                // and forward to that pages

                // create a form
                var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", "../php/cartController.php");
                // add the cart to the form
                var cart_ = document.getElementById("cart");
                var cart_str = cart_.innerHTML;
                var cart_input = document.createElement("input");
                cart_input.setAttribute("type", "hidden");

                // send the form to the server
                form.send();                

            }
        </script>
    </head>
    <body onload="w3.includeHTML();">
        
        <?php include "header.php"; ?>
        <div class="m-5 py-3 border-bottom">
            <span class="h2">Place Order</span>
            <a href="#">
                <button
                    class="btn btn-primary float-end"
                    data-bs-toggle="modal"
                    data-bs-target="#confirm_modal"
                >
                    <span class="text-white">Next</span>
                </button>
            </a>

            <span class="h2 float-end mx-3"> $ <span id="price">0</span> </span>
            <span class="h2 float-end mx-3"> Total: </span>
        </div>
        <div class="row w-100" style="height: 75vh" style="position: relative">
            <div class="col-3 h-100 mx-5" style="margin-left: 25px;">
                <div
                    class="d-flex align-content-center justify-content-between mb-3"
                >
                    <h3>Shopping cart</h3>
                    <button class="btn btn-secondary" onclick="clearCart();">
                        <a
                            href="#"
                            class="text-white text-decoration-none"
                            >Clear</a
                        >
                    </button>
                </div>
                <div class="border border-1" style="height:90%">
                    <ul class="list-group w-100 " id="cart">
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="d-flex justify-content-between">
                    <h3>Items</h3>
                    <div class="d-flex" role="search">
                        <input
                            class="form-control me-2"
                            type="text"
                            placeholder="Search"
                            name="name"
                            aria-label="Search"
                            oninput="search()"
                        />
                    </div>
                </div>

                <div class="row mt-4" id="items_list">

                <?php 
                    $sql;

                    if (isset($_GET["search"])) {
                        $sql = "SELECT * FROM products WHERE name LIKE '%".$_GET["search"]."%'";
                    } else {
                        $sql = "SELECT * FROM `Item`";
                    }
                    $res = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($res))
                    {
                        if ($row["stockQuantity"] <= 0)
                        {
                            continue;
                        }
                        $item_name = $row['itemName'];
                        $item_name =  str_replace("\"", " ", $item_name);
                        echo <<<EOF
                            <div class="card col-3 mx-2 my-2" style="width: 18rem">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        {$row['itemName']}
                                    </h5>
                                    <input type="hidden" value="{$row['stockQuantity']}" name="{$row['itemID']}_stock">
                                    <a
                                        href="#"
                                        class="btn btn-primary text-white"
                                        onclick="addToCart('{$row['itemID']}' , '$item_name' , '{$row['price']}')"
                                        >Add to cart</a
                                    >
                                </div>
                            </div>
                        EOF;
                    }
                ?>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="confirm_modal"
            tabindex="-1"
            aria-labelledby="confirm_modal_label"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm_modal_label">
                            Do you sure?
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="fs-5">Total Price : $ <span id="price_modal">0</span> </div>
                    </div>
                    <div class="modal-footer">
                        <form action="./placeorder-2.php" method="POST" id="cart_form">
                            <div class="form-check" id="form_data">
                                <input type="submit" value="OK" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div w3-include-html="footer.html"></div>
    </body>
</html>
