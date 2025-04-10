<template>
    <div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearUsuarioModalLabel">Crear Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" @click="close"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="saveUsuario">
                        <div class="mb-3">
                            <label for="usuarioNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="usuarioNombre" v-model="newUsuario.name"
                                :class="errors ? errors.name ? 'is-invalid' : '' : ''" required>
                        </div>
                        <div class="mb-3">
                            <label for="usuarioEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="usuarioEmail" v-model="newUsuario.email"
                                :class="errors ? errors.email ? 'is-invalid' : '' : ''" required>
                        </div>
                        <div class="mb-3">
                            <label for="usuarioCelular" class="form-label">Celular</label>
                            <input type="celular" class="form-control" id="usuarioCelular" v-model="newUsuario.phone"
                                :class="errors ? errors.phone ? 'is-invalid' : '' : ''" required>
                        </div>
                        <div class="mb-3">
                            <label for="usuarioImagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="usuarioImagen" @change="subirImagenUsuario"
                                accept=".png, .jpeg, .jpg" ref="usuarioImagen"
                                :class="errors ? errors.imagen ? 'is-invalid' : '' : ''" aria-label="Imagen" required>
                        </div>
                        <div v-if="previewImage" class="mb-3">
                            <img :src="previewImage" alt="Vista Previa" class="img-fluid vista-previa" />
                        </div>
                        <div class="mb-3">
                            <label for="usuarioPassword" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="usuarioPassword"
                                v-model="newUsuario.password"
                                :class="error_password ? error_password.password ? 'is-invalid' : '' : errors ? errors.password ? 'is-invalid' : '' : ''"
                                aria-describedby="password" required>
                            <div id="password" :class="error_password ? 'invalid-feedback' : ''">
                                {{ error_password ? error_password.password : '' }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="usuarioConfirmarPassword" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="usuarioConfirmarPassword"
                                v-model="newUsuario.password_confirmation"
                                :class="error_password ? error_password.password_confirmation ? 'is-invalid' : '' : errors ? errors.password_confirmation ? 'is-invalid' : '' : ''"
                                aria-describedby="password_confirmation">

                            <div id="password_confirmation" :class="error_password ? 'invalid-feedback' : ''">
                                {{ error_password ? error_password.password_confirmation : '' }}
                            </div>
                        </div>

                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="password in errors.password">
                                {{ password }}
                            </div>

                            <div class="alert alert-danger" role="alert" v-for="email in errors.email">
                                {{ email }}
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
import usuariosMixin from '../../mixins/usuarios/usuariosMixin';
import { limpiarCampos } from '../../utils/limpiarCampos';
import { validarPassword } from '../../utils/validarPassword';

export default {
    mixins: [usuariosMixin],
    data() {

        return {
            newUsuario: {
                name: '',
                phone: '',
                imagen: [],
                email: '',
                password: '',
                password_confirmation: ''
            },
            error_password: null,
            previewImage: null // Esta propiedad es para la vista previa
        };


    },
    watch: {
        'newUsuario.password': function () {
            this.error_password = validarPassword(this.newUsuario.password, this.newUsuario.password_confirmation);
        },
        'newUsuario.password_confirmation': function () {
            this.error_password = validarPassword(this.newUsuario.password, this.newUsuario.password_confirmation);
        }
    },
    methods: {
        open() {
            this.errors = null;
            this.error_password = null;
            limpiarCampos(this.newUsuario);
            const modalElement = document.getElementById('crearUsuarioModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            this.errors = null;
            this.error_password = null;
            limpiarCampos(this.newUsuario);
            const modalElement = document.getElementById('crearUsuarioModal');
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

            // Si pasa las validaciones, asignar el archivo a newUsuario
            this.newUsuario.imagen = archivo;  // Asignar solo una imagen

            // Crear una vista previa de la imagen seleccionada
            const reader = new FileReader();
            reader.onload = () => {
                this.previewImage = reader.result;  // Guardar la URL de la imagen
            };
            reader.readAsDataURL(archivo);  // Tomar el archivo seleccionado
        },

        async saveUsuario() {
            const formData = new FormData();
            formData.append('name', this.newUsuario.name);
            formData.append('phone', this.newUsuario.phone);
            formData.append('email', this.newUsuario.email);
            formData.append('password', this.newUsuario.password);
            formData.append('password_confirmation', this.newUsuario.password_confirmation);

            // Verificar si se ha seleccionado una imagen y agregarla al FormData
            if (this.newUsuario.imagen) {
                formData.append('imagen', this.newUsuario.imagen);  // Agregar solo la imagen
            }

            const response = await this.createUsuario(formData);

            if (this.errors === null) {
                document.getElementById('usuarioImagen').value = null;
                this.$notyf.success(response.message);
                this.$emit('usuario-updated');
                limpiarCampos(this.newUsuario);
                this.error_password = null;
                this.previewImage = null;
                this.close();
            }
        },
    }
}
</script>

<style scoped></style>
