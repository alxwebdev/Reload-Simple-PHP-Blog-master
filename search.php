<?php
require_once 'connect.php';
require_once 'header.php';

if (isset($_GET['q'])) {
    $q = mysqli_real_escape_string($dbcon, $_GET['q']);

    $sql = "SELECT * FROM posts WHERE title LIKE '%{$q}%' OR description LIKE '%{$q}%'";
    $result = mysqli_query($dbcon, $sql);

    if (mysqli_num_rows($result) < 1) {
        echo "Nothing found.";
    } else {

      echo "<div class='alert alert-info'>Showing results for <strong>$q</strong></div>";

      while ($row = mysqli_fetch_assoc($result)) {

        $id = htmlentities($row['id']);
        $title = htmlentities($row['title']);
        $des = htmlentities(strip_tags($row['description']));
        $slug = htmlentities(strip_tags($row['slug']));
        $time = htmlentities($row['date']);

        $permalink = "p/".$id ."/".$slug;

        echo '<div class="post-card">';
        echo "<h3 class='post-title'><a href='$permalink'>$title</a></h3>";
        echo "<p class='post-excerpt'>" . substr($des, 0, 100) . "...</p>";

        echo '<div class="post-meta">';
        echo "<a href='$permalink' class='read-more'>Read more &rarr;</a>";
        echo "<span>$time</span>";
        echo '</div>';
        echo '</div>';

      }

    }
}
include("footer.php");
