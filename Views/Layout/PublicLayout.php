<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- tailwindcss cdn -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Manrope font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- CSS for Body -->
    <link rel="stylesheet" href="../../assets/CSS/main.css">

    <!-- Dynamic title -->
    <title><?php echo $title ?></title>

    <!-- Fontawesome CDN -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="w-full bg-white flex flex-col items-center py-2 px-6">
    <header class="w-full md:w-[80%] flex flex-row justify-between items-center justify-between">
        <a href="/">
            <img src="/assets/images/main.jpg" alt="Error Logo" class="h-[60px] md:h-[80px]"/>
        </a>
        <?php
        $loggedIn=false;
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
            $loggedIn=true;
        }
        ?>
        <a href="<?php echo $loggedIn? '/admin/logout':'/admin/dashboard' ?>"><p class="text-white py-2 px-4 bg-[#7F56D9] h-max w-max rounded-md"><?php echo $loggedIn? "Log out":"Admin Panel"  ?></p></a>
    </header>
    <main class="w-full md:w-[80%] flex flex-col items-center justify-center">
        <?php require_once $mainContent ?>
    </main>
    <footer>
        <!-- No footer mentioned -->
    </footer>
</body>

</html>