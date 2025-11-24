<?php
require_once 'connect.php';
require_once 'header.php';
?>

<div class="alert alert-info">
    <p>This is a simple blog project for my PHP development skills.</p>
</div>

<?php
// COUNT
$sql = "SELECT COUNT(*) FROM posts";
$result = mysqli_query($dbcon, $sql);
$r = mysqli_fetch_row($result);
$numrows = $r[0];

$rowsperpage = PAGINATION;
$totalpages = ceil($numrows / $rowsperpage);

$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (INT)$_GET['page'];
}

if ($page > $totalpages) {
    $page = $totalpages;
}

if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $rowsperpage;

/* $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $offset, $rowsperpage";
$result = mysqli_query($dbcon, $sql); */

$sql = "SELECT posts.*, categories.name AS category_name 
        FROM posts 
        LEFT JOIN categories ON posts.category_id = categories.id
        ORDER BY posts.id DESC LIMIT $offset, $rowsperpage";
$result = mysqli_query($dbcon, $sql);

if (mysqli_num_rows($result) < 1) {
    echo '<div class="alert alert-empty">No post yet!</div>';
} else {
  while ($row = mysqli_fetch_assoc($result)) {

    $id = htmlspecialchars($row['id']);
    $title = htmlspecialchars($row['title']);
    $des = htmlspecialchars(limitText($row['description']));
    $slug = htmlspecialchars($row['slug']);
    $time = htmlspecialchars($row['date']);
    $category_name = htmlspecialchars($row['category_name']);

    $permalink = "p/".$id ."/".$slug;

    echo '<div class="post-card">';
    echo "<h3 class='post-title'><a href='$permalink'>$title</a></h3>";
    echo "<p class='post-category'>$category_name</p>";
    echo "<p class='post-excerpt'>" . $des . "</p>";

    echo '<div class="post-meta">';
    echo "<a href='$permalink' class='read-more'>Read more &rarr;</a>";
    echo "<span>$time</span>";
    echo '</div>';
    echo '</div>';
}


echo "<div class='pagination'>";

if ($page > 1) {
    echo "<a href='?page=1' class='page-link'>&laquo;</a>";
    $prevpage = $page - 1;
    echo "<a href='?page=$prevpage' class='page-link'><</a>";
}

$range = 5;
for ($x = $page - $range; $x < ($page + $range) + 1; $x++) {
    if (($x > 0) && ($x <= $totalpages)) {
        if ($x == $page) {
            echo "<div class='page-link active'>$x</div>";
        } else {
            echo "<a href='?page=$x' class='page-link'>$x</a>";
        }
    }
}

if ($page != $totalpages) {
    $nextpage = $page + 1;
    echo "<a href='?page=$nextpage' class='page-link'>></a>";
    echo "<a href='?page=$totalpages' class='page-link'>&raquo;</a>";
}

echo "</div>";
}

// include("categories.php");
include("footer.php");
