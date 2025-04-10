export function formatRUT(rut) {
	// Eliminar caracteres no numéricos
    const rutLimpio = rut.replace(/[^\dKk]/g, '');
    const longitud = rutLimpio.length;

    // Verificar longitud mínima
    if (longitud < 2) {
        return rut;
    }

    // Separar número y dígito verificador
    const numero = rutLimpio.slice(0, -1);
    const digitoVerificador = rutLimpio.slice(-1).toUpperCase();

    // Formatear número
    const numeroFormateado = numero.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    return `${numeroFormateado}-${digitoVerificador}`;
}
