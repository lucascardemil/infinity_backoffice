import axios from 'axios';

export default {
    data() {
        return {
            recuperar_valor_uf: [],
            loading: false,
            errors: null,
        };
    },
    methods: {

        async fetchAllValorUF() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/uf/all');
                this.recuperar_valor_uf = response.data;
            } catch (error) {
                this.errors = 'Failed to load uf';
                console.error('Error fetching uf:', error);
            } finally {
                this.loading = false;
            }
        },

        async guardarUF(valor_uf) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/uf/store', {
                    valor_uf: valor_uf
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors = 'Failed to load uf';
                console.error('Error crear uf:', error);
            } finally {
                this.loading = false;
            }
        },
    }
};
