import axios from 'axios';

export default {
    data() {
        return {
            loading_uf: false,
            input_uf: false,
            valorUF: 0
        };
    },
    methods: {
        async obtenerValorUF() {
            this.loading_uf = true;
            const timeout = setTimeout(() => {
                this.valorUF = 0;
                this.loading_uf = false;
                this.input_uf = true;
                console.error("Error: La solicitud ha tardado más de 5 segundos.");
            }, 5000);

            try {
                const response = await axios.get("https://mindicador.cl/api/uf");
                clearTimeout(timeout);
                this.valorUF = response.data.serie[0].valor;
                this.input_uf = false;
            } catch (error) {
                clearTimeout(timeout);
                console.error("Error obteniendo el valor UF:", error);
            } finally {
                this.loading_uf = false;
            }
        }
    }
};
