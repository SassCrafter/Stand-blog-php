
<div class="main-banner header-text">
      <div class="container-fluid">
        <div class="owl-banner owl-carousel">
<?php
  $posts_result = select_banner_posts();
  while($row = mysqli_fetch_assoc($posts_result)) {
      $post_category = $row['cat_title'];
      $post_title = $row['post_title'];
      $post_author = $row['post_author'];
      $post_date = remove_time_from_date($row['post_date']);
      $post_comments_num = $row['post_comments_count'];
      $post_image = $row['post_image'];
?>
      <div class="item">
        <img src="assets/images/<?php echo $post_image; ?>" alt="<?php echo $post_title ?> image">
        <div class="item-content">
          <div class="main-content">
            <div class="meta-category">
              <span><?php echo $post_category; ?></span>
            </div>
            <a href="post-details.html"><h4><?php echo $post_title; ?></h4></a>
            <ul class="post-info">
              <li><a href="#"><?php echo $post_author; ?></a></li>
              <li><a href="#"><?php echo $post_date; ?></a></li>
              <li><a href="#"><?php echo $post_comments_num; ?> Comments</a></li>
            </ul>
          </div>
        </div>
      </div>
  
<?php } ?>
          
          
        </div>
      </div>
    </div>