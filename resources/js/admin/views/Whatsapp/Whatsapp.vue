<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white">Configuración Whatsapp</h3>
        </div>

        <LoadingComponent v-if="loading" />

        <div v-else>

            <div class="col-5 mb-3">
                <h5 class="text-white">Habilitar Whatsapp</h5>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="habilitarWhatsapp"
                        v-model="configuracion.estado" @change="cambiarEstadoWhatsapp(configuracion.estado)"/>
                    <label class="form-check-label" for="habilitarWhatsapp">Habilitar</label>
                </div>
            </div>
            <div class="col-5 mb-3">
                <h5 class="text-white">Telefono</h5>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="whatsapp">+569</span>
                    <input type="text" class="form-control" placeholder="12345678" id="numero" aria-label="Username"
                        aria-describedby="whatsapp" maxlength="8" required v-model="configuracion.numero"
                        @input="configuracion.numero = configuracion.numero.replace(/\D/g, '')" />
                </div>
            </div>

            <div class="col-5 mb-3">
                <h5 class="text-white">Mensaje</h5>

                <div class="form-group mb-3">
                    <input type="text" class="form-control" placeholder="Mensaje de Bienvenida" id="mensaje" required
                        v-model="configuracion.mensaje" />
                </div>
            </div>
        </div>


        <div class="mb-5">
            <button class="btn btn-base-dv" @click="guardarWhatsapp()" :disabled="loading">Guardar
                Cambios</button>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '../../components/LoadingComponent.vue';
import whatsappMixin from '../../mixins/whatsapp/whatsappMixin';

export default {
    mixins: [whatsappMixin],
    components: {
        LoadingComponent
    },
    data() {
        return {
            configuracion: {
                id: 0,
                numero: 0,
                mensaje: '',
                estado: false,
            }
        };
    },
    watch: {
        'recuperar_numero': {
            handler() {
                this.configuracion.id = this.recuperar_numero.id ?? this.recuperar_numero.id;
                this.configuracion.numero = this.recuperar_numero.numero ?? this.recuperar_numero.numero;
                this.configuracion.mensaje = this.recuperar_numero.mensaje ?? this.recuperar_numero.mensaje;
                this.configuracion.estado = this.recuperar_numero.estado ?? this.recuperar_numero.estado;
            },
            deep: true
        }
    },
    methods: {
        async cambiarEstadoWhatsapp(estado) {
            this.configuracion.estado = estado;
            const response = await this.actualizarEstadoWhatsapp(this.configuracion);


            if (this.errors === null) {
                this.$notyf.success(response.message);
            }
        },
        async guardarWhatsapp() {
            const response = await this.guardarWhatsappNumero(this.configuracion);

            if (this.errors === null) {
                this.$notyf.success(response.message);
            }
        }

    },
    created() {
        this.fetchAllWhatsapp();
    }
}
</script>

<style scoped></style>
