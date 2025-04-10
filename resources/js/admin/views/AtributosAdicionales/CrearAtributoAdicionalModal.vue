<template>
    <div class="modal fade" id="crearAtributoAdicionalModal" tabindex="-1"
        aria-labelledby="crearAtributoAdicionalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearAtributoAdicionalModalLabel">Crear Atributo Adicional</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="guardarAtributoAdicional">
                        <div class="mb-3">
                            <label for="atributo_adicional_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="atributo_adicional_nombre"
                                v-model="atributo_adicional.nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="atributo_adicional_imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="atributo_adicional_imagen"
                                @change="subirImagenAtributoAdicional" accept=".png, .jpeg, .jpg"
                                ref="atributo_adicional_imagen" aria-label="Imagen" required>
                        </div>
                        <div v-if="previewImage" class="mb-3">
                            <img :src="previewImage" alt="Vista Previa" class="img-fluid vista-previa" />
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="atributo_adicional in errors.nombre">
                                {{ atributo_adicional }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="atributo_adicional in errors.imagen">
                                {{ atributo_adicional }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="loading">
                            <span v-if="loading">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Cargando...
                            </span>
                            <span v-else>Guardar Cambios</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import atributosAdicionalesMixin from '../../mixins/atributo_adicional/atributosAdicionalesMixin';
import { limpiarCampos } from '../../utils/limpiarCampos';
import { capitalize } from '../../utils/capitalize';

export default {
    mixins: [atributosAdicionalesMixin],
    data() {
        return {
            atributo_adicional: {
                nombre: '',
                imagen: [],
            },
            previewImage: null
        };
    },
    watch: {
        'atributo_adicional.nombre': function (newValue) {
            this.atributo_adicional.nombre = capitalize(newValue);
        }
    },
    methods: {
        open() {
            limpiarCampos(this.atributo_adicional);
            this.errors = null;
            const modalElement = document.getElementById('crearAtributoAdicionalModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearAtributoAdicionalModal');
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
            this.atributo_adicional.imagen = archivo;  // Asignar solo una imagen

            // Crear una vista previa de la imagen seleccionada
            const reader = new FileReader();
            reader.onload = () => {
                this.previewImage = reader.result;  // Guardar la URL de la imagen
            };
            reader.readAsDataURL(archivo);  // Tomar el archivo seleccionado
        },

        async guardarAtributoAdicional() {
            const formData = new FormData();
            formData.append('nombre', this.atributo_adicional.nombre);

            if (this.atributo_adicional.imagen) {
                formData.append('imagen', this.atributo_adicional.imagen);  // Agregar solo la imagen
            }

            const response = await this.crearAtributoAdicional(formData);

            if (this.errors === null) {
                document.getElementById('atributo_adicional_imagen').value = null;
                this.$notyf.success(response.message);
                limpiarCampos(this.atributo_adicional);
                this.$emit('atributo-adicional-updated');
                this.previewImage = null;
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
