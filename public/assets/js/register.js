
const form = document.getElementById("registration-form");

form.addEventListener('submit', async (event) => {
    event.preventDefault();
    const formData = new FormData(form);
    let json = {};
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

})
