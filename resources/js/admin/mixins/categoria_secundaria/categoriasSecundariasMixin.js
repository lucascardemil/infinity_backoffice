import axios from 'axios';

export default {
    data() {
        return {
            categorias_secundarias: [],
            loading: false,
            errors: null,
        };
    },
    methods: {

        async fetchCategoriasSecundariasSelect() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/categoria_secundarias/all-select');
                this.categorias_secundarias = response.data;
            } catch (error) {
                this.errors = 'Failed to load categorias_secundarias';
                console.error('Error fetching categorias_secundarias:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchCategoriasSecundarias() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/categoria_secundarias/all');
                this.categorias_secundarias = response.data;
            } catch (error) {
                this.errors = 'Failed to load categorias_secundarias';
                console.error('Error fetching categorias_secundarias:', error);
            } finally {
                this.loading = false;
            }
        },

        async crearCategoriaSecundaria(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/categoria_secundarias/store', {
                    nombre: data.nombre
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors = 'Failed to load categoria secundaria';
                console.error('Error crear categoria secundaria:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarCategoriaSecundaria(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/categoria_secundarias/update/' + data.categoria_secundaria_id, {
                    nombre: data.nombre
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load categoria secundaria';
                console.error('Error actualizar categoria secundaria:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatus(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/categoria_secundarias/update-status/' + data.categoria_secundaria_id, {
                    estado: data.estado
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load categoria secundaria';
                console.error('Error actualizar categoria secundaria:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
