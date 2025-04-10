import axios from 'axios';

export default {
    data() {
        return {
            roles: [],
            loading: false,
            errors: null,
        };
    },
    methods: {
        async fetchRoles() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/roles/all');
                this.roles = response.data;
            } catch (error) {
                this.errors = 'Failed to load roles';
                console.error('Error fetching roles:', error);
            } finally {
                this.loading = false;
            }
        },

        async createRol(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/roles/store', {
                    name: data.name
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors = 'Failed to load usuario';
                console.error('Error crear usuario:', error);
            } finally {
                this.loading = false;
            }
        },

        async updateRoles(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/roles/update/' + data.id, {
                    name: data.name,
                    permissions: data.permissions
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load roles';
                console.error('Error fetching roles:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
