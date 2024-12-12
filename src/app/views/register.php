{{component:navbar}}
<div class="container w-full h-screen flex items-center justify-center">
    <form id="registration-form" method="POST" action="/users/register" class="px-8 pt-8 pb-12 bg-slate-500 bg-opacity-95 flex flex-col w-4/12 rounded-xl">
        <div class="flex justify-start mb-6">
            <h2 class="text-3xl font-bold text-white">Register</h2>
            <a class="text-xs self-end ms-2 text-slate-300" href="/users/login">or login</a>
        </div>
        <div class="w-full my-2 flex items-center justify-between">
            <span class="relative">
                {{component:inputs.errorTooltip {"error":"firstname", "dir":"top"}}}
                <input
                    id="firstname"
                    class="p-3 bg-gray-700 bg-opacity-95 text-white rounded-lg shadow-md"
                    type="text"
                    name="firstname"
                    placeholder="Firstname"
                    required>
            </span>
            <span class="relative">
                {{component:inputs.errorTooltip {"error":"lastname", "dir":"top"}}}
                <input
                    id="lastname"
                    class="p-3 bg-gray-700 bg-opacity-95 text-white rounded-lg shadow-md"
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
                class="p-3 my-2 bg-gray-700 bg-opacity-95 text-white rounded-lg shadow-md w-full"
                type="text"
                name="username"
                placeholder="Username"
                required>
        </span>
        <span class="relative">
            {{component:inputs.errorTooltip {"error":"email", "dir":"right"}}}
            <input
                id="email"
                class="p-3 my-2 bg-gray-700 bg-opacity-95 text-white rounded-lg shadow-md w-full"
                type="email"
                name="email"
                placeholder="Email"
                required>
        </span>
        <span class="relative">
            {{component:inputs.errorTooltip {"error":"password", "dir":"right"}}}
            <input
                id="password"
                class="p-3 my-2 bg-gray-700 bg-opacity-95 text-white rounded-lg shadow-md w-full"
                type="password"
                name="password"
                placeholder="Password"
                required>
        </span>
        <span class="error-container">
            {{component:inputs.errorTooltip {"error":"password_check", "dir":"right"}}}
            <input
                id="password_check"
                class="p-3 my-2 bg-gray-700 bg-opacity-95 text-white rounded-lg shadow-md w-full"
                type="password"
                name="password"
                placeholder="Confirm Password"
                required>
        </span>
        <span class="error-container">
            {{component:inputs.errorTooltip {"error":"birthdate", "dir":"right"}}}
            <input
                id="birthdate"
                class="p-3 my-2 bg-gray-700 bg-opacity-95 text-white rounded-lg shadow-md w-full"
                type="date"
                name="birthdate"
                placeholder="Birthdate"
                required>
        </span>

        <button
            type="submit"
            class="w-full px-6 py-2 mt-4 font-semibold text-center text-slate-200 align-middle transition-all rounded-lg cursor-pointer bg-gray-700 bg-opacity-95 leading-pro text-base ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-105 hover:text-white hover:bg-slate-700 hover:shadow-lg active:opacity-85">
            Register
        </button>
    </form>
</div>