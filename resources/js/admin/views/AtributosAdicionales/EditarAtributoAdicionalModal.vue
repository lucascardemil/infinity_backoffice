<template>
    <div class="modal fade" id="editarAtributoAdicionalModal" tabindex="-1"
        aria-labelledby="editarAtributoAdicionalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarAtributoAdicionalModalLabel"><i class="bi bi-pencil-square"></i>
                        Editar Atributo Adicional</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="formEditarAtributoAdicional">
                        <div class="mb-3">
                            <label for="atributo_adicional_editar_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="atributo_adicional_editar_nombre"
                                v-model="editarAtributoAdicional.nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="atributo_adicional_editar_imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="atributo_adicional_editar_imagen"
                                @change="subirImagenAtributoAdicional" accept=".png, .jpeg, .jpg"
                                ref="atributo_adicional_editar_imagen" aria-label="Imagen" required>
                        </div>
                        <LoadingComponent v-if="loading_imagen"></LoadingComponent>
                        <template v-else>
                            <div v-if="previewImage" class="mb-3 image-container">
                                <img :src="previewImage" alt="Vista Previa" class="img-fluid vista-previa" />
                                <button type="button" class="btn-close-eliminar" aria-label="Close"
                                    @click="eliminarImagenAtributo(url_imagen_cloudinary)"></button>
                            </div>
                        </template>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="atributo_adicional in errors.nombre">
                                {{ atributo_adicional }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="atributo_adicional in errors.imagen">
                                {{ atributo_adicional }}
                            </div>
                        </template>
                        <div class="d-grid gap-2 d-md-block">
                            <button type="submit" class="btn btn-base-dv" :disabled="loading">
                                <span v-if="loading">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Cargando...
                                </span>
                                <span v-else>Guardar Cambios</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import atributosAdicionalesMixin from '../../mixins/atributo_adicional/atributosAdicionalesMixin';
import { capitalize } from '../../utils/capitalize';
import { limpiarCampos } from '../../utils/limpiarCampos';
import LoadingComponent from '../../components/LoadingComponent.vue';

export default {
    mixins: [atributosAdicionalesMixin],
    components: {
        LoadingComponent
    },
    props: {
        atributo_adicional: Object
    },
    data() {
        return {
            editarAtributoAdicional: {
                nombre: '',
                imagen: [],
            },
            previewImage: null
        };
    },
    watch: {
        atributo_adicional: {
            immediate: true,
            handler(AtributoAdicional) {
                if (AtributoAdicional) {
                    this.editarAtributoAdicional.nombre = AtributoAdicional.nombre;
                    this.url_imagen_cloudinary = AtributoAdicional.ruta_imagen ? AtributoAdicional.ruta_imagen : null;
                    this.previewImage = this.url_imagen_cloudinary !== null ? this.url_imagen_cloudinary : null;
                }
            }
        },
        'editarAtributoAdicional.nombre': function (newValue) {
            this.editarAtributoAdicional.nombre = capitalize(newValue);
        }
    },
    methods: {
        open() {
            this.errors = null;
            limpiarCampos(this.editarAtributoAdicional);
            const modalElement = document.getElementById('editarAtributoAdicionalModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editarAtributoAdicionalModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        async subirImagenAtributoAdicional(event) {
            const archivo = event.target.files[0];  // Tomar solo el primer archivo
            this.errors = null;

            // Verificar si se seleccionó algún archivo
            if (!archivo) {
                this.errors = { imagen: ['No se ha seleccionado ninguna imagen.'] };
                return;
            }

            // Validación del tipo de archivo
            const tiposValidos = ['image/png', 'image/jpeg', 'image/jpg'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (!tiposValidos.includes(archivo.type) || archivo.size > maxSize) {
                this.errors = {
                    imagen: [
                        archivo.size > maxSize
                            ? 'El archivo excede el tamaño máximo permitido de 5MB.'
                            : 'Solo se permiten archivos PNG, JPEG o JPG.'
                    ]
                };
                return;
            }

            // Si pasa las validaciones, asignar el archivo a newUsuario
            this.editarAtributoAdicional.imagen = archivo;  // Asignar solo una imagen

            // Crear una vista previa de la imagen seleccionada
            const reader = new FileReader();
            reader.onload = () => {
                this.previewImage = reader.result;  // Guardar la URL de la imagen
            };
            reader.readAsDataURL(archivo);  // Tomar el archivo seleccionado
        },
        async formEditarAtributoAdicional() {
            const formData = new FormData();
            formData.append('id', this.atributo_adicional.id);
            formData.append('nombre', this.editarAtributoAdicional.nombre);

            // Verificar si hay una imagen seleccionada
            if (this.editarAtributoAdicional.imagen instanceof File) {
                formData.append('imagen', this.editarAtributoAdicional.imagen);
            }

            const response = await this.actualizarAtributoAdicional(formData);

            if (this.errors === null) {
                document.getElementById('atributo_adicional_editar_imagen').value = null;
                this.$notyf.success(response.message);
                this.$emit('atributo-adicional-updated');
                this.previewImage = null;
                this.close();
            }
        },
        async eliminarImagenAtributo(url_imagen_cloudinary) {
            const response = await this.eliminarImagen(url_imagen_cloudinary);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('atributo-adicional-updated');
                this.close();
            }
        }

    }
}
</script>

<style scoped></style>
