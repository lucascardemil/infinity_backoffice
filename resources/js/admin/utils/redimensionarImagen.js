export function redimensionarImagen(file, size = 400, quality = 0.8) {
    return new Promise((resolve, reject) => {
        const validTypes = ['image/jpeg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            reject(new Error('Formato de archivo no válido. Debe ser JPG o PNG.'));
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            const img = new Image();
            img.onload = () => {
                // Crear canvas con dimensiones de 500x500
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = size;
                canvas.height = size;

                // Calcular el tamaño de la imagen escalada manteniendo la proporción
                const scale = Math.min(size / img.width, size / img.height);
                const scaledWidth = img.width * scale;
                const scaledHeight = img.height * scale;

                // Posicionar la imagen centrada en el canvas
                const xOffset = (canvas.width - scaledWidth) / 2;
                const yOffset = (canvas.height - scaledHeight) / 2;

                // Rellenar fondo (blanco) y dibujar imagen escalada
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, xOffset, yOffset, scaledWidth, scaledHeight);

                // Convertir canvas a Blob para reducir tamaño y calidad
                canvas.toBlob((blob) => {
                    if (blob) {
                        const resizedFile = new File([blob], file.name, { type: file.type });
                        resolve(resizedFile);
                    } else {
                        reject(new Error('Error al redimensionar la imagen.'));
                    }
                }, file.type, quality);
            };
            img.onerror = () => reject(new Error('Error al cargar la imagen.'));
            img.src = e.target.result;
        };
        reader.onerror = () => reject(new Error('Error al leer el archivo.'));
        reader.readAsDataURL(file);
    });
}