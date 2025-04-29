import axios from 'axios';

export default {
    data() {
        return {
            propiedades: [],
            loading_propiedades: false,
            errors_propiedades: null,
        };
    },
    methods: {

        async fetchAllPropiedades() {
            this.loading_propiedades = true;
            this.errors_propiedades = null;
            try {
                const response = await axios.get('/landing/propiedades');
                this.propiedades = response.data;
            } catch (error) {
                this.errors_propiedades = 'Failed to load propiedades';
                console.error('Error fetching propiedades:', error);
            } finally {
                this.loading_propiedades = false;
            }
        },
    }
};
