<?php
namespace LH\Controllers;

use LH\Models\Blog;
use LH\Models\Setting;

class HomeController{
    public function index($page){
        $title="Home | Blogs";

        //get post limit from database
        $setting=new Setting();
        $maxPost=$setting->getMaxPost();
        

        //calculate current page and offset
        $offset=$maxPost*($page-1);

        //get blog lists with pagination
        $blog=new Blog();
        $totalpost=$blog->totalPost();
        $posts=$blog->getAllPosts($maxPost, $offset);

        //calculate totalpage
        $totalPage = ceil($totalpost / $maxPost);
        $mainContent=__DIR__.'/../Views/Home.php';
        require_once __DIR__ . '/../Views/Layout/PublicLayout.php';
    }
}