<?php
include_once("conn.php");
include_once("helper.php");
check_is_login();
$conn = get_db_connection();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	extract($_POST);
	//create customer or update customer
	$sql = "SELECT * FROM customer WHERE customerEmail = '{$customerEmail}' ";
	$result = mysqli_query($conn, $sql);
	$rc = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) == 0) {
		$sql = "INSERT INTO customer VALUES ('{$customerEmail}', '{$customerName}', '{$phoneNumber}')";
		$result = mysqli_query($conn, $sql);
	} else if ($rc['customerName'] != $customerName || $rc['phoneNumber'] != $phoneNumber) {
		$sql = "UPDATE customer 
						SET customerName = '{$customerName}',phoneNumber = '{$phoneNumber}' 
						WHERE customerEmail = '{$customerEmail}'";
		$result = mysqli_query($conn, $sql);
	}

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
	if (isset($_POST['deliveryAddress']) && isset($_POST['deliveryDate'])) {
		$sql = "INSERT INTO orders VALUES ('{$nextid}', '{$customerEmail}', '{$_SESSION['username']}', default, '{$deliveryAddress}', '{$deliveryDate}', '{$orderAmount}')";
	} else {
		$sql = "INSERT INTO orders VALUES ('{$nextid}', '{$customerEmail}', '{$_SESSION['username']}', default, default, default, '{$orderAmount}')";
	}
	$result = mysqli_query($conn, $sql);

	//create order items
	$ois = json_decode($orderItems, true);
	foreach ($ois as $item) {
		$sql = "INSERT INTO itemorders VALUES ('{$nextid}', '{$item['oiID']}', '{$item['qty']}', '{$item['soldPrice']}')";
		$result = mysqli_query($conn, $sql);
	}
	if ($result) {
		header("Location: ../pages/order_detail.php?id={$nextid}");
	} else {
		echo "Error";
	};
}
