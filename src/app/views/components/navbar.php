<?php

use App\Models\Auth; ?>

<div class="w-full fixed top-0 left-0 right-0 text-black">
    <nav class="flex px-4 border-b shadow-lg items-center bg-white p-4 md:p-4">
        <div class="text-base md:text-lg font-bold py-0">
            PHP Framework
        </div>
        <ul class="px-2 ml-auto flex items-center space-x-2 top-full left-0 right-0 text-sm">
            <li>
                <a href="#" class="inline-flex items-center sm:px-3 hover:bg-gray-50">
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="#" class="inline-flex items-center sm:px-3 hover:bg-gray-50">
                    <span>Products</span>
                </a>
            </li>
            <li>
                <a href="#" class="inline-flex items-center sm:px-3 hover:bg-gray-50">
                    <span>About us</span>
                </a>
            </li>
            <li>
                <div id="user-dropdown-btn" class="bg-slate-800 text-white font-semibold rounded-full w-8 h-8 flex justify-center items-center cursor-pointer">
                    <?php if (Auth::check()): ?>
                        <p class="m-0">
                            <?= substr(Auth::user()['firstname'], 0, 1) . substr(Auth::user()['lastname'], 0, 1) ?>
                        </p>
                        {{component:user.navbarDropdown}}
                    <?php else: ?>
                        <p class="m-0">?</p>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
    </nav>
</div>