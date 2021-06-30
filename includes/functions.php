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

// Categories

function get_all_categories($quantity = NULL) {
	global $conn;
	$query = "SELECT * FROM categories";
	if ($quantity != NULL) {
		$query .= " LIMIT $quantity";
	}
	$rst = mysqli_query($conn, $query);

	confirm_query($rst);
	return $rst;
}

// Tags

function get_all_tags() {
	global $conn;
	$query = 'SELECT DISTINCT post_tags from tags';
	$rst = mysqli_query($conn, $query);

	confirm_query($rst);
	return $rst;
}

// OWL Banner

function select_banner_posts() {
	global $conn;
	$query = "SELECT * FROM posts LEFT JOIN banner ON banner.banner_post_id = posts.post_id LEFT JOIN categories ON categories.cat_id = posts.post_cat_id AND posts.post_status = 'published'";
	$rst = mysqli_query($conn, $query);

	confirm_query($rst);

	return $rst;
}

// Banner

function display_banner($small, $title) {
	echo "
		<div class='heading-page header-text'>
	      <section class='page-heading'>
	        <div class='container'>
	          <div class='row'>
	            <div class='col-lg-12'>
	              <div class='text-content'>
	                <h4>$small</h4>
	                <h2>$title</h2>
	              </div>
	            </div>
	          </div>
	        </div>
	      </section>
	    </div>
	";
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
	// $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_date DESC LIMIT $quantity";
	$query = "SELECT * FROM posts LEFT JOIN categories ON categories.cat_id = posts.post_cat_id AND posts.post_status = 'published' ORDER BY post_date DESC LIMIT $quantity";
	$rst = mysqli_query($conn, $query);

	confirm_query($rst);

	return $rst;
}

function display_post($post_title, $post_category, $post_author, $post_content, $post_date, $post_image, $post_comments_count, $post_tags) {
	$tags = explode(',', $post_tags);
	$str =  " 
		<div class='col-lg-12'>
          <div class='blog-post'>
            <div class='blog-thumb'>
              <img src='assets/images/$post_image' alt=''>
            </div>
            <div class='down-content'>
              <span>$post_category</span>
              <a href='post-details.html'><h4>$post_title</h4></a>
              <ul class='post-info'>
                <li><a href='#'>$post_author</a></li>
                <li><a href='#'>$post_date</a></li>
                <li><a href='#'>$post_comments_count comments</a></li>
              </ul>
              <p>$post_content</p>
              <div class='post-options'>
                <div class='row'>
                  <div class='col-6'>
                    <ul class='post-tags'>
                      <li><i class='fa fa-tags'></i></li>
                      
                    
	";
	foreach($tags as $tag) {
		$str .= " 
			<li><a href='#'>$tag</a></li>
		";
	}
	$str .= " 
					</ul>
                  </div>
                  <div class='col-6'>
                    <ul class='post-share'>
                      <li><i class='fa fa-share-alt'></i></li>
                      <li><a href='#'>Facebook</a>,</li>
                      <li><a href='#'>Twitter</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
	";
	return $str;
}


//  SM

function get_all_sm_links() {
	global $conn;
	$query = 'SELECT * FROM sm';
	$rst = mysqli_query($conn, $query);

	confirm_query($rst);
	return $rst;
}
