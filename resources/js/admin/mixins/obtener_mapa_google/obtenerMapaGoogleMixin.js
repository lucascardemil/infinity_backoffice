import axios from 'axios';

export default {
    data() {
        return {
            apiKey: "",
        };
    },
    methods: {
        async loadGoogleMaps() {
            try {
                const response = await axios.get("/configuraciones/all");
                this.apiKey = response.data.api_google_maps;
                this.loadGoogleMapsAPI();
            } catch (error) {
                console.error("Error al obtener la API Key:", error);
            }
        },

        loadGoogleMapsAPI() {
            // Verifica si Google Maps ya está cargado
            if (window.google && window.google.maps) {
                console.log("Google Maps API ya está cargado.");
                this.initMap();
                this.initGeocoder();
                return;
            }

            // Verifica si el script ya fue insertado
            if (document.querySelector("script[src*='maps.googleapis.com']")) {
                console.log("El script de Google Maps ya se ha insertado.");
                return;
            }

            // Cargar el script
            if (this.apiKey) {
                const script = document.createElement("script");
                script.src = `https://maps.googleapis.com/maps/api/js?key=${this.apiKey}&libraries=places`;
                script.async = true;
                script.onload = () => {
                    this.geocoder = new google.maps.Geocoder();
                    this.initMap();
                    this.initGeocoder();
                };
                document.head.appendChild(script);
            }
        },
    },
};
