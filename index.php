<?php

require_once 'autoload.php';
session_start();


if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
}

use LH\Controllers\AdminController;
use LH\Controllers\BlogController;
use LH\Controllers\HomeController;
use LH\RequestHandler;

$request = new RequestHandler();


$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uris = explode('/', trim($requestUri, '/'));

// Handle pagination if query exists
$page = $request->getRequest('page') ? (int)$request->getRequest('page') : 1;

// Default route
if (empty($uris[0])) {
    $controller = new HomeController();
    $controller->index($page);
    exit;
}

// Blog route: /blog/{id}
if ($uris[0] === 'blog') {
    $blogID = isset($uris[1]) ? (int)$uris[1] : null;
    $controller = new BlogController();
    $controller->index($blogID);
    exit;
}

// Admin routes: /admin
if ($uris[0] === 'admin') {
    $controller = new AdminController();
    $secondUri = isset($uris[1]) ? $uris[1] : null;
    $thirdUri = isset($uris[2]) ? $uris[2] : null;
    $fourthUri = isset($uris[3]) ? $uris[3] : null;
    $fifthUri = isset($uris[4]) ? $uris[4] : null;

    // Admin login: /admin/login
    if ($secondUri === 'login') {
        $requiredFields = ['username', 'password'];
        if ($request->validate($requiredFields)) {
            $username = $request->postRequest('username');
            $password = $request->postRequest('password');
            $controller->login($username, $password);


            if ($_SESSION['logged_in']) {
                header("Location: /admin/dashboard");
                exit;
            } else {
                $_SESSION['loginerror'] = "Invalid username or password";
                require_once __DIR__ . '/Views/Admin/Login.php';
                exit;
            }
        } else {
            $_SESSION['loginerror'] = "Validation failed. Please check entered information";
            require_once __DIR__ . '/Views/Admin/Login.php';
            exit;
        }
    } else if ($secondUri === 'logout') {
        $controller->logout();
        exit;
    } else if ($secondUri === 'log-in') {
        require_once __DIR__ . '/Views/Admin/Login.php';
        exit;
    }

    // If logged in
    if ($_SESSION['logged_in']) {
        switch ($secondUri) {
            case 'dashboard':
                $controller->dashboard($page);
                break;
            case 'setting':
                $controller->setting();
                break;
            case 'create-new-post':
                $controller->createPostPage();
                break;
            case 'api':
                //handle admin API routes
                switch ($thirdUri) {
                    case 'save-post':
                        $requiredFields = ['postno'];
                        if ($request->validate($requiredFields)) {
                            $postno = $request->postRequest('postno');
                            $controller->updatePostSetting($postno);
                        } else {
                            echo 'Validation Failed';
                        }
                        break;
                    case 'delete':
                        if ($fourthUri) {
                            $pageid = $request->postRequest('page_id');
                            $controller->deltePost((int)$fourthUri, $pageid);
                        } else {
                            $requiredFields = ['delete_id', 'page_id'];
                            if ($request->validate($requiredFields)) {
                                $id = $request->postRequest('delete_id');
                                $pageid = $request->postRequest('page_id');
                                $_SESSION['showDeletePopup'] = true;
                                $_SESSION['delete_id'] = $id;
                                header("Location: /admin/dashboard?page=$pageid");
                                exit;
                            } else {
                                echo 'Validation Failed';
                            }
                        }
                        break;
                    case 'delete-cancel':
                        unset($_SESSION['showDeletePopup']);
                        $pageid = $request->postRequest('page_id');
                        header("Location: /admin/dashboard?page=$pageid");
                        break;

                    case 'create-post':
                        $requiredFields = ['title', 'description', 'image_file'];
                        if ($request->validate($requiredFields)) {
                            $fileNameTmp  = $_FILES['image_file']['tmp_name'];
                            $fileName = $_FILES['image_file']['name'];
                            $title = $request->postRequest('title');
                            $description = $request->postRequest('description');
                            $controller->createPost($fileNameTmp, $fileName, $title, $description);
                        } else {
                            $_SESSION['createpostnotification'] = false;
                            $_SESSION['createpostmessage'] = 'Post Create validation Failed';
                        }
                        break;
                    case 'edit':
                        $requiredFields = ['post_id', 'page_id'];
                        if ($request->validate($requiredFields)) {
                            $postid = $request->postRequest('post_id');
                            $pageid = $request->postRequest('page_id');
                            $controller->editPostPage($postid, $pageid);
                        } else {
                            //sending validation error message
                            $_SESSION['dashboardnotification'] = false;
                            $_SESSION['dashboardmessage'] = "Validation Failed";
                            header("Location: /admin/dashboard");
                            exit;
                        }
                        break;
                    case 'hide-edit':
                        $pageid = $request->postRequest('page_id');
                        unset($_SESSION['showeditpopup']);
                        unset($_SESSION['postdata']);
                        header("Location: /admin/dashboard?page=$pageid");
                        exit;
                        break;
                    case 'delete-image':
                        $pageid = $fourthUri;
                        $postid = $fifthUri;
                        $controller->deletePostImage($pageid, $postid);
                        break;
                    case 'update-post':
                        $requiredFields = ['post_id', 'page_id', 'title', 'description'];
                        if ($request->validate($requiredFields)) {
                            $postid = $request->postRequest('post_id');
                            $pageid = $request->postRequest('page_id');
                            $title = $request->postRequest('title');
                            $description = $request->postRequest('description');
                            $image = isset($_FILES['image_file']) ? true : false;
                            $fileNameTmp=null;
                            $fileName=null;
                            if ($image) {
                                $fileNameTmp  = $_FILES['image_file']['tmp_name'];
                                $fileName = $_FILES['image_file']['name'];
                            }
                            $controller->UpdatePost($postid, $pageid, $title, $description, $image,$fileNameTmp,$fileName);
                        } else {
                            //sending validation error message
                            $_SESSION['dashboardnotification'] = false;
                            $_SESSION['dashboardmessage'] = "Validation Failed";
                            header("Location: /admin/dashboard");
                            exit;
                        }
                        break;
                }
                break;
        }
    } else {
        // Not logged in → show login page
        header('Location: /admin/log-in');
        exit;
    }
}
