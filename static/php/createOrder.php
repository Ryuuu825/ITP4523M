<?php
	include_once("conn.php");
	include_once("helper.php");
	check_is_login();
	$conn = get_db_connection();
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		extract($_POST);
		//create order
		$sql = "SELECT max(orderId)+1 AS 'nextid' FROM orders;";
    $result = mysqli_query($conn, $sql)
        or die('<div class="error">SQL command fails :<br>' . mysqli_error($conn)) . "</div>";
    $num = mysqli_num_rows($result);
    if ($num == 0) {
        $sql = "SELECT IFNULL(max(orderId), 0)+1 AS `nextid` FROM orders;";
        $result = mysqli_query($conn, $sql)
            or die('<div class="error">SQL command fails :<br>' . mysqli_error($conn)) . "</div>";
    }
    $rc = mysqli_fetch_assoc($result);
    $nextid = $rc['nextid'];
		if(strlen($deliveryAddress)>0){
			$sql = "INSERT INTO orders VALUES ('{$nextid}', '{$customerEmail}', '{$_SESSION['username']}', default, '{$deliveryAddress}', '{$deliveryDate}', '{$orderAmount}')";
		}else {
			$sql = "INSERT INTO orders VALUES ('{$nextid}', '{$customerEmail}', '{$_SESSION['username']}', default, default, default, '{$orderAmount}')";
		}
		$result = mysqli_query($conn, $sql);
		
		foreach($orderItems as $item){
			$sql = "INSERT INTO itemorders VALUES ('{$nextid}', '{$item['itemId']}', '{$item['itemQuantity']}')";
			$result = mysqli_query($conn, $sql);
		}
		if ($result) {
			echo $nextid;
		} else {
			echo "Error";
		};
	}
?>