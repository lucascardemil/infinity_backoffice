export function redimensionarImagen(file, maxWidth = 1920, maxHeight = 1080, quality = 0.8) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();

        reader.onload = (event) => {
            const img = new Image();

            img.onload = () => {
                // Crear canvas
                const canvas = document.createElement('canvas');

                // Calcular proporciones manteniendo el aspecto
                let width = img.width;
                let height = img.height;

                if (width > maxWidth || height > maxHeight) {
                    const aspectRatio = width / height;
                    if (width / maxWidth > height / maxHeight) {
                        width = maxWidth;
                        height = Math.round(maxWidth / aspectRatio);
                    } else {
                        height = maxHeight;
                        width = Math.round(maxHeight * aspectRatio);
                    }
                }

                canvas.width = width;
                canvas.height = height;

                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                // Convertir a Blob (más eficiente que base64)
                canvas.toBlob(
                    (blob) => {
                        if (blob) {
                            resolve(blob);
                        } else {
                            reject(new Error("Error al convertir la imagen"));
                        }
                    },
                    'image/jpeg',
                    quality // entre 0 (más comprimido) y 1 (menos comprimido)
                );
            };

            img.onerror = (e) => reject(e);
            img.src = event.target.result;
        };

        reader.onerror = (e) => reject(e);
        reader.readAsDataURL(file);
    });
}