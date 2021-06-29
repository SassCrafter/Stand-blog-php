<?php

function redirect($location) {
	header("Location: $location");
}


function confirm_query($result) {
	global $conn;
	if (!$result) {
		die('Query failed.'.mysqli_error($conn));
	}
}

function remove_time_from_date($date) {
	$new_date = NULL;

	return date_format(date_create($date), 'Y-m-d');
	
}


// Menu

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


// Banner

function select_banner_posts() {
	global $conn;
	$query = "SELECT * FROM posts LEFT JOIN banner ON banner.banner_post_id = posts.post_id LEFT JOIN categories ON categories.cat_id = posts.post_cat_id AND posts.post_status = 'published'";
	$rst = mysqli_query($conn, $query);

	confirm_query($rst);

	return $rst;
}

// CTA

function select_cta($page) {
	global $conn;
	$query = "SELECT * FROM cta WHERE cta_page = '$page'";
	$rst = mysqli_query($conn, $query);

	confirm_query($rst);

	return $rst;
}

function display_cta($title, $small, $url, $btn_text) {
	echo "
		<section class='call-to-action'>
	      <div class='container'>
	        <div class='row'>
	          <div class='col-lg-12'>
	            <div class='main-content'>
	              <div class='row'>
	                <div class='col-lg-8'>
	                  <span>$small</span>
	                  <h4>$title</h4>
	                  
	                </div>
	                <div class='col-lg-4'>
	                  <div class='main-button'>
	                    <a href='$url'>$btn_text</a>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </section>
	";
}


// Posts

function select_recent_posts($quantity = 3) {
	global $conn;
	$query = "SELECT * FROM posts ORDER BY post_date DESC LIMIT $quantity";
	$rst = mysqli_query($conn, $query);

	confirm_query($rst);

	return $rst;
}

