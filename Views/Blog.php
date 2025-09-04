<?php
if($post!=null){ ?>
    <!-- single post -->
    <div class="w-full">
        <p onclick="location.href='/'" class="text-black py-3 cursor-pointer"><i class="fa-solid fa-arrow-left"></i>Back to blog list</p>
        <img src="/uploads/<?php echo $post['image'] ?>" class="w-[343px] md:w-full h-[143px] md:h-[600px] rounded-lg" />
        <div class="w-full md:w-[60%] mx-auto contents flex flex-col justify-center py-5">
            <h1 class="font-bold text-[28px] md:text-[36px] text-left"><?php echo $post['title'] ?></h1>
            <p class="text-[14px] md:text-[16px] text-gray-600 border-b border-gray-300 pb-3">Written by <?php echo $post['author']." | ". $formatted_date ?></p>
            <br/>
            <p class="text-[16px] md:text-[18px] text-gray-600"><?php echo $post['description'] ?></p>
        </div>
    </div>
    <!-- footer -->
    <div class="hidden md:flex w-full md:w-[60%] mx-auto flex-row items-center justify-between border-t border-gray-300 pt-3">
        <p>Lemon Hive 2025 copyright all rights reserved</p>
        <div class="flex flex-row gap-3 w-max">
            <a class="h-[22px]" href="https://www.instagram.com/lemonhive/"><i class="fa-brands fa-square-instagram"></i></a>
            <a class="h-[22px]" href="https://x.com/lemon_hive"><i class="fa-brands fa-twitter"></i></a>
            <a class="text-[#7F56D9] h-[22px]" href="http://linkedin.com/company/lemon-hive"><i class="fa-brands fa-linkedin"></i></a>
        </div>
    </div>
    <div class="md:hidden w-full md:w-[60%] mx-auto flex flex-col items-center  border-t border-gray-300 pt-3">
        <div class="flex flex-row gap-3 w-max">
            <a class="h-[22px]" href="https://www.instagram.com/lemonhive/"><i class="fa-brands fa-square-instagram"></i></a>
            <a class="h-[22px]" href="https://x.com/lemon_hive"><i class="fa-brands fa-twitter"></i></a>
            <a class="text-[#7F56D9] h-[22px]" href="http://linkedin.com/company/lemon-hive"><i class="fa-brands fa-linkedin"></i></a>
        </div>
        <p>Lemon Hive 2025 copyright all rights reserved</p>
    </div>
    

<?php }else{
    echo '<p>This blog is not available<p>';
}