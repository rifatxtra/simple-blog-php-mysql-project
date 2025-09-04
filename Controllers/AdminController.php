<?php

namespace LH\Controllers;

use LH\Models\Blog;
use LH\Models\Setting;
use LH\Models\Admin;


class AdminController
{
    public function login($username, $password)
    {
        $admin = new Admin();
        $response = $admin->verify($username, $password);
        if ($response) {
            $_SESSION['logged_in'] = true;
        }
    }

    public function logout()
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            $_SESSION['logged_in'] = false;
            header('Location: /');
            exit;
        }
    }
    public function dashboard($page = 0)
    {
        //title for dashboard page
        $title = "Dashboard-Admin";

        //get post limit from database
        $setting = new Setting();
        $maxPost = $setting->getMaxPost();


        //calculate current page and offset
        $offset = $maxPost * ($page - 1);

        //get blog lists with pagination
        $blog = new Blog();
        $totalpost = $blog->totalPost();
        $posts = $blog->getAllPosts($maxPost, $offset);

        //calculate totalpage
        $totalPage = ceil($totalpost / $maxPost);

        $mainContent = __DIR__ . '/../Views/Admin/Dashboard.php';
        require_once __DIR__ . '/../Views/Layout/PublicLayout.php';
    }

    public function setting()
    {
        $title = "Setting-Admin";
        $setting = new Setting();
        $maxPost = $setting->getMaxPost();
        $mainContent = __DIR__ . '/../Views/Admin/Setting.php';
        require_once __DIR__ . '/../Views/Layout/PublicLayout.php';
    }

    public function updatePostSetting($postno)
    {
        $setting = new Setting();
        $response = $setting->updateMaxPostSetting($postno);
        if ($response) {
            $_SESSION['settingresponse'] = true;
            $_SESSION['settingpageresponse'] = 'Max Post Setting updated Successfully';
        } else {
            $_SESSION['settingresponse'] = false;
            $_SESSION['settingpageresponse'] = 'Max Post Setting update failed';
        }
        header("Location: /admin/setting");
    }
    public function deltePost($id, $pageid)
    {
        $blog = new Blog();
        $response = $blog->detePost($id);
        if ($response) {
            unset($_SESSION['showDeletePopup']);
            $_SESSION['dashboardmessage'] = 'Post delete successfull';
            $_SESSION['dashboardnotification'] = true;
        } else {
            $_SESSION['dashboardnotification'] = false;
            $_SESSION['dashboardmessage'] = 'Post delete failed';
        }
        header("Location: /admin/dashboard?page=$pageid");
        exit;
    }

    public function createPostPage()
    {
        $title = 'Create New Post';
        $mainContent = __DIR__ . '/../Views/Admin/CreateNewPost.php';
        require_once __DIR__ . '/../Views/Layout/PublicLayout.php';
    }

    public function createPost($fileNameTmp, $fileName, $title, $description)
    {
        $blog = new Blog();
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . time() . '.' . $fileExtension;
        $uploadDir = __DIR__ . '/../uploads/';

        if (move_uploaded_file($fileNameTmp, $uploadDir . $newFileName)) {
            $respone = $blog->storePost($title, $description, $newFileName);
            if ($respone) {
                $_SESSION['createpostnotification'] = true;
                $_SESSION['createpostmessage'] = 'Post Created Successfully';
            } else {
                $_SESSION['createpostnotification'] = false;
                $_SESSION['createpostmessage'] = 'Failed to store in Database';
            }
        } else {
            $_SESSION['createpostnotification'] = false;
            $_SESSION['createpostmessage'] = 'Failed to move uploaded file.';
        }
        $this->createPostPage();
    }

    public function editPostPage($postid, $pageid)
    {
        $blog = new Blog();
        $_SESSION['showeditpopup'] = true;
        $_SESSION['postdata'] = $blog->getPostById($postid);
        $_SESSION['postdata']['pageid'] = $pageid;
        header("Location: /admin/dashboard?page=$pageid");
        exit;
    }

    public function deletePostImage($pageid, $postid)
    {
        $blog = new Blog();
        $response = $blog->deleteImage($postid);
        if ($response) {
            $_SESSION['editerror'] = false;
            $_SESSION['msg'] = 'Image delted successfully';
        } else {
            $_SESSION['editerror'] = true;
            $_SESSION['msg'] = 'Image delte unsuccessful';
        }
        header("Location: /admin/dashboard?page=$pageid");
        exit;
    }

    public function UpdatePost($postid, $pageid, $title, $description, $image, $fileNameTmp, $fileName)
    {
        $blog = new Blog();
        if ($image) {
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . time() . '.' . $fileExtension;
            $uploadDir = __DIR__ . '/../uploads/';
            if (move_uploaded_file($fileNameTmp, $uploadDir . $newFileName)) {
                $response = $blog->updatePostWithImage($postid, $title, $description, $newFileName);
            } else {
                $_SESSION['editerror'] = true;
                $_SESSION['msg'] = 'Image store failed';
            }
        } else {
            $response = $blog->updatePostWithoutImage($postid, $title, $description);
        }
        if ($response) {
            unset($_SESSION['postdata']);
            unset($_SESSION['showeditpopup']);
            $_SESSION['updatestatus']=true;
        } else {
            $_SESSION['editerror'] = true;
            $_SESSION['msg'] = 'Image store to database failed';
        }
        header("Location: /admin/dashboard?page=$pageid");
        exit;
    }
}
