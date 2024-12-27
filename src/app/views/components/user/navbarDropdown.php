<?php

use App\Models\Auth;

if (auth()->check()) {
    $key = 'logout';
    $logoutToken = Auth::generateCSRF($key);
}
?>
<div id="user-dropdown" class="hidden items-center justify-center bg-gray-100 rounded-md absolute right-1 top-16">
    <div
        class="w-full max-w-xs rounded-lg bg-white p-3 drop-shadow-xl divide-y divide-gray-200">
        <div aria-label="header" class="flex space-x-4 items-center p-4">
            <div aria-label="avatar" class="flex mr-auto items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-gray-800 flex justify-center items-center">
                    <?php if (!auth()->check()): ?>
                        <p class="m-0">?</p>
                    <?php else: ?>
                        <p class="m-0 text-base">
                            <?= substr(Auth::user()->getFirstName(), 0, 1) . substr(Auth::user()->getLastName(), 0, 1) ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="space-y-1 flex flex-col flex-1 truncate">
                    <div class="font-medium relative text-xl leading-tight text-gray-900">
                        <span class="flex">
                            <span class="truncate relative pr-8 text-lg">
                                <?php if (!auth()->check()): ?>
                                    No account
                                <?php else: ?>
                                    <?php echo Auth::user()->getFirstName() . ' ' . Auth::user()->getLastName() ?>
                                    <span
                                        aria-label="verified"
                                        class="absolute top-1/2 -translate-y-1/2 right-0 inline-block rounded-full">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            aria-hidden="true"
                                            class="w-5 h-5 ml-1 text-cyan-400"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M12.01 2.011a3.2 3.2 0 0 1 2.113 .797l.154 .145l.698 .698a1.2 1.2 0 0 0 .71 .341l.135 .008h1a3.2 3.2 0 0 1 3.195 3.018l.005 .182v1c0 .27 .092 .533 .258 .743l.09 .1l.697 .698a3.2 3.2 0 0 1 .147 4.382l-.145 .154l-.698 .698a1.2 1.2 0 0 0 -.341 .71l-.008 .135v1a3.2 3.2 0 0 1 -3.018 3.195l-.182 .005h-1a1.2 1.2 0 0 0 -.743 .258l-.1 .09l-.698 .697a3.2 3.2 0 0 1 -4.382 .147l-.154 -.145l-.698 -.698a1.2 1.2 0 0 0 -.71 -.341l-.135 -.008h-1a3.2 3.2 0 0 1 -3.195 -3.018l-.005 -.182v-1a1.2 1.2 0 0 0 -.258 -.743l-.09 -.1l-.697 -.698a3.2 3.2 0 0 1 -.147 -4.382l.145 -.154l.698 -.698a1.2 1.2 0 0 0 .341 -.71l.008 -.135v-1l.005 -.182a3.2 3.2 0 0 1 3.013 -3.013l.182 -.005h1a1.2 1.2 0 0 0 .743 -.258l.1 -.09l.698 -.697a3.2 3.2 0 0 1 2.269 -.944zm3.697 7.282a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z"
                                                stroke-width="0"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                <?php endif; ?>
                            </span>
                        </span>
                    </div>
                    <?php if (auth()->check()): ?>
                        <p class="font-normal text-base leading-tight text-gray-500 truncate">
                            <?php echo htmlspecialchars(Auth::user()->getEmail()) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div aria-label="navigation" class="py-2">
            <nav class="grid gap-1">
                <?php if (!auth()->check()): ?>
                    <a
                        href="/users/register"
                        class="flex items-center leading-6 space-x-3 py-3 px-4 w-full text-base text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                            class="w-6 h-6"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                        </svg>
                        <span>Create Account</span>
                    </a>
                    <a
                        href="/users/login"
                        class="flex items-center leading-6 space-x-3 py-3 px-4 w-full text-base text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                            class="w-6 h-6"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M9.785 6l8.215 8.215l-2.054 2.054a5.81 5.81 0 1 1 -8.215 -8.215l2.054 -2.054z"></path>
                            <path d="M4 20l3.5 -3.5"></path>
                            <path d="M15 4l-3.5 3.5"></path>
                            <path d="M20 9l-3.5 3.5"></path>
                        </svg>
                        <span>Login</span>
                    </a>
                <?php else: ?>
                    <a
                        href="/"
                        class="flex items-center leading-6 space-x-3 py-3 px-4 w-full text-base text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                            class="w-6 h-6"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                        </svg>
                        <span>Account Settings</span>
                    </a>
                    <a
                        href="/"
                        class="flex items-center leading-6 space-x-3 py-3 px-4 w-full text-base text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                            class="w-6 h-6"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M9.785 6l8.215 8.215l-2.054 2.054a5.81 5.81 0 1 1 -8.215 -8.215l2.054 -2.054z"></path>
                            <path d="M4 20l3.5 -3.5"></path>
                            <path d="M15 4l-3.5 3.5"></path>
                            <path d="M20 9l-3.5 3.5"></path>
                        </svg>
                        <span>Integrations</span>
                    </a>
                    <a
                        href="/"
                        class="flex items-center leading-6 space-x-3 py-3 px-4 w-full text-base text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                            class="w-6 h-6"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                        </svg>
                        <span>Settings</span>
                    </a>
                    <a
                        href="/"
                        class="flex items-center leading-6 space-x-3 py-3 px-4 w-full text-base text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                            class="w-6 h-6"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                            <path
                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                            <path d="M9 17h6"></path>
                            <path d="M9 13h6"></path>
                        </svg>
                        <span>Guide</span>
                    </a>
                    <a
                        href="/"
                        class="flex items-center leading-6 space-x-3 py-3 px-4 w-full text-base text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                            class="w-6 h-6"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z"></path>
                            <path d="M12 16v.01"></path>
                            <path
                                d="M12 13a2 2 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483"></path>
                        </svg>
                        <span>Helper Center</span>
                    </a>
                <?php endif; ?>

            </nav>
        </div>
        <?php if (auth()->check()): ?>
            <form id="logout" action="/users/logout" method="POST" class="pt-2">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($logoutToken, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="csrf_token_id" value="<?php echo htmlspecialchars($key); ?>">
                <button
                    type="submit"
                    class="flex items-center space-x-3 py-3 px-4 w-full leading-6 text-base text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                        class="w-6 h-6"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path
                            d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                        <path d="M9 12h12l-3 -3"></path>
                        <path d="M18 15l3 -3"></path>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>