<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'stand_blog';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!isset($conn)) {
	die("Could not connect to the database");
}