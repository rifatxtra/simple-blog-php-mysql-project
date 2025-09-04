<div class="w-full">
    <a href="/admin/dashboard" class="flex flex-row gap-3 items-center py-3">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Back to dashboard</span>
    </a>
    <p class="text-[18px] font-bold my-2">Published Blog List</p>
    <?php
    if (isset($_SESSION['createpostnotification'])) {
        if ($_SESSION['createpostnotification']) {
            $color = 'text-green-800';
        } else {
            $color = 'text-red-800';
        }

        if (isset($_SESSION['createpostmessage'])) { ?>
            <p class="font-bold <?php echo $color ?>"><?php echo $_SESSION['createpostmessage'] ?></p>
    <?php
            unset($_SESSION['createpostmessage']);
            unset($_SESSION['createpostnotification']);
        }
    } ?>

    <form action="/admin/api/create-post" method="post" enctype="multipart/form-data" class="space-y-4">
        <label for="title" class="block font-semibold">Title</label>
        <input type="text" name="title" placeholder="Enter your title" required
            class="w-full border rounded-md px-3 py-2 focus:outline-none  border-gray-300" />

        <label for="description" class="block font-semibold">Description</label>
        <textarea name="description" placeholder="........" required
            class="w-full border rounded-md px-3 py-2 focus:outline-none border-gray-300"></textarea>

        <label for="image" class="block font-semibold">Featured Image</label>

        <div class="relative w-full h-24 border border-gray-300 rounded-md flex flex-col items-center justify-center cursor-pointer"
            onclick="document.getElementById('fileInput').click()">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
            </svg>


            <span id="fileName" class="text-[#7F56D9]">Please select a photo</span>


            <input type="file" name="image_file" accept=".jpg,.jpeg,.png" id="fileInput" class="hidden" />
            <script>
                document.getElementById('fileInput').addEventListener('change', function() {
                    const fileNameSpan = document.getElementById('fileName');
                    if (this.files && this.files.length > 0) {
                        fileNameSpan.textContent = this.files[0].name;
                    } else {
                        fileNameSpan.textContent = "Please select a photo";
                    }
                });
            </script>
        </div>

        <button type="submit" name="submit_post" class="bg-[#7F56D9] w-full text-white px-4 py-2 rounded-md cursor-pointer">Submit</button>
    </form>
</div>