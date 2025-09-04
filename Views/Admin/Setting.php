<div class="w-full">
    <a href="/admin/dashboard" class="flex flex-row gap-3 items-center py-3">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Back to dashboard</span>
    </a>
    <p class="font-bold text-[20px] md:text-[24px] my-2">Number Of Posts Per Page</p>
    <?php
    if (isset($_SESSION['settingresponse'])) {
        if ($_SESSION['settingresponse']) {
            $color = 'text-green-800';
        } else {
            $color = 'text-red-800';
        }
    ?>
        <p class="<?php echo $color ?>"><?php echo $_SESSION['settingpageresponse'] ?></p>
    <?php
        unset($_SESSION['settingresponse']);
        unset($_SESSION['settingpageresponse']);
    }

    ?>
    <form action="/admin/api/save-post" method="post" class="w-full flex flex-col md:flex-row gap-2">
        <input required type="number" class="w-full md:w-[30%] rounded-md border border-gray-400 outline-none text-gray-400 p-2" name="postno" value="<?php echo $maxPost ?>">
        <input type="submit" value="Save" class="w-max px-5 py-1 rounded-md text-white text-[16px] bg-[#7F56D9] cursor-pointer">
    </form>
</div>