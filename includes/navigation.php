

<header class="">
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="index.html"><h2>Stand Blog<em>.</em></h2></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
<?php
  $menu_result = select_menu_items();
  $page_name = get_page_name();
  while($row = mysqli_fetch_assoc($menu_result)) {
    $menu_item = $row['menu_title'];
    $menu_href = $row['menu_href'];

?>
    <li class="nav-item <?php echo $page_name == $menu_href ? 'active' : '' ?>">
      <a class="nav-link" href="<?php echo './'.$menu_href ?>"><?php echo $menu_item ?></a>
    </li>

<?php } ?>
            
            <!-- <li class="nav-item">
              <a class="nav-link" href="blog.html">Blog Entries</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="post-details.html">Post Details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact Us</a>
            </li> -->
          </ul>
        </div>
      </div>
    </nav>
  </header>


  <!-- <li class="nav-item active">
              <a class="nav-link" href="index.html">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>  -->