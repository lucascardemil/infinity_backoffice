<template>
    <div class="modal fade" id="editUsuarioModal" tabindex="-1" aria-labelledby="editUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUsuarioModalLabel"><i class="bi bi-pencil-square"></i> Editar
                        Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editEditUsuario" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="editUsuarioNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editUsuarioNombre" v-model="editUsuario.name"
                                :class="errors ? errors.name ? 'is-invalid' : '' : ''" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUsuarioEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editUsuarioEmail" v-model="editUsuario.email"
                                :class="errors ? errors.email ? 'is-invalid' : '' : ''" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUsuarioCelular" class="form-label">Celular</label>
                            <input type="celular" class="form-control" id="editUsuarioCelular" maxlength="9"
                                v-model="editUsuario.phone" :class="errors ? errors.phone ? 'is-invalid' : '' : ''"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editUsuarioImagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="editUsuarioImagen" @change="subirImagenUsuario"
                                accept=".png, .jpeg, .jpg" ref="editUsuarioImagen"
                                :class="errors ? errors.imagen ? 'is-invalid' : '' : ''" aria-label="Imagen">
                        </div>

                        <LoadingComponent v-if="loading_imagen"></LoadingComponent>
                        <template v-else>
                            <div v-if="previewImage" class="mb-3 image-container">
                                <img :src="previewImage" alt="Vista Previa" class="img-fluid vista-previa" />
                                <button type="button" class="btn-close-eliminar" aria-label="Close"
                                    @click="eliminarImagenUsuario(url_imagen_cloudinary)"></button>
                            </div>
                        </template>


                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert">
                                {{ errors }}
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
import usuariosMixin from '../../mixins/usuarios/usuariosMixin';
import LoadingComponent from '../../components/LoadingComponent.vue';

export default {
    mixins: [usuariosMixin],
    components: {
        LoadingComponent
    },
    props: {
        usuario_props: Object
    },
    data() {
        return {
            editUsuario: {
                name: '',
                phone: '',
                imagen: [],
                email: '',
            },
            previewImage: null,
            url_imagen_cloudinary: ''
        };
    },
    watch: {
        usuario_props: {
            immediate: true,
            async handler(usuario) {
                if (usuario) {
                    this.editUsuario.name = usuario.name;
                    this.editUsuario.email = usuario.email;
                    this.editUsuario.phone = usuario.phone;
                    this.url_imagen_cloudinary = usuario.imagenes.length ? usuario.imagenes[0].ruta_imagen : '';
                    this.previewImage = this.url_imagen_cloudinary !== "" ? this.url_imagen_cloudinary : null;
                }
            }
        }
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('editUsuarioModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editUsuarioModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        async subirImagenUsuario(event) {
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

            // Si pasa las validaciones, asignar el archivo a editUsuario
            this.editUsuario.imagen = archivo;  // Asignar solo una imagen

            // Crear una vista previa de la imagen seleccionada
            const reader = new FileReader();
            reader.onload = () => {
                this.previewImage = reader.result;  // Guardar la URL de la imagen
            };
            reader.readAsDataURL(archivo);  // Tomar el archivo seleccionado
        },

        async editEditUsuario() {
            this.errors = null;
            const formData = new FormData();
            formData.append('id', this.usuario_props.id);
            formData.append('name', this.editUsuario.name);
            formData.append('phone', this.editUsuario.phone);
            formData.append('email', this.editUsuario.email);

            // Verificar si hay una imagen seleccionada
            if (this.editUsuario.imagen instanceof File) {
                formData.append('imagen', this.editUsuario.imagen);
            }


            const response = await this.actualizarUsuario(formData);

            if (this.errors === null) {
                document.getElementById('editUsuarioImagen').value = null;
                this.$notyf.success(response.message);
                this.$emit('usuario-updated');
                this.previewImage = null;
                this.close();
            }

        },


        async eliminarImagenUsuario(url_imagen_cloudinary) {
            const response = await this.eliminarImagen(url_imagen_cloudinary);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('usuario-updated');
                this.close();
            }
        }


    }
}
</script>

<style scoped></style>
