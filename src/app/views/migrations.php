<?php

use App\Models\Auth;

$key = 'migrations_up';
$csrfToken = Auth::generateCSRF($key);
$ranMigrations = $data['ok_migrations'] ?? [];
$toRunMigrations = $data['to_run_migrations'] ?? [];

$runnable = count($toRunMigrations) > 0;
$disabled = $runnable ? '' : 'disabled';
$disabledClasses = $runnable ? 'hover:bg-opacity-100 transition ease-in-out duration-150' : 'cursor-not-allowed opacity-60';

?>
<div class="container w-full h-screen flex items-center justify-center">
    <div>
        <div id="ran-migrations-container" class="p-6 bg-slate-600 bg-opacity-95 rounded-xl">
            <h2 class="text-xl mb-4 font-bold text-gray-950">Applied Migrations:</h2>
            <div class="grid grid-cols-6 gap-x-4 gap-y-3">
                <div class="col-span-1 text-base font-semibold text-gray-400">Execution Time</div>
                <div class="col-span-3 text-base font-semibold text-gray-400">Migration FileName</div>
                <div class="col-span-2 text-base font-semibold text-gray-400">Migration ClassName</div>
                <hr class="col-span-6">
                <?php foreach ($ranMigrations as $migration): ?>
                    <?php
                    echo "
                    <div class='col-span-1 text-sm'>{$migration['applied_at']}</div>
                    <div class='col-span-3 text-sm'>{$migration['migration']}</div>
                    <div class='col-span-2 text-sm'>{$migration['classname']}</div>
                    ";
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="to-run-migrations-container" class="mt-10 p-6 bg-slate-600 bg-opacity-95 rounded-xl">
            <div class="w-full flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-950">Migrations to Run:</h2>
                <form id="migrations-run-form" method="POST" action="/migrations/up">
                    <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                    <input id="csrf_token_id" type="hidden" name="csrf_token_id" value="<?php echo htmlspecialchars($key); ?>">
                    <button type="submit" class="bg-gray-800 bg-opacity-85 text-white font-bold py-2 px-4 rounded-md mt-4 <?php echo $disabledClasses ?>" <?php echo $disabled ?>>Run Migrations</button>
                </form>
            </div>
            <div class="grid grid-cols-5 gap-x-4 gap-y-3">
                <div class="col-span-3 text-base font-semibold text-gray-400">Migration FileName</div>
                <div class="col-span-2 text-base font-semibold text-gray-400">Migration ClassName</div>
                <hr class="col-span-5">
                <?php foreach ($toRunMigrations as $migration): ?>
                    <?php
                    echo "
                    <div class='col-span-3 text-sm'>{$migration['filename']}</div>
                    <div class='col-span-2 text-sm'>{$migration['classname']}</div>
                    ";
                    ?>
                <?php endforeach; ?>
                <?php if (!$runnable): ?>
                    <div class="col-span-5">No Migrations to run...</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>