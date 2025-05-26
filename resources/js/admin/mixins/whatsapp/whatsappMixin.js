import axios from 'axios';

export default {
    data() {
        return {
            recuperar_numero: [],
            loading: false,
            errors: null,
        };
    },
    methods: {

        async fetchAllWhatsapp() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/whatsapp/all');
                this.recuperar_numero = response.data;
            } catch (error) {
                this.errors = 'Failed to load whatsapp';
                console.error('Error fetching whatsapp:', error);
            } finally {
                this.loading = false;
            }
        },

        async guardarWhatsappNumero(configuracion) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/whatsapp/store', {
                    numero: configuracion.numero,
                    mensaje: configuracion.mensaje,
                    estado: configuracion.estado
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors = 'Failed to load whatsapp';
                console.error('Error crear whatsapp:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarEstadoWhatsapp(configuracion) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/whatsapp/update/' + configuracion.id, {
                    estado: configuracion.estado
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors = 'Failed to update whatsapp';
                console.error('Error updating whatsapp:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
