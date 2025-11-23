<?php
require_once 'connect.php';
require_once 'header.php';

$id = (INT)$_GET['id'];
if ($id < 1) {
    header("location: $url_path");
}
$sql = "Select * FROM posts WHERE id = '$id'";
$result = mysqli_query($dbcon, $sql);

$invalid = mysqli_num_rows($result);
if ($invalid == 0) {
    header("location: $url_path");
}

$hsql = "SELECT posts.*, categories.name AS category_name FROM posts LEFT JOIN categories ON posts.category_id = categories.id WHERE posts.id = '$id'";
$result = mysqli_query($dbcon, $hsql);
$row = mysqli_fetch_assoc($result);


$id = $row['id'];
$title = htmlspecialchars($row['title']);
$description = $row['description'];
$author = htmlspecialchars($row['posted_by']);
$time = htmlspecialchars($row['date']);
$category_name = htmlspecialchars($row['category_name']);

echo '<div class="post-card">';
echo "<h3 class='post-title'>$title</h3>";
echo "<p class='post-category'>$category_name</p>";
echo '<div class="post-content">';
echo "$description<br>";
echo '<div class="post-meta">';
echo "Posted by: " . $author . "<br>";
echo "$time</div>";
?>


<?php
if (isset($_SESSION['username'])) {
    ?>
    <div class="admin-actions">
        <a href="<?=$url_path?>edit.php?id=<?php echo $row['id']; ?>" class="btn btn-outline">[Edit]</a>
        <a href="<?=$url_path?>del.php?id=<?php echo $row['id']; ?>"
           onclick="return confirm('Are you sure you want to delete this post?'); " class="btn btn-outline" style="color: var(--error-color); border-color: var(--error-color);">[Delete]</a>
    </div>
    <?php
}
echo '</div></div>';


include("footer.php");
