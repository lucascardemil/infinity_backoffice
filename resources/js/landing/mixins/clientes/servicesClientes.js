import axios from 'axios';

export default {
    data() {
        return {
            clientes: [],
            loading: false,
            errors: null,
        };
    },
    methods: {

        async fetchClientesSelect() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/clientes/all-select');
                this.clientes = response.data;
            } catch (error) {
                this.errors = 'Failed to load clientes';
                console.error('Error fetching clientes:', error);
            } finally {
                this.loading = false;
            }
        },

        async crearCliente(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/clientes/store', {
                    user_id: data.user_id,
                    nombre: data.nombre,
                    email: data.email,
                    telefono: data.telefono,
                    mensaje: data.mensaje,
                    url_propiedad: data.url_propiedad,
                    titulo_propiedad: data.titulo_propiedad,
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
    }
};
