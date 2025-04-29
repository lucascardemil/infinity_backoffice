export function formatoMiles(valor) {
    if (typeof valor !== 'number') {
        valor = Number(valor);
        if (isNaN(valor)) return '';
    }
    return new Intl.NumberFormat('es-ES').format(valor);
}