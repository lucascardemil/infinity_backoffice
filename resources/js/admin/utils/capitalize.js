export function capitalize(value) {
    if (!value) { // Verifica si el valor está vacío o es nulo
        return value; // Devuelve el valor tal cual si está vacío o nulo
    }

    return value
        .toLowerCase()
        .split(' ')
        .map(palabra => palabra.charAt(0).toUpperCase() + palabra.slice(1))
        .join(' ');
}
