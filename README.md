# Downloaded the repository from https://github.com/Philipinho/Simple-PHP-Blog and tweaked it a bit to fit my needs.
New features added:
- new layout
- category functionality
- dark mode
- security improvements

# Screenshots

![screenshot_01](https://github.com/alxwebdev/Reload-Simple-PHP-Blog-master/blob/main/Screenshot%202025-11-25%20at%2023-08-54%20PHP%20Blog.png)


# Simple-PHP-Blog
Simple blog system for personal development using procedural PHP and MYSQL.

For educational purposes only.

# Setup

Update the `connect.php` file with your database credentials.  
Import the `database.sql` file.  

If installed on a sub-folder, edit the `config.php` and replace the empty constant with the folder's name.  

The pagination results per page can be set on the `config.php` file.  

### URL Rewrite
The latest update introduces 'slugs', also known as 'SEO URLs'.   
After you update to the latest version, click on the "Generate slugs (SEO URLs)" button on the admin dashboard and slugs will be generated for all existing posts.   

The blog posts URL structure is like this: `http://localhost/p/4/apple-reveals-apple-watch-series-7`   

If you use Apache, enable the Apache rewrite module for the .htaccess rewrite rule to work.

If you use NGINX, you can insert something similar to the code below in your NGINX configuration block.      
```
location / {
    rewrite ^p/(.*) view.php?id=$1;
}
```

# Default Admin Login
Username: admin  
Password: 12345   

There is no way to update the admin password through the dashboard yet.  
To change your password, hash your password with PHP's `password_hash()` function. Then update the database value with the new password hash.   

