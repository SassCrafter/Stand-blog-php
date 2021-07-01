<?php

function escape($str) {
	global $conn;
	return mysqli_real_escape_string($conn, trim($str));
}

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

function string_has_query($str) {
	return strpos($str, '?') !== false;
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

function select_post_by_id($id) {
	global $conn;
	$query = 'SELECT * FROM posts LEFT JOIN categories ON categories.cat_id = posts.post_cat_id WHERE post_id = ?';
	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt, 'i', $id);
	mysqli_stmt_execute($stmt);

	confirm_query($stmt);
	$rst = mysqli_stmt_get_result($stmt);
	return $rst;
}

// Search posts
function search_posts($search_query, $limit = NULL) {
	global $conn;
	$query = "SELECT * FROM posts LEFT JOIN categories ON categories.cat_id = posts.post_cat_id WHERE posts.post_status = 'published' AND post_tags LIKE ? OR post_title LIKE ? OR post_author LIKE ? ORDER BY posts.post_date DESC";
	if (isset($limit)) {
		$query .= $limit;
	}

	$stmt = mysqli_prepare($conn, $query);
	$search = "%$search_query%";
	mysqli_stmt_bind_param($stmt, 'sss', $search, $search, $search);

	mysqli_stmt_execute($stmt);

	$rst = mysqli_stmt_get_result($stmt);

	confirm_query($rst);
	return $rst;
}

function display_post($post_id, $post_title, $post_category, $post_author, $post_content, $post_date, $post_image, $post_comments_count, $post_tags) {
	$tags = explode(',', $post_tags);
	$str =  " 
		<div class='col-lg-12'>
          <div class='blog-post'>
            <div class='blog-thumb'>
              <img src='assets/images/$post_image' alt=''>
            </div>
            <div class='down-content'>
              <span>$post_category</span>
              <a href='post.php?post_id=$post_id'><h4>$post_title</h4></a>
              <ul class='post-info'>
                <li><a href='./search.php?q=$post_author'>$post_author</a></li>
                <li><a href='./search.php?date=$post_date'>$post_date</a></li>
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
			<li><a href='./search.php?q=$tag'>$tag</a></li>
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

//  Pagination start
function display_pagination($pages_num, $current_page, $url) {
	if ($pages_num > 1) {
		for ($i = 1; $i <= $pages_num; $i++) {
	    $class_name = '';
	    if ($current_page == $i) {
	      $class_name = 'active';
	    }
	    $page_url = string_has_query($url) ? "$url&page=$i" : "$url?page=$i";
	    echo "<li class='$class_name'><a href='$page_url'>$i</a></li>";
	  }
	}
}
function select_posts_pagination($offset = 0, $quantity = 3, $select_query = NULL) {
	global $conn;
	if (!isset($select_query)) {
		$query = "SELECT * FROM posts LEFT JOIN categories ON categories.cat_id = posts.post_cat_id WHERE posts.post_status = 'published' ORDER BY posts.post_date DESC LIMIT $offset, $quantity";
	} else {
		$query = $select_query . "LIMIT $offset, $quantity";
	}
	$rst = mysqli_query($conn, $query);

	confirm_query($rst);
	return $rst;

}

function get_page_offset($page_num, $quantity_per_page) {
	return ($page_num - 1) * $quantity_per_page;
}

function get_page_num() {
	if (isset($_GET['page'])) {
		return $_GET['page'];
	} else {
		return 1;
	}
}

function get_total_posts_num($search_query = NULL) {
	global $conn;
	if (!isset($search_query)) {
		$query = 'SELECT COUNT(*) FROM posts WHERE post_status = \'published\'';
	} else {
		$query = $search_query;
	}
	$rst = mysqli_query($conn, $query);

	confirm_query($rst);
	return mysqli_fetch_array($rst)[0];
}

function get_total_num_of_pages($quantity, $quantity_per_page) {
	return ceil($quantity / $quantity_per_page);
}


function select_all_posts_pagination() {
	$total_posts_num = get_total_posts_num();
	$current_page = get_page_num();
	$pages_num = get_total_num_of_pages($total_posts_num, 3);
	$offset = get_page_offset($current_page, 3);
	$posts = select_posts_pagination($offset, 3);
	return ['posts' => $posts, 'pages' => $pages_num, 'current_page' => $current_page];
}

function search_posts_pagination($query) {
	$current_page = get_page_num();
	$offset = get_page_offset($current_page, 3);
	$posts = search_posts($query, " LIMIT $offset, 3");
	$total_posts_num = mysqli_num_rows(search_posts($query));
	$pages_num = get_total_num_of_pages($total_posts_num, 3);

	return ['posts' => $posts, 'pages' => $pages_num, 'current_page' => $current_page];
}

// Pagination end




//  SM

function get_all_sm_links() {
	global $conn;
	$query = 'SELECT * FROM sm';
	$rst = mysqli_query($conn, $query);

	confirm_query($rst);
	return $rst;
}
