<?php

# extract error data
$title = $_SESSION['error']['title'] ?? 'Error Title';
$message = $_SESSION['error']['message'] ?? 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellendus voluptatum mollitia dolorum non, magni illo ea nisi. Obcaecati illum minima eveniet quos nam maxime sed voluptas, odio tempore, accusamus velit?';
# clear session error vars
unset($_SESSION['error']);

?>
<div class="container w-full h-screen flex items-center justify-center">
    <div
        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div
                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg
                        aria-hidden="true"
                        stroke="currentColor"
                        stroke-width="1.5"
                        viewBox="0 0 24 24"
                        fill="none"
                        class="h-6 w-6 text-red-600">
                        <path
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                            stroke-linejoin="round"
                            stroke-linecap="round"></path>
                    </svg>
                </div>
                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                    <h3
                        id="modal-title"
                        class="text-base font-semibold leading-6 text-gray-900">
                        <?php echo $title ?>
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            <?php echo $message ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <a href="/">
                <button
                    class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                    type="button">
                    Back to Homepage
                </button>
            </a>
        </div>
    </div>
</div>