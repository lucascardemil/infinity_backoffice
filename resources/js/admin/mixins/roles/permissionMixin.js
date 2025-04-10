import axios from 'axios';

export default {
    data() {
        return {
            permissions: [],
            loading: false,
            error: null,
        };
    },
    methods: {
        async fetchPermissions() {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get('/permissions');
                this.permissions = response.data;
            } catch (error) {
                this.error = 'Failed to load permisos';
                console.error('Error fetching permisos:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
