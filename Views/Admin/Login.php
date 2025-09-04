<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <title>Admin Login</title>
</head>

<body class="h-screen w-full flex justify-center items-center">
    <div class="w-[70%] md:max-w-sm mx-auto">
        <a href="/">
            <img src="/assets/images/main.jpg" alt="Error Logo" class="h-[60px] md:h-[80px]" />
        </a>

        <?php
        if (!empty($_SESSION['loginerror'])) { ?>
            <p class="text-red-600"><?= htmlspecialchars($_SESSION['loginerror']) ?></p>
        <?php $_SESSION['loginerror'] = null;
        }
        ?>

        <form action="/admin/login" method="post" class="flex flex-col gap-3 text-[16px]">
            <label for="username">Username</label>
            <input type="text" class="border border-gray-300 outline-none rounded-md p-2" name="username" placeholder="Enter your username" />
            <label for="password">Password</label>
            <input type="password" class="border border-gray-300 outline-none rounded-md p-2" name="password" placeholder="........" />
            <input type="submit" value="Login" class="w-full text-white bg-purple-600 py-2 rounded-md" />
        </form>
    </div>
</body>

</html>