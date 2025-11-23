<?php
require_once 'connect.php';
require_once 'header.php';

echo '<div class="form-container">';
echo '<h2 class="form-title">Login</h2>';

if (isset($_POST['log'])) {
    $username = mysqli_real_escape_string($dbcon, $_POST['username']);
    $password = mysqli_real_escape_string($dbcon, $_POST['password']);

    $sql = "SELECT * FROM admin WHERE username = '$username'";

    $result = mysqli_query($dbcon, $sql);
    $row = mysqli_fetch_assoc($result);
    $row_count = mysqli_num_rows($result);


    if ($row_count == 1 && password_verify($password, $row['password'])) {
        $_SESSION['username'] = $username;
        header("location: admin.php");
    } else {
        echo "<div class='alert alert-error'>Incorrect username or password.</div>";
    }
}
    ?>

    <form action="" method="POST">
        <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" name="username" value="<?php if(isset($_POST['username'])){ echo strip_tags($_POST['username']);}?>" class="form-control">
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <input type="submit" name="log" value="Login" class="btn btn-primary">
    </form>
    </div>

    <?php

Include("footer.php");
