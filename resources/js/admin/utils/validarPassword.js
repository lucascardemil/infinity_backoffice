export function validarPassword(password, password_confirmation) {
    let error_password = {};

    if (password.length > 0) {
        if (password.length < 8) {
            error_password.password = "La Contraseña tiene que tener más de 8 caracteres";
        } else if (password.length > 15) {
            error_password.password = "La Contraseña tiene que tener menos de 15 caracteres";
        } else if (!/[0-9]/.test(password) || !/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            error_password.password = "La Contraseña debe contener al menos un número y un símbolo";
        } else if (password !== password_confirmation) {
            error_password.password = "Las contraseñas deben ser iguales";
            error_password.password_confirmation = "Las contraseñas deben ser iguales";
        }
    }
    return Object.keys(error_password).length > 0 ? error_password : null;
}
