<?php
require_once 'connect.php';
require_once 'header.php';
require_once 'security.php';

function getCategories($dbcon) {
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($dbcon, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$result = getCategories($dbcon);

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($dbcon, $_POST['title']);
    $description = mysqli_real_escape_string($dbcon, $_POST ['description']);
    $slug = slug($title);
    $category_id = mysqli_real_escape_string($dbcon, $_POST['category_id']);
    $date = date('Y-m-d H:i');
    $posted_by = mysqli_real_escape_string($dbcon, $_SESSION['username']);

    $sql = "INSERT INTO posts (title, description, slug, category_id, posted_by, date) VALUES('$title', '$description', '$slug', '$category_id', '$posted_by', '$date')";
    mysqli_query($dbcon, $sql) or die("failed to post" . mysqli_connect_error());

    $permalink = "p/".mysqli_insert_id($dbcon) ."/".$slug;

    printf("Posted successfully. <meta http-equiv='refresh' content='2; url=%s'/>",
       $permalink);

} else {
    
    ?>
    <div class="form-container">
        <h2 class="form-title">New Post</h2>

        <form method="POST">

            <div class="form-group">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>

            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php foreach ($result as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea id="description" rows="10" class="form-control" name="description" required></textarea>
            </div>            
            <input type="submit" class="btn btn-primary" name="submit" value="Post">
        </form>

    </div>
    <?php
// Fetch categories to populate dropdown

}

include("footer.php");
