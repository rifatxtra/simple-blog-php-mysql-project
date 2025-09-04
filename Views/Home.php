<div class="w-full flex flex-col items-center">
    <?php
    if (count($posts) > 0) {
    ?>
        <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($posts as $post) {
            ?>
                <div class="post-div flex flex-col gap-2 p-4 ">
                    <img onclick="location.href='/blog/<?php echo $post['id']; ?>'" src="<?php echo '/uploads/' . $post['image']; ?>" alt="Blog Image Error" class="h-[240px] w-[336px] object-cover rounded-lg cursor-pointer" />

                    <div onclick="location.href='/blog/<?php echo $post['id']; ?>'" class="flex flex-row gap-3 items-top text-black hover:text-purple-500 cursor-pointer">
                        <h1 class="text-wrap font-bold">
                            <?php echo $post['title']; ?>
                        </h1>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </div>

                    <p class="w-[300px] overflow-hidden short-description">
                        <?php echo $post['description']; ?>
                    </p>
                    <div class="flex flex-col items-center justify-center">
                        <button onclick="location.href='/blog/<?php echo $post['id']; ?>'" class="bg-purple-500 p-2 rounded-md text-white cursor-pointer">Read More</button>
                    </div>
                </div>
            <?php
            } ?>
        </div>
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
                    $activeClass = ($page == $i) ? 'text-[#7F56D9] font-bold' : 'text-black';
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
                        $activeClass = ($page == $i) ? 'text-[#7F56D9] font-bold' : 'text-black';
                    ?>
                        <button class="flex flex-row gap-2 px-3 py-1 border border-gray-200 cursor-pointer <?= $activeClass ?>"
                            <?= $page == $i ? 'disabled' : "onclick=\"location.href='?page=$i'\"" ?>>
                            <?= $i ?>
                        </button>
                    <?php }
                    echo "<span class='px-2 border border-gray-200'>...</span>";
                    for ($i = $totalPage - 1; $i <= $totalPage; $i++) {
                        $activeClass = ($page == $i) ? 'text-[#7F56D9] font-bold' : 'text-black';
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
                        $activeClass = ($page == $i) ? 'text-[#7F56D9] font-bold' : 'text-black';
                    ?>
                        <button class="flex flex-row gap-2 px-3 py-1 border border-gray-200 cursor-pointer <?= $activeClass ?>"
                            <?= $page == $i ? 'disabled' : "onclick=\"location.href='?page=$i'\"" ?>>
                            <?= $i ?>
                        </button>
                    <?php }
                    echo "<span class='px-2 border border-gray-200'>...</span>";
                    for ($i = $totalPage - 2; $i <= $totalPage; $i++) {
                        $activeClass = ($page == $i) ? 'text-[#7F56D9] font-bold' : 'text-black';
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
                        $activeClass = ($page == $i) ? 'text-[#7F56D9] font-bold' : 'text-black';
                    ?>
                        <button class="flex flex-row gap-2 px-3 py-1 border border-gray-200 cursor-pointer <?= $activeClass ?>"
                            <?= $page == $i ? 'disabled' : "onclick=\"location.href='?page=$i'\"" ?>>
                            <?= $i ?>
                        </button>
                    <?php }
                    echo "<span class='px-2 border border-gray-200'>...</span>";

                    // Current page
                    ?>
                    <button class="flex flex-row gap-2 px-3 py-1 border border-gray-200 cursor-pointer text-[#7F56D9] font-bold" disabled>
                        <?= $page ?>
                    </button>
                    <span class='px-2 border border-gray-200'>...</span>

                    <!-- Last 2 pages -->
                    <?php
                    for ($i = $totalPage - 1; $i <= $totalPage; $i++) {
                        $activeClass = ($page == $i) ? 'text-[#7F56D9] font-bold' : 'text-black';
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


    <?php
    } else {
        echo "<p>No Post Available</p>";
    }
    ?>
</div>