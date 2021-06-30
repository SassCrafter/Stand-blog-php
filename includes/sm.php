<ul class="social-icons">
<?php
    $sm_links = get_all_sm_links();
    while ($row = mysqli_fetch_assoc($sm_links)) {
        $link_title = ucfirst($row['sm_title']);
        $link_url = $row['sm_url'];
        echo "<li><a href='$link_url'>$link_title</a></li>";
    }
?>
</ul>