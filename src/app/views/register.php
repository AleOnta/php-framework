{{component:navbar}}
<div class="container w-full h-screen flex items-center justify-center">
    <form id="registration-form" method="POST" action="/users/register" class="px-8 py-8 bg-gray-800 bg-opacity-95 flex flex-col w-4/12 rounded-xl">
        <h2 class="text-3xl mb-6 text-white">Register</h2>
        <div class="w-full mb-3 flex items-center justify-between">
            <input class="p-3 bg-slate-600 text-white rounded-lg shadow-md" type="text" name="firstname" placeholder="Firstname" required>
            <input class="p-3 bg-slate-600 text-white rounded-lg shadow-md" type="text" name="lastname" placeholder="Lastname" required>
        </div>
        <input class="p-3 mb-3 bg-slate-600 text-white rounded-lg shadow-md" type="text" name="username" placeholder="Username" required>
        <input class="p-3 mb-3 bg-slate-600 text-white rounded-lg shadow-md" type="email" name="email" placeholder="Email" required>
        <input class="p-3 mb-3 bg-slate-600 text-white rounded-lg shadow-md" type="password" name="password" placeholder="Password" required>
        <input class="p-3 mb-3 bg-slate-600 text-white rounded-lg shadow-md" type="password" name="password" placeholder="Confirm Password" required>
        <input class="p-3 mb-3 bg-slate-600 text-white rounded-lg shadow-md" type="date" name="birthdate" placeholder="Birthdate" required>
        <button type="submit" class="w-full px-6 py-2 mt-4 font-semibold text-center text-slate-200 align-middle transition-all rounded-lg cursor-pointer bg-slate-600 leading-pro text-base ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-105 hover:text-white hover:bg-slate-700 hover:shadow-lg active:opacity-85">Register</button>
    </form>
</div>