<?php

function redirect($location) {
	header("Location: $location");
}


function confirm_query($result) {
	global $conn;
	if (!$result) {
		exit('Query failed.'.mysqli_error($conn));
	}
}

function select_menu_items() {
	global $conn;
	$query = "SELECT * FROM menu";
	$result = mysqli_query($conn, $query);

	confirm_query($result);
	return $result;
}

function get_page_name() {
	return basename($_SERVER['PHP_SELF']);
}