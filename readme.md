# 📝 Lemon Hive Blog Platform

This is a PHP-based blog platform with an admin panel for content management. The application features a responsive design, pagination, image uploads, and a clean user interface.

### Video Demonstration
A YouTube video demonstration will be added to this section to showcase the functionality of the Lemon Hive blog platform.

---
## ✨ Features

* **Public Blog**: View blog posts with pagination.
* **Individual Blog Pages**: A detailed view for each blog post is available.
* **Admin Panel**: Includes a secure login system for content management.
* **CRUD Operations**: Create, read, update, and delete blog posts.
* **Settings Management**: Configure the number of posts displayed per page.
* **Image Handling**: Upload and manage images for blog posts.
* **Responsive Design**: The platform is designed to work on both desktop and mobile devices.

---
## 💻 Requirements

* PHP 7.4 or higher
* MySQL 5.7 or higher
* Apache web server with `mod_rewrite` enabled
* Composer (for autoloading)

---
## 🚀 Setup and Installation

Follow these steps to get the project running on your local machine.

1.  **Clone or download the project** files to your web server directory.

2.  **Create the Database**:
    * Create a new MySQL database named `lemon_hive`.
    * [cite_start]Import the SQL structure from the `lemon_hive.sql` file. 

3.  **Configure Database Connection**:
    * [cite_start]Open the `Database/Database.php` file. 
    * [cite_start]Update the database credentials if they differ from the defaults: 
        ```php
        private $host='localhost';
        private $db_name='lemon_hive';
        private $username='root';
        private $password='mysql';
        ```

4.  **Set Up File Permissions**:
    * [cite_start]Ensure the `uploads/` directory exists and is writable by the web server. 

5.  **Configure URL Rewriting**:
    * Ensure the `mod_rewrite` module is enabled in your Apache configuration.
    * [cite_start]The project includes a `.htaccess` file for URL routing. 

---
## 🛠️ Usage

### Admin Access
* **URL**: `/admin/log-in`
* **Username**: `lemon`
* **Password**: `lemon`

### For Visitors
* Visit the homepage to see all blog posts.
* Click on a post title or "Read More" to view the full article.
* Use pagination controls to navigate through posts.

### For Administrators
* Log in at `/admin/log-in`.
* **Dashboard (`/admin/dashboard`)**:
    * View all posts in a table.
    * Edit or delete existing posts.
* **Create New Posts**:
    * Click "Create new post" on the dashboard.
    * Fill in the title, description, and upload an image.
    * Submit to publish.
* **Settings (`/admin/setting`)**:
    * Configure the number of posts per page.

---
## 📂 Project Structure
```text
root/
├── assets/
│   ├── CSS/
│   │   └── main.css          # Styles and fonts
│   └── images/
│       └── main.jpg          # Logo image
├── Controllers/              # Application controllers
│   ├── AdminController.php
│   ├── BlogController.php
│   └── HomeController.php
├── Database/
│   └── Database.php          # Database connection
├── Models/                   # Data models
│   ├── Admin.php
│   ├── Blog.php
│   └── Setting.php
├── uploads/                  # Blog post images
├── Views/
│   ├── Admin/                # Admin panel views
│   │   ├── CreateNewPost.php
│   │   ├── Dashboard.php
│   │   ├── Login.php
│   │   └── Setting.php
│   ├── Layout/
│   │   └── PublicLayout.php  # Main layout template
│   ├── Blog.php              # Single blog post view
│   └── Home.php              # Homepage view
├── .htaccess                 # URL rewriting rules
├── autoload.php              # Class autoloader
├── index.php                 # Main application entry point
├── lemon_hive.sql            # Database schema
└── RequestHandler.php        # Request handling utility