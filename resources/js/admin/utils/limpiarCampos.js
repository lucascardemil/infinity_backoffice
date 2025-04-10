export function limpiarCampos(value) {

    if (typeof value === 'string' && value.length > 0) {
        return '';
    }

    // Si el valor es nulo o indefinido, retorna una cadena vacía
    if (value === null || value === '' || value === undefined) {
        return '';
    }

    // Si el valor es un número entero, lo convierte a 0
    if (Number.isInteger(value)) {
        return 0;
    }

    // Si el valor es un objeto, iteramos sobre sus propiedades
    if (typeof value === 'object' && value !== null) {
        for (let key in value) {
            if (value.hasOwnProperty(key)) {
                value[key] = limpiarCampos(value[key]); // Recursión para limpiar las propiedades
            }
        }
    }
}
