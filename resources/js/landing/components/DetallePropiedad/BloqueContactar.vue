<template>
    <div class="pb-5">
        <div class="card border-0 bg-light">
            <div class="card-body">
                <h3 class="card-title fw-bolder">Contactar Agencia</h3>

                <div class="d-flex gap-2 align-items-center my-3">
                    <div class="container-imagen-agente-contactar" v-if="propiedad.users.imagenes.length > 0">
                        <img :src="propiedad.users.imagenes[0].ruta_imagen" class="img-agente-miniatura-contactar">
                    </div>
                    <ul class="m-0">
                        <li class="d-flex align-items-center">
                            <span class="fs-5">{{ propiedad.users.name }}</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <span class="text-muted">{{ propiedad.users.phone }}</span>

                        </li>
                        <li class="d-flex align-items-center">
                            <span class="text-muted">{{ propiedad.users.email }}</span>
                        </li>
                    </ul>
                </div>

                <form @submit.prevent="guardarCliente">
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">Nombre</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Ingrese su nombre"
                            v-model="cliente.nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Ingrese su email"
                            v-model="cliente.email" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label fw-bold">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" placeholder="Ingrese su teléfono"
                            v-model="cliente.telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="mensaje" class="form-label fw-bold">Mensaje</label>
                        <textarea class="form-control" id="mensaje" rows="3" placeholder="Ingrese su mensaje"
                            v-model="cliente.mensaje" required></textarea>
                    </div>
                    <button type="submit" class="btn w-100 btn-base-dv" :disabled="loading">
                        <span v-if="loading">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Cargando...
                        </span>
                        <span v-else>Enviar</span>
                    </button>
                </form>

            </div>
        </div>
    </div>
</template>
<script>
import servicesClientes from '../../mixins/clientes/servicesClientes';
export default {
    mixins: [servicesClientes],
    props: ['propiedad'],
    components: {
    },
    data() {
        return {
            cliente: {
                user_id: this.propiedad.users.id,
                nombre: '',
                email: '',
                telefono: '',
                mensaje: ''
            },
        }
    },
    methods: {
        async guardarCliente() {
            const response = await this.crearCliente(this.cliente);

            if (this.errors === null) {
                this.$notyf.success({
                    message: response.message,
                    duration: 5000 // Duración en milisegundos (5 segundos)
                });
                this.limpiarCampos();
            }
        },
        limpiarCampos() {
            this.cliente.nombre = '';
            this.cliente.email = '';
            this.cliente.telefono = '';
            this.cliente.mensaje = '';
        },
    },
}
</script>

<style scoped>
.container-imagen-agente-contactar {
    height: 100px;
    min-width: 100px;
    width: 100px;
    border-radius: 50%;

    .img-agente-miniatura-contactar {
        height: 100%;
        min-width: 100%;
        -o-object-fit: cover;
        object-fit: cover;
        width: 100%;
        border-radius: 50%;
    }
}

label:after {
    color: #fc655e;
    content: " *";
}

.form-control {
    background-color: #fff !important;
    color: #212529 !important;
    box-shadow: none !important;
    transition: all 0.3s ease-in-out !important;
}
</style>