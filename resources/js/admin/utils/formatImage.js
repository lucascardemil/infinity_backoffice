export function formatImage(imageUrl) {
    return imageUrl.replace(/public\//g, 'storage/');
}
