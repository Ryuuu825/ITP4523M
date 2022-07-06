<?php
	require_once('conn.php');
	$conn = get_db_connection();

	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		// Staff ID
		// Staff Name
		// Orders
		// Total Amount
		$month = $_GET['month'];
		$sql = "SELECT staff.staffID, staffName, 
		COUNT(orderID) AS 'noOfOrders', SUM(orderAmount) 
		AS 'totalAmount' FROM staff, orders
		WHERE orders.staffID = staff.staffID 
		AND dateTime LIKE '{$month}-%' GROUP BY staffID";
		$result = mysqli_query($conn, $sql);
		$rec = array();
		if (mysqli_num_rows($result) == 0) {
			echo "Items not found";
		} else {
			while ($row = mysqli_fetch_assoc($result)) {
				$rec[] = $row;
			}
			echo json_encode($rec);
		};
	}
