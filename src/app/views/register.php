<?php

use App\Models\Auth;

$key = 'register';
$csrfToken = Auth::generateCSRF($key);
?>

<div class="container w-full h-screen flex items-center justify-center">
    {{component:others.debugger}}
    <form id="registration-form" method="POST" action="/users/register" class="p-6 bg-slate-600 bg-opacity-95 flex flex-col w-full max-w-md rounded-xl">
        <input id="csrf_token_register" type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
        <input id="csrf_id_register" type="hidden" name="csrf_id" value="<?php echo htmlspecialchars($key); ?>">
        <div class="flex justify-start mb-6">
            <h2 class="text-3xl font-bold text-white">Register</h2>
            <p class="text-xs self-end text-white mt-4 ms-2">
                Already have an account?
                <a class="text-xs text-gray-900 -200 hover:underline mt-4" href="/users/login">Login</a>
            </p>
        </div>
        <div class="w-full my-2 flex items-center justify-between">
            <span class="relative">
                {{component:inputs.errorTooltip {"error":"firstname", "dir":"top"}}}
                <input
                    id="firstname"
                    class="max-w-[185px] bg-gray-700 text-gray-200 border-0 rounded-md p-2 shadow-md focus:outline-none focus:ring-1 transition ease-in-out duration-150"
                    type="text"
                    name="firstname"
                    placeholder="Firstname"
                    required>
            </span>
            <span class="relative">
                {{component:inputs.errorTooltip {"error":"lastname", "dir":"top"}}}
                <input
                    id="lastname"
                    class="max-w-[185px] bg-gray-700 text-gray-200 border-0 rounded-md p-2 shadow-md focus:outline-none focus:ring-1 transition ease-in-out duration-150"
                    type="text"
                    name="lastname"
                    placeholder="Lastname"
                    required>
            </span>
        </div>
        <span class="relative">
            {{component:inputs.errorTooltip {"error":"username", "dir":"right"}}}
            <input
                id="username"
                class="my-2 bg-gray-700 text-gray-200 border-0 rounded-md p-2 shadow-md focus:outline-none focus:ring-1 transition ease-in-out duration-150 w-full"
                type="text"
                name="username"
                placeholder="Username"
                required>
        </span>
        <span class="relative">
            {{component:inputs.errorTooltip {"error":"email", "dir":"right"}}}
            <input
                id="email"
                class="my-2 bg-gray-700 text-gray-200 border-0 rounded-md p-2 shadow-md focus:outline-none focus:ring-1 transition ease-in-out duration-150 w-full"
                type="email"
                name="email"
                placeholder="Email"
                required>
        </span>
        <span class="relative">
            {{component:inputs.errorTooltip {"error":"password", "dir":"right"}}}
            <input
                id="password"
                class="my-2 bg-gray-700 text-gray-200 border-0 rounded-md p-2 shadow-md focus:outline-none focus:ring-1 transition ease-in-out duration-150 w-full"
                type="password"
                name="password"
                placeholder="Password"
                required>
        </span>
        <span class="error-container">
            <input
                id="password_check"
                class="my-2 bg-gray-700 text-gray-200 border-0 rounded-md p-2 shadow-md focus:outline-none focus:ring-1 transition ease-in-out duration-150 w-full"
                type="password"
                name="password_check"
                placeholder="Confirm Password"
                required>
        </span>
        <span class="error-container">
            {{component:inputs.errorTooltip {"error":"birthdate", "dir":"right"}}}
            <input
                id="birthdate"
                class="my-2 bg-gray-700 text-gray-200 border-0 rounded-md p-2 shadow-md focus:outline-none focus:ring-1 transition ease-in-out duration-150 w-full"
                type="date"
                name="birthdate"
                placeholder="Birthdate"
                required>
        </span>

        <button
            type="submit"
            class="bg-gray-800 bg-opacity-85 text-white font-bold py-2 px-4 rounded-md mt-4 hover:bg-opacity-100 transition ease-in-out duration-150">
            Register
        </button>
    </form>
</div>