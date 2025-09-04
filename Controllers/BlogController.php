<?php

namespace LH\Controllers;

use DateTime;
use LH\Models\Blog;

class BlogController
{
    public function index($blogID)
    {

        $blog = new Blog();
        $post = $blog->getPostById(id: $blogID); {
            if ($post) {
                $date = new DateTime($post['created_at']);
                $formatted_date = $date->format('F j, Y');
            }
        }
        $title = $post ? $post['title'] : "Not found";
        $mainContent = __DIR__ . '/../Views/Blog.php';
        require_once __DIR__ . '/../Views/Layout/PublicLayout.php';
    }
}
