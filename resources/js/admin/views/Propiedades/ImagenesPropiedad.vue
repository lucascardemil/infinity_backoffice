<template>
    <div class="upload-container">
        <!-- Área de arrastrar y soltar -->
        <div class="drop-area" @dragover.prevent @drop="onDrop" @click="abrirSelector">
            <h5 class="file-label text-white mb-0">
                Arrastra imágenes aquí o Selecciona un archivo
            </h5>
            <input type="file" ref="fileInput" @change="onFileChange" multiple accept="image/*" hidden />
        </div>

        <!-- Lista de imágenes arrastrables -->
        <draggable v-model="propiedad.imagenes" class="imagenes-container" v-if="!loading_redimensionar">
            <div v-for="imagen in propiedad.imagenes" :key="imagen.id" class="image-container">
                <LoadingComponent v-if="loading_eliminar_imagen === imagen.id" style="width: 150px;" />
                <img v-else :src="imagen.url ?? imagen.ruta_imagen" class="vista-previa-propiedad"
                    :class="{ principal: imagen.principal }" @click="seleccionarPrincipal(imagen.id)" />
                <button type="button" class="btn-close-eliminar"
                    @click="eliminarImagen(imagen.id, imagen.ruta_imagen)"></button>
            </div>
            <p class="fw-bolder text-white">* Haga click en la imagen para marcarla como principal</p>
        </draggable>
        <div v-else class="mt-3">
            <LoadingComponent />
        </div>

        <div class="alert alert-danger" v-if="error_imagen_principal" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> Debe seleccionar una imagen principal
        </div>

        <div class="alert alert-danger" v-if="error_total_imagenes" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> Debe subir al menos una imagen
        </div>
    </div>
</template>

<script>
import propiedadMixin from '../../mixins/propiedad/servicesPropiedadMixin';
import LoadingComponent from '../../components/LoadingComponent.vue';
import { redimensionarImagen } from '../../utils/redimensionarImagen';

export default {
    mixins: [propiedadMixin],
    props: {
        propiedad: Object,
    },
    components: {
        LoadingComponent,
    },
    data() {
        return {
            error_total_imagenes: false,
            error_imagen_principal: false,
            loading_redimensionar: false,
        };
    },
    watch: {
        propiedad: {
            handler() {
                if (this.propiedad.imagenes && this.propiedad.imagenes.length > 0) {
                    this.error_total_imagenes = false;
                    this.error_imagen_principal = !this.propiedad.imagenes.some(imagen => imagen.principal);
                } else {
                    this.error_imagen_principal = true;
                    this.error_total_imagenes = true;
                }
            },
            deep: true
        }

    },
    methods: {
        //Imagenes
        async onFileChange(event) {
            const files = Array.from(event.target.files);
            const resizedImages = [];
            this.loading_redimensionar = true; // Inicia el estado de carga

            try {
                for (const file of files) {
                    try {
                        const resizedBlob = await redimensionarImagen(file);
                        resizedImages.push(new File([resizedBlob], file.name, { type: file.type }));
                    } catch (error) {
                        console.error(`Error al procesar ${file.name}:`, error);
                    }
                }

                this.agregarImagenes(resizedImages);
            } finally {
                this.loading_redimensionar = false; // Finaliza el estado de carga
                event.target.value = ''; 
            }
        },
        onDrop(event) {
            event.preventDefault();
            this.agregarImagenes(event.dataTransfer.files);
        },
        abrirSelector() {
            this.$refs.fileInput.click();
        },
        agregarImagenes(archivos) {
            for (let archivo of archivos) {
                const url = URL.createObjectURL(archivo);
                this.propiedad.imagenes.push({ id: Date.now() + Math.random(), url, archivo, principal: false });
            }
        },
        async seleccionarPrincipal(id) {
            this.propiedad.imagenes.forEach(imagen => {
                imagen.principal = imagen.id === id;
            });
            await this.actualizarImagenPrincipal(this.propiedad.imagenes);
        },
        async eliminarImagen(id, ruta_imagen) {
            await this.eliminarImagenPropiedad(id, ruta_imagen);
            this.propiedad.imagenes = this.propiedad.imagenes.filter(imagen => imagen.id !== id);
            this.$emit('imagenes-eliminadas');
        },
    }
};
</script>