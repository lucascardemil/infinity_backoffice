export function formatoMiles(valor) {
    if (typeof valor !== 'number') {
        valor = Number(valor);
        if (isNaN(valor)) return '';
    }
    return valor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}