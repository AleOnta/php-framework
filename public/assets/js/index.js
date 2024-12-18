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