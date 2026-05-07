const passwordInput = document.getElementById("password");
const passwordConfirmInput = document.getElementById("passwordConfirm");
const submitBtn = document.getElementById("submitBtn");
const formAction = document.getElementById("formAction").value; // "create" o "update"

document.addEventListener("input", function () {
    const value = passwordInput.value;
    const confirmValue = passwordConfirmInput.value;

    // Validaciones
    const lengthValid = value.length >= 8;
    const uppercaseValid = /[A-Z]/.test(value);
    const lowercaseValid = /[a-z]/.test(value);
    const numberValid = /\d/.test(value);
    const specialValid = /[\W_]/.test(value);

    // Actualizar mensajes
    document.getElementById("length").className = lengthValid ? "valid" : "invalid";
    document.getElementById("uppercase").className = uppercaseValid ? "valid" : "invalid";
    document.getElementById("lowercase").className = lowercaseValid ? "valid" : "invalid";
    document.getElementById("number").className = numberValid ? "valid" : "invalid";
    document.getElementById("special").className = specialValid ? "valid" : "invalid";
    const confirmValid = value !== "" && value === confirmValue;

    if (formAction === "create") {
        // En creación: todas las reglas obligatorias
        submitBtn.disabled = !(lengthValid && uppercaseValid && lowercaseValid && numberValid && specialValid && confirmValid);
    } else {
        // En actualización: solo validar si el usuario escribe algo
        if (value === "" && confirmValue === "") {
            submitBtn.disabled = false; // permite actualizar sin cambiar contraseña
        } else {
            submitBtn.disabled = !(lengthValid && uppercaseValid && lowercaseValid && numberValid && specialValid && confirmValid);
        }
    }

});

// Mostras la contraseña mediante un boton en creacion y actualización de usuario
function toggleConfirmPassword() {
    const icono = document.getElementById("icono1");

    if (passwordConfirmInput.type === "password") {
        passwordConfirmInput.type = "text";
        passwordConfirmInput.placeholder = "Ingrese Contraseña";
        icono.innerHTML = '<i class="fa-regular fa-eye"></i>'; // ojo abierto
    } else {
        passwordConfirmInput.type = "password";
        passwordConfirmInput.placeholder = "********";
        icono.innerHTML = '<i class="fa-regular fa-eye-slash"></i>'; // ojo cerrado
    }
}

// Mostras la contraseña mediante un boton en creacion, actualización de usuario e inicio de session 
function togglePassword() {
    const input = document.getElementById("password");
    const icono = document.getElementById("icono");

    if (input.type === "password") {
        input.type = "text";
        input.placeholder = "Ingrese Contraseña";
        icono.innerHTML = '<i class="fa-regular fa-eye"></i>'; // ojo abierto
    } else {
        input.type = "password";
        input.placeholder = "********";
        icono.innerHTML = '<i class="fa-regular fa-eye-slash"></i>'; // ojo cerrado
    }
}

//Mostrar los requerimientos de la contraseña en creacion y actualización de usuario
document.addEventListener("DOMContentLoaded", () => {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
});