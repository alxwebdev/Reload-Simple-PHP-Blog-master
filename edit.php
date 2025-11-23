<?php
require_once 'connect.php';
require_once 'header.php';
require_once 'security.php';

$id = (INT)$_GET['id'];
if ($id < 1) {
    header("location: index.php");
}

$sql = "SELECT * FROM posts WHERE id = '$id'";
$result = mysqli_query($dbcon, $sql);
if (mysqli_num_rows($result) == 0) {
    header("location: index.php");
}
$row = mysqli_fetch_assoc($result);
$id = htmlspecialchars($row['id']);
$title = htmlspecialchars($row['title']);
$description = htmlspecialchars($row['description']);
$slug = htmlspecialchars($row['slug']);
$permalink = "p/". $id."/".$slug;

if (isset($_POST['upd'])) {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($dbcon, $_POST['title']);
    $description = mysqli_real_escape_string($dbcon, $_POST['description']);
    $slug = slug(mysqli_real_escape_string($dbcon, $_POST['slug']));

    $sql2 = "UPDATE posts SET title = '$title', description = '$description', slug = '$slug' WHERE id = $id";

    if (mysqli_query($dbcon, $sql2)) {
        // If the database update query is successful, refresh the page to show the updated data.
        header("location: $permalink");
        exit();
    } else {
        // If the query fails, display an error message including the database connection error.
        echo "failed to update." . mysqli_connect_error();
    }
}
?>

    <div class="form-container">
        <h2 class="form-title">Edit Post</h2>
        <div style="margin-bottom: var(--spacing-md);">
            <a href="<?=$permalink?>" class="btn btn-outline">View Post</a>
        </div>

        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
            <div class="form-group">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"><?php echo $description; ?> </textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">Slug (SEO URL)</label>
                <input type="text" class="form-control" name="slug" value="<?php echo $slug; ?>">
            </div>
            
            <div class="flex justify-between items-center">
                <input type="submit" class="btn btn-primary" name="upd" value="Save post">
                
                <a href="<?=$url_path?>del.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Are you sure you want to delete this post?'); " class="btn btn-outline" style="color: var(--error-color); border-color: var(--error-color);">Delete Post</a>
            </div>
        </form>
    </div>

<?php

mysqli_close($dbcon);
include("footer.php");
