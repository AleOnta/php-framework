<?php

use App\Models\Auth;

$key = 'login';
$csrfToken = Auth::generateCSRF($key);
?>

<div class="flex flex-col items-center justify-center h-screen dark">
    <div class="w-full max-w-md bg-slate-600 bg-opacity-95 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-200">Login</h2>
            {{component:errorMessage}}
        </div>
        <form class="flex flex-col" id="login-form">
            <input id="csrf_token_login" type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
            <input id="csrf_id_login" type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($key); ?>">
            <input
                type="email"
                placeholder="Email address"
                class="bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:outline-none focus:ring-1 transition ease-in-out duration-150"
                required>
            <input
                type="password"
                placeholder="Password"
                class="bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:outline-none focus:ring-1 transition ease-in-out duration-150"
                required>
            <div class="flex items-center justify-between flex-wrap">
                <label class="text-sm text-gray-200 cursor-not-allowed" for="remember-me">
                    <input class="mr-2" id="remember-me" type="checkbox" disabled>
                    Remember me
                </label>
                <a class="text-sm text-gray-900 hover:underline mb-0.5" href="#">Forgot password?</a>
                <p class="text-sm text-white mt-4"> Don't have an account? <a class="text-sm text-gray-900 -200 hover:underline mt-4" href="/users/register">Signup</a></p>
            </div>
            <button class="bg-gray-800 bg-opacity-85 text-white font-bold py-2 px-4 rounded-md mt-4 hover:bg-opacity-100 transition ease-in-out duration-150" type="submit">Login</button>
        </form>
    </div>
</div>
{{component:others.debugger}}