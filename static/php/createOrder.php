<?php
	include_once("conn.php");
	include_once("helper.php");
	check_is_login();
	$conn = get_db_connection();
	if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['orderItems'])){
		
	}
?>