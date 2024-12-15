// vars for users registration or login
let context = window.location.href.replace('http://localhost:8000','');
let formId = context === '/users/register' ? 'registration-form' : 'login-form';
let form = document.getElementById(formId);

if (context === '/users/register') {
    form.addEventListener('submit', (e) => register(e))
} 

if (context === '/users/login') {
    form.addEventListener('submit', (e) => login(e))
    form = form.elements;
}

async function register(event) {
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
        let errors = data.data?.errors;
        displayErrors(errors);
    }
}

async function login(event) {
    event.preventDefault();

    // define constant for csrf token validation on server side
    const csrfToken = document.querySelector('#csrf_token_login').value;
    const csrfTokenId = document.querySelector('#csrf_id_login').value

    let json = {
        'email':form.item(2).value,
        'password':form.item(3).value
    };
    
    const res = await fetch("/users/login", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Custom-Header': 'login-user',
            'X-CSRF-Token': csrfToken,
            'X-CSRF-Token-Id': csrfTokenId
        },
        body: JSON.stringify(json)
    });

    const data = await res.json();
    if (data?.status === false) {
        // set error message into paragraph
        document.getElementById('login-error').textContent = data.data.message
        // render the error message
        let alert = document.getElementById('login-error-container');
        alert.classList.remove('hidden');
        alert.classList.add('flex');
    }

    if (data?.status) {
        window.location.href = '/';
    }
}

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