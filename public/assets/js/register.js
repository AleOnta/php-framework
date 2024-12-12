
const form = document.getElementById("registration-form");

window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('firstname').value = 'Alessandro';
    document.getElementById('lastname').value = 'Ontani';
    document.getElementById('username').value = 'aontani!';
    document.getElementById('email').value = 'aontani@gmail.com';
    document.getElementById('password').value = 'pswwwwwww';
    document.getElementById('password_check').value = 'pswwwwwww';
    document.getElementById('birthdate').value = '1999-01-11';
})

form.addEventListener('submit', async (event) => {
    event.preventDefault();
    
    let json = {};
    const formData = new FormData(form);
    formData.forEach((value, key) => {
        json[key] = value;
    });

    const res = await fetch("/users/register", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Custom-Header': 'custom-register-user'
        },
        body: JSON.stringify(json)
    });

    const data = await res.json();
    if (data?.status === false) {
        displayErrors(data.data.errors);
    } 

})

function displayErrors(errors) {
    errors = Object.entries(errors);
    errors.forEach(el => {
        let key = el[0];
        let msg = el[1];
        let input = document.getElementById(key);
        let errorTooltip = document.querySelector("[data-error='"+key+"']");
        let tooltipMessage = document.querySelector("[data-error-message='"+key+"']")
        
        if (input) {
            // set red border on input at error
            input.classList.add("border-2");
            input.classList.add("border-red-400");
        }
        
        if (tooltipMessage) {
            // set the error message
            tooltipMessage.textContent = msg;
        }
        
        if (errorTooltip) {
            // render the tooltip
            errorTooltip.classList.remove("hidden");
            errorTooltip.classList.add("flex");
        }
    });
}