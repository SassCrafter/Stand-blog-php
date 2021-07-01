<?php include_once './includes/header.php'?>

    

    <!-- Page Content -->

    <!-- Banner Starts Here -->
    <?php include_once './includes/owl_banner.php'; ?>


    <!-- CTA -->
    <?php
      $cta_rst = select_cta('home');
      $cta_data = mysqli_fetch_assoc($cta_rst);
      display_cta($cta_data['cta_title'], $cta_data['cta_small'], $cta_data['cta_btn_url'], $cta_data['cta_btn_text']);
    ?>


    <section class="blog-posts">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="all-blog-posts">
              <div class="row">
                
                <?php
                  $posts = select_recent_posts();
                  while ($row = mysqli_fetch_assoc($posts)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_content = $row['post_content'];
                    $post_date = remove_time_from_date($row['post_date']);
                    $post_comments_num = $row['post_comments_count'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_category = $row['cat_title'];
                    echo display_post($post_id, $post_title, $post_category, $post_author, $post_content, $post_date, $post_image, $post_comments_num,  $post_tags);
                  }
                ?>
                
                <div class="col-lg-12">
                  <div class="main-button">
                    <a href="blog.php">View All Posts</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <!-- Sidebar -->
            <?php include_once './includes/sidebar.php'; ?>
          </div>
        </div>
      </div>
    </section>

    
<?php include_once './includes/footer.php' ?>