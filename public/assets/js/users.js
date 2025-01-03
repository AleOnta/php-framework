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
        if (key === 'csrf_token' || key === 'csrf_id') {
            return;
        }
        json[key] = value;
    });

    const csrf = getCSRFTokens('register');
    const res = await fetch("/users/register", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Custom-Header': 'custom-register-user',
            'X-CSRF-Token': csrf.token,
            'X-CSRF-Token-Id': csrf.id
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

    console.log('login')
    // define constant for csrf token validation on server side
    const csrf = getCSRFTokens('login');

    let json = {
        'email':form.item(2).value,
        'password':form.item(3).value
    };
    
    const res = await fetch("/users/login", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Custom-Header': 'login-user',
            'X-CSRF-Token': csrf.token,
            'X-CSRF-Token-Id': csrf.id
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

function getCSRFTokens(label) {
    return {
        'id':document.getElementById('csrf_id_'+label).value,
        'token':document.getElementById('csrf_token_'+label).value
    };
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