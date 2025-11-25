<?php
require_once 'connect.php';
require_once 'header.php';

$category_id = intval($_GET['id']); // sanitize input

// Fetch category name
$catResult = mysqli_query($dbcon, "SELECT name FROM categories WHERE id=$category_id");
$category = mysqli_fetch_assoc($catResult);

// Fetch posts in this category
$postResult = mysqli_query($dbcon, "SELECT * FROM posts WHERE category_id=$category_id");


echo "<h2>Posts in Category: " . htmlspecialchars($category['name']) . "</h2>";

if (mysqli_num_rows($postResult) < 1) {
    echo '<div class="alert alert-empty">No post yet!</div>';
} else {
  while ($row = mysqli_fetch_assoc($postResult)) {

    $id = htmlspecialchars($row['id']);
    $title = htmlspecialchars($row['title']);
    $des = htmlspecialchars(limitText($row['description']));
    $slug = htmlspecialchars($row['slug']);
    $time = htmlspecialchars($row['date']);
    $category_name = htmlspecialchars($category['name']);

    $permalink = "p/".$id ."/".$slug;

    echo '<div class="post-card">';
    echo "<h3 class='post-title'><a href='$permalink'>$title</a></h3>";
    echo "<a href='category.php?id=$category_id' class='post-category-link'><p class='post-category'>$category_name</p></a>";
    echo "<p class='post-excerpt'>$des</p>";

    echo '<div class="post-meta">';
    echo "<a href='$permalink' class='read-more'>Read more &rarr;</a>";
    echo "<span>$time</span>";
    echo '</div>';
    echo '</div>';
}
}