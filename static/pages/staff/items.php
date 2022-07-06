<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../css/bootstrap.css">
  <link rel="stylesheet" href="../../css/style.css">
  <script src="../../js/w3.js"></script>
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>

<body onload="w3.includeHTML();">
  <div w3-include-html="../header.html"></div>

  <div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
      <span class="text-primary h1">Goods</span>
      <button class="btn btn-primary text-white fs-6">
        Add Item
      </button>
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

            <div class="modal fade" id="data<?php echo $itemID ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                      Goods Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="fs-5">Goods Name :</div>
                    <?php echo $itemName ?>
                  </div>
                  <div class="modal-body">
                    <div class="fs-5">Description :</div>
                    <?php echo $itemDescription ?>
                  </div>
                  <div class="modal-body">
                    <div class="fs-5">Stock :</div>
                    <?php echo $stockQuantity ?>
                  </div>
                  <div class="modal-body">
                    <div class="fs-5">Price :</div>
                    <?php echo $price ?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <?php
        if (isset($_GET['itemID'])) {
          $sql = "SELECT * FROM item WHERE itemID='{$_GET['itemID']}'";
          $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
          $item = mysqli_fetch_assoc($result);
          var_dump($item);
          extract($item);
        }
        echo <<<EOD
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                $itemName
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="fs-5">Description :</div>
              $itemDescription
            </div>
            <div class="modal-body">
              <div class="fs-5">Stock :</div>
              $stockQuantity
            </div>
            <div class="modal-body">
              <div class="fs-5">Price :</div>
              $price
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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