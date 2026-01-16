function validarFormulario() {
    let nombre = document.querySelector('[name="nombre"]').value;
    let email = document.querySelector('[name="email"]').value;
    let area = document.querySelector('[name="area_id"]').value;
    let roles = document.querySelectorAll('[name="roles[]"]:checked');

    if (!/^[a-zA-Z\s]+$/.test(nombre)) {
        alert("Nombre inválido");
        return false;
    }

    if (!email.includes("@")) {
        alert("Email inválido");
        return false;
    }

    if (area === "") {
        alert("Seleccione un área");
        return false;
    }

    if (roles.length === 0) {
        alert("Debe seleccionar al menos un rol");
        return false;
    }

    return true;
}
