import axios from 'axios';

export default {
    data() {
        return {
            whatsapp: {},
            loading_whatsapp: false,
            errors_whatsapp: null,
        };
    },
    methods: {

        async fetchAllWhatsapp() {
            this.loading_whatsapp = true;
            this.errors_whatsapp = null;
            try {
                const response = await axios.get('/landing/whatsapp');
                this.whatsapp = response.data;
            } catch (error) {
                this.errors_whatsapp = 'Failed to load whatsapp';
                console.error('Error fetching whatsapp:', error);
            } finally {
                this.loading_whatsapp = false;
            }
        },
    }
};
