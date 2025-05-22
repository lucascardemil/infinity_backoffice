<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white">Configuración UF</h3>
        </div>

        <LoadingComponent v-if="loading" />

        <div v-else>
            <div class="col-5 mb-3">
                <h5 class="text-white">Valor UF</h5>
                <input type="text" class="form-control" id="valor_uf" placeholder="Ingresa el valor de la UF"
                    v-model="valor_uf" required>
            </div>
        </div>


        <div class="mb-5">
            <button class="btn btn-base-dv" @click="guardarValorUF()" :disabled="loading">Guardar
                Cambios</button>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '../../components/LoadingComponent.vue';
import ufMixin from '../../mixins/uf/ufMixin';

export default {
    mixins: [ufMixin],
    components: {
        LoadingComponent
    },
    data() {
        return {
            valor_uf: 0
        };
    },
    watch: {
        'recuperar_valor_uf': {
            handler() {
                this.valor_uf = this.recuperar_valor_uf.valor_uf ?? this.recuperar_valor_uf.valor_uf;
            },
            deep: true
        }
    },
    methods: {
        async guardarValorUF() {
            const response = await this.guardarUF(this.valor_uf);

            if (this.errors === null) {
                this.$notyf.success(response.message);
            }
        }

    },
    created() {
        this.fetchAllValorUF();
    }
}
</script>

<style scoped></style>
