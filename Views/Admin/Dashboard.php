<div class="w-full">
    <a href="/" class="flex flex-row gap-3 items-center py-3">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Back to blog list</span>
    </a>
    <div class="flex flex-row justify-between py-3">
        <p class="text-[18px] font-bold">Published Blog List</p>
        <div class="flex flex-row gap-3 mr-2">
            <a href="/admin/create-new-post" class="flex flex-row items-center gap-2 text-white bg-[#7F56D9] rounded-md py-1 px-2">
                <i class="fa-solid fa-plus text-[16px] md:text-[20px]"></i>
                <p class="hidden md:block text-[16px]">Create new post</p>
            </a>
            <a href="/admin/setting" class="flex flex-row items-center gap-2 text-[#7F56D9] rounded-md py-1 px-2 border border-gray-200">
                <i class="fa-solid fa-gear text-[16px] md:text-[20px]"></i>
                <p class="hidden md:block text-[16px]">Settings</p>
            </a>
        </div>
    </div>

    <!-- delte pop up view -->
    <?php if (isset($_SESSION['showDeletePopup']) && $_SESSION['showDeletePopup']) { ?>
        <div class="fixed inset-0 flex items-center justify-center bg-black/25 z-50">
            <div class="bg-white p-6 rounded-md w-[80%] md:w-[40%]">
                <?php
                if (isset($_SESSION['dashboardnotification'])) {
                    if ($_SESSION['dashboardnotification']) {
                        $color = 'text-green-800';
                    } else {
                        $color = 'text-red-800';
                    }
                    if (isset($_SESSION['dashboardmessage'])) {
                ?>
                        ?>
                        <p class="<?php echo $color ?>"><?php echo $_SESSION['dashboardmessage'] ?></p>
                <?php
                    }
                }
                ?>
                <p class="mb-4 text-lg font-semibold">Are you sure you want to delete this post?</p>
                <div class="flex justify-end gap-3">
                    <form method="post" action="/admin/api/delete-cancel">
                        <input type="hidden" name="page_id" value="<?php echo $page ?>" />
                        <button type="submit" name="cancel_delete" class="border border-gray-200 rounded-md px-4 py-2 text-gray-600">Cancel</button>
                    </form>
                    <form method="post" action="/admin/api/delete/<?php echo $_SESSION['delete_id'] ?>">
                        <input type="hidden" name="page_id" value="<?php echo $page ?>" />
                        <button type="submit" name="confirm_delete" class="bg-[#7F56D9] text-white px-4 py-2 rounded-md">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    <?php  } ?>

    <!-- edit pop up view -->
    <?php if (isset($_SESSION['showeditpopup']) && $_SESSION['showeditpopup']) { ?>
        <div class="fixed inset-0 flex items-center justify-center bg-black/25 z-50">
            <div class="bg-white p-6 rounded-md w-[80%] md:w-[40%]">
                <div class="flex flex-row justify-between items-center py-2">
                    <p class="text-[#7F56D9] text-[20px]">Edit Post</p>
                    <form action="/admin/api/hide-edit" method="post">
                        <input type="hidden" name="page_id" value="<?php echo $page ?>" />
                        <button type="submit" class="text-gray-400 text-[20px] cursor-pointer"><i class="fa-solid fa-x"></i></button>
                    </form>
                </div>
                <?php
                if (isset($_SESSION['editerror'])) {
                    if ($_SESSION['editerror']) {
                        $color = 'text-red-800';
                    } else {
                        $color = 'text-green-800';
                    } ?>
                    <p class="<?php echo $color ?>"><?php echo $_SESSION['msg'] ?></p>

                <?php
                    unset($_SESSION['editerror']);
                    unset($_SESSION['msg']);
                }
                ?>
                <form action="/admin/api/update-post" method="post" enctype="multipart/form-data" class="space-y-4">
                    <label for="title" class="block font-semibold">Title</label>
                    <input type="text" name="title" placeholder="Enter your title" required
                        value="<?php echo $_SESSION['postdata']['title'] ?>"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none  border-gray-200" />

                    <label for="description" class="block font-semibold">Description</label>
                    <textarea name="description" placeholder="........" required
                        class="w-full border rounded-md px-3 py-2 focus:outline-none border-gray-200"><?php echo $_SESSION['postdata']['description'] ?></textarea>

                    <label for="image" class="block font-semibold">Featured Image</label>
                    <?php $image = $_SESSION['postdata']['image'] ?>
                    <div class="relative h-max w-full flex flex-col items-center">

                        <img id="imagePreview" src="/uploads/<?php echo $image ?>" alt="Error Featured image" class="mb-2 min-h-[60px]" />

                        <div class="w-[95%] p-3 bg-gray-200 absolute <?php echo $image ? 'top-[80%]' : 'top-0' ?> flex flex-row items-center mx-auto rounded-md">

                            <button type="button" id="editBtn" class="w-1/2 text-gray-700 text-center cursor-pointer">
                                <i class="fa-solid fa-pen-to-square text-lg"></i>
                            </button>

                            <button type="button" onclick="location.href='/admin/api/delete-image/<?php echo $page . '/' . $_SESSION['postdata']['id'] ?>'"
                                class="w-1/2 text-red-800 text-center cursor-pointer">
                                <i class="fa-solid fa-trash-can text-lg"></i>
                            </button>
                        </div>

                        <input type="file" name="image_file" id="fileInput" class="hidden" accept=".jpg,.jpeg,.png" />
                    </div>
                    <input type="hidden" name="page_id" value="<?php echo $page ?>" />
                    <input type="hidden" name="post_id" value="<?php echo $_SESSION['postdata']['id'] ?>" />
                    <input type="submit" value="Submit" class="w-full text-white bg-[#7F56D9] py-2 rounded-md my-2 cursor-pointer" />
                </form>

                <script>
                    const fileInput = document.getElementById('fileInput');
                    const editBtn = document.getElementById('editBtn');
                    const imagePreview = document.getElementById('imagePreview');

                    editBtn.addEventListener('click', () => fileInput.click());

                    fileInput.addEventListener('change', () => {
                        if (fileInput.files && fileInput.files.length > 0) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                imagePreview.src = e.target.result;
                            };
                            reader.readAsDataURL(fileInput.files[0]);
                        }
                    });
                </script>

            </div>
        </div>
    <?php  } ?>


    <div class="overflow-x-auto w-full">
        <?php
        if (isset($_SESSION['dashboardnotification'])) {
            if ($_SESSION['dashboardnotification']) {
                $color = 'text-green-800';
            } else {
                $color = 'text-red-800';
            }
            if (isset($_SESSION['dashboardmessage'])) {
        ?>
                <p class="<?php echo $color ?>"><?php echo $_SESSION['dashboardmessage'] ?></p>
        <?php }
            unset($_SESSION['showDeletePopup']);
            unset($_SESSION['delete_id']);
            unset($_SESSION['dashboardmessage']);
        }
        ?>
        <!-- show post update successful message -->
        <?php
        if (isset($_SESSION['updatestatus']) && $_SESSION['updatestatus']) { ?>
            <p class="text-green-800">Post Update successful</p>
        <?php
            unset($_SESSION['updatestatus']);
        }
        ?>
        <?php
        if (isset($_SESSION['editerror']) && $_SESSION['editerror']) { ?>
            <p class="text-red-800"><?php echo $_SESSION['msg'] ?></p>
        <?php
            unset($_SESSION['editerror']);
            unset($_SESSION['msg']);
        }
        ?>

        <table class="w-full text-black border border-gray-100 rounded-md">
            <thead>
                <tr class="text-black border-b border-gray-200">
                    <th class="text-left text-[#7F56D9] w-[80%] p-3">Title</th>
                    <th class="text-[#7F56D9] w-[10%] p-3">Edit</th>
                    <th class="text-[#7F56D9] w-[10%] p-3">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post) { ?>
                    <tr class="text-black border-b border-gray-200">
                        <td class="w-[80%] text-left p-3 text-wrap"><?php echo $post['title']; ?></td>
                        <td class="w-[10%] text-gray-600 mx-auto p-3 text-center">
                            <form method="post" action="/admin/api/edit">
                                <input type="hidden" name="post_id" value="<?php echo $post['id'] ?>" />
                                <input type="hidden" name="page_id" value="<?php echo $page ?>" />
                                <button class="cursor-pointer" type="submit"><i class="fa-solid fa-pen-to-square text-lg"></i></button>
                            </form>
                        </td>
                        <td class="w-[10%] text-[#EB5757] mx-auto p-3 text-center">
                            <form method="post" action="/admin/api/delete">
                                <input type="hidden" name="delete_id" value="<?php echo $post['id'] ?>" />
                                <input type="hidden" name="page_id" value="<?php echo $page ?>" />
                                <button class="cursor-pointer" type="submit"><i class="fa-solid fa-trash-can text-lg"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="w-full flex flex-col items-center">
        <div class="pagination py-3 flex flex-row">

            <!-- Previous -->
            <button
                class="flex flex-row gap-2 justify-center items-center px-3 py-1 rounded-lg cursor-pointer border-l border-gray-200"
                <?= $page == 1 ? "disabled" : "onclick=\"location.href='?page=" . ($page - 1) . "'\"" ?>>
                <i class="fa-solid fa-arrow-left"></i>
                <span class="hidden md:block">Previous</span>
            </button>

            <?php
            if ($totalPage <= 5) {
                // Show all pages
                for ($i = 1; $i <= $totalPage; $i++) {
                    $activeClass = ($page == $i) ? 'text-purple-600 font-bold' : 'text-black';
            ?>
                    <button class="flex flex-row gap-2 px-3 py-1 border border-gray-200 cursor-pointer <?= $activeClass ?>"
                        <?= $page == $i ? 'disabled' : "onclick=\"location.href='?page=$i'\"" ?>>
                        <?= $i ?>
                    </button>
                    <?php }
            } else {
                // Case 1: current page near start
                if ($page <= 3) {
                    for ($i = 1; $i <= 3; $i++) {
                        $activeClass = ($page == $i) ? 'text-purple-600 font-bold' : 'text-black';
                    ?>
                        <button class="flex flex-row gap-2 px-3 py-1 border border-gray-200 cursor-pointer <?= $activeClass ?>"
                            <?= $page == $i ? 'disabled' : "onclick=\"location.href='?page=$i'\"" ?>>
                            <?= $i ?>
                        </button>
                    <?php }
                    echo "<span class='px-2 border border-gray-200'>...</span>";
                    for ($i = $totalPage - 1; $i <= $totalPage; $i++) {
                        $activeClass = ($page == $i) ? 'text-purple-600 font-bold' : 'text-black';
                    ?>
                        <button class="flex flex-row gap-2 px-3 py-1 border border-gray-200 cursor-pointer <?= $activeClass ?>"
                            <?= $page == $i ? 'disabled' : "onclick=\"location.href='?page=$i'\"" ?>>
                            <?= $i ?>
                        </button>
                    <?php }
                }
                // Case 2: current page near end
                else if ($page >= $totalPage - 2) {
                    for ($i = 1; $i <= 2; $i++) {
                        $activeClass = ($page == $i) ? 'text-purple-600 font-bold' : 'text-black';
                    ?>
                        <button class="flex flex-row gap-2 px-3 py-1 border border-gray-200 cursor-pointer <?= $activeClass ?>"
                            <?= $page == $i ? 'disabled' : "onclick=\"location.href='?page=$i'\"" ?>>
                            <?= $i ?>
                        </button>
                    <?php }
                    echo "<span class='px-2 border border-gray-200'>...</span>";
                    for ($i = $totalPage - 2; $i <= $totalPage; $i++) {
                        $activeClass = ($page == $i) ? 'text-purple-600 font-bold' : 'text-black';
                    ?>
                        <button class="flex flex-row gap-2 px-3 py-1 border border-gray-200 cursor-pointer <?= $activeClass ?>"
                            <?= $page == $i ? 'disabled' : "onclick=\"location.href='?page=$i'\"" ?>>
                            <?= $i ?>
                        </button>
                    <?php }
                }
                // Case 3: current page in the middle
                else {
                    // First 2 pages
                    for ($i = 1; $i <= 2; $i++) {
                        $activeClass = ($page == $i) ? 'text-purple-600 font-bold' : 'text-black';
                    ?>
                        <button class="flex flex-row gap-2 px-3 py-1 border border-gray-200 cursor-pointer <?= $activeClass ?>"
                            <?= $page == $i ? 'disabled' : "onclick=\"location.href='?page=$i'\"" ?>>
                            <?= $i ?>
                        </button>
                    <?php }
                    echo "<span class='px-2 border border-gray-200'>...</span>";

                    // Current page
                    ?>
                    <button class="flex flex-row gap-2 px-3 py-1 border border-gray-200 cursor-pointer text-purple-600 font-bold" disabled>
                        <?= $page ?>
                    </button>
                    <span class='px-2 border border-gray-200'>...</span>

                    <!-- Last 2 pages -->
                    <?php
                    for ($i = $totalPage - 1; $i <= $totalPage; $i++) {
                        $activeClass = ($page == $i) ? 'text-purple-600 font-bold' : 'text-black';
                    ?>
                        <button class="flex flex-row gap-2 px-3 py-1 border border-gray-200 cursor-pointer <?= $activeClass ?>"
                            <?= $page == $i ? 'disabled' : "onclick=\"location.href='?page=$i'\"" ?>>
                            <?= $i ?>
                        </button>
            <?php }
                }
            }
            ?>

            <!-- Next -->
            <button
                class="flex flex-row gap-2 justify-center items-center px-3 py-1 rounded-lg cursor-pointer border-r border-gray-200"
                <?= $page == $totalPage ? "disabled" : "onclick=\"location.href='?page=" . ($page + 1) . "'\"" ?>>
                <span class="hidden md:block">Next</span>
                <i class="fa-solid fa-arrow-right"></i>
            </button>

        </div>
    </div>

</div>