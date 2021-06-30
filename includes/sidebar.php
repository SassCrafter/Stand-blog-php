<div class="sidebar">
              <div class="row">
                <div class="col-lg-12">
                  <div class="sidebar-item search">
                    <form id="search_form" name="gs" method="GET" action="#">
                      <input type="text" name="q" class="searchText" placeholder="type to search..." autocomplete="on">
                    </form>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="sidebar-item recent-posts">
                    <div class="sidebar-heading">
                      <h2>Recent Posts</h2>
                    </div>
                    <div class="content">
                      <ul>
<?php
// Recent posts
  $recent_posts = select_recent_posts();
  while($row = mysqli_fetch_assoc($recent_posts)) {
    $recent_post_id = $row['post_id'];
    $recent_post_title = $row['post_title'];
    $recent_post_date = remove_time_from_date($row['post_date']);
?>
                        <li><a href="post.php?post_id=<?php echo $recent_post_id; ?>">
                          <h5><?php echo $recent_post_title; ?></h5>
                          <span><?php echo $recent_post_date; ?></span>
                        </a></li>
<?php } ?>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="sidebar-item categories">
                    <div class="sidebar-heading">
                      <h2>Categories</h2>
                    </div>
                    <div class="content">
                      <ul>
<?php
  $categories = get_all_categories(7);

  while ($row = mysqli_fetch_assoc($categories)) {
    $cat_id = $row['cat_id'];
    $cat_title = ucfirst($row['cat_title']);
    echo "<li><a href='./view_by_category.php?cat_id=$cat_id'>- $cat_title</a></li>";
  }
?>
                      </ul>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>