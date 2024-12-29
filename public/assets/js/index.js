let dropdownState = false;
let dropdownToggle = document.getElementById('user-dropdown-btn');
let dropdown = document.getElementById('user-dropdown');

function toggleUserDropdown() {
    dropdownState = !dropdownState;
    if (dropdownState === true) {
        dropdown.classList.remove('hidden');
        dropdown.classList.add('flex');
    } 

    if (dropdownState === false) {
        dropdown.classList.remove('flex');
        dropdown.classList.add('hidden');
    }
}

document.addEventListener('click', function (e) {
    if (e.target.closest('#user-dropdown-btn')) {
        toggleUserDropdown();
    }
});

// retrieve migrations runner form
let migrationsForm = document.getElementById('migrations-run-form');
// add eventlistener on submit    
migrationsForm.addEventListener('submit', (event) => requestMigrationsRun(event));
// trig migration runner
async function requestMigrationsRun(event) {
    event.preventDefault();
    // request to execute migrations
    const res = await fetch('/migrations/up', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Custom-Header': 'custom-run-migrations',
            'X-CSRF-Token': document.getElementById('csrf_token').value,
            'X-CSRF-Token-Id': document.getElementById('csrf_token_id').value
        }
    });
    // parse response
    let data = await res.json();
    if (data?.status === false) {
        alert('Error in request - message \n', data?.data.message);
    } else {
        window.location.href = 'http://localhost:8000/migrations';
    }
}