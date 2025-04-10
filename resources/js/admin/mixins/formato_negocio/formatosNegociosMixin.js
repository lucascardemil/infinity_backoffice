import axios from 'axios';

export default {
    data() {
        return {
            formatos_negocios: [],
            loading: false,
            errors: null,
        };
    },
    methods: {

        async fetchFormatosNegociosSelect() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/formato_negocios/all-select');
                this.formatos_negocios = response.data;
            } catch (error) {
                this.errors = 'Failed to load formatos_negocios';
                console.error('Error fetching formatos_negocios:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchFormatosNegocios() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/formato_negocios/all');
                this.formatos_negocios = response.data;
            } catch (error) {
                this.errors = 'Failed to load formatos_negocios';
                console.error('Error fetching formatos_negocios:', error);
            } finally {
                this.loading = false;
            }
        },

        async crearFormatoNegocio(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/formato_negocios/store', {
                    nombre: data.nombre
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors = 'Failed to load formato_negocio';
                console.error('Error crear formato_negocio:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarFormatoNegocio(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/formato_negocios/update/' + data.formato_negocio_id, {
                    nombre: data.nombre
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load formato_negocio';
                console.error('Error actualizar formato_negocio:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatus(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/formato_negocios/update-status/' + data.formato_negocio_id, {
                    estado: data.estado
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load formato_negocio';
                console.error('Error actualizar formato_negocio:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
