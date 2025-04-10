<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white">Configuraciones</h3>
        </div>

        <LoadingComponent v-if="loading" />
        <div v-else>
            <div class="col-5 mb-5">
                <h5 class="text-white">Google Maps API</h5>
                <input type="text" class="form-control" id="configuracion_google_maps_api" placeholder="Pega API KEY"
                    v-model="configuraciones.google_maps_api" required>
            </div>
        </div>


        <div class="mb-5">
            <button class="btn btn-base-dv" @click="guardarConfiguraciones()" :disabled="loading">Guardar
                Cambios</button>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '../../components/LoadingComponent.vue';
import configuracionesMixin from '../../mixins/configuraciones/configuracionesMixin';

export default {
    mixins: [configuracionesMixin],
    components: {
        LoadingComponent
    },
    data() {
        return {
            configuraciones: {
                google_maps_api: '',
            }
        };
    },
    watch: {
        'todas_configuraciones': {
            handler() {
                this.configuraciones.google_maps_api = this.todas_configuraciones.googleMapApiKey ?? this.todas_configuraciones.api_google_maps;
            },
            deep: true
        }
    },
    methods: {
        async guardarConfiguraciones() {
            const response = await this.guardarConfiguracion(this.configuraciones);

            if (this.errors === null) {
                this.$notyf.success(response.message);
            }
        }

    },
    created() {
        this.fetchAllConfiguraciones();
    }
}
</script>

<style scoped></style>
