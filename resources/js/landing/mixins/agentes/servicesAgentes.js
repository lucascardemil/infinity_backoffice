import axios from 'axios';

export default {
    data() {
        return {
            agentes: [],
            loading_agentes: false,
            errors_agentes: null,
        };
    },
    methods: {

        async fetchAllAgentes() {
            this.loading_agentes = true;
            this.errors_agentes = null;
            try {
                const response = await axios.get('/landing/agentes');
                this.agentes = response.data;
            } catch (error) {
                this.errors_agentes = 'Failed to load agentes';
                console.error('Error fetching agentes:', error);
            } finally {
                this.loading_agentes = false;
            }
        },
    }
};
