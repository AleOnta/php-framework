<?php

$styles = $dir == 'top'
    ? '-top-4 group-hover:-translate-y-5'
    : '-right-64 bottom-0 top-0 my-auto group-hover:translate-x-8';

?>

<section
    class="error hidden absolute right-1 top-0 bottom-0 my-auto" data-error="<?= $error ?>">
    <div class="relative flex justify-center items-center">
        <div
            class="group flex justify-center transition-all rounded-full bg-red-300 bg-opacity-40 p-1 cursor-pointer">
            <svg
                viewBox="0 0 320 512"
                class="w-3 h-3">
                <path
                    fill="#7f1d1d"
                    d="M80 160c0-35.3 28.7-64 64-64h32c35.3 0 64 28.7 64 64v3.6c0 21.8-11.1 42.1-29.4 
                    53.8l-42.2 27.1c-25.2 16.2-40.4 44.1-40.4 74V320c0 17.7 14.3 32 32 32s32-14.3 
                    32-32v-1.4c0-8.2 4.2-15.8 11-20.2l42.2-27.1c36.6-23.6 58.8-64.1 
                    58.8-107.7V160c0-70.7-57.3-128-128-128H144C73.3 32 16 89.3 16 160c0 17.7 14.3 32 
                    32 32s32-14.3 32-32zm80 320a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"></path>
            </svg>
            <span
                class="absolute text-nowrap opacity-0 flex items-center justify-center p-2 
              bg-red-100 bg-opacity-50 rounded-lg <?= $styles ?> group-hover:opacity-100 
                duration-500 text-sm text-red-700"
                data-error-message="<?= $error ?>">
            </span>
        </div>
    </div>
</section>