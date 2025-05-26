<template>
    <div>
        <!-- Ícono de WhatsApp fijo -->
        <a :href="whatsappUrl" target="_blank" class="whatsapp-float" aria-label="Chat en WhatsApp">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" />
        </a>
    </div>
</template>

<script>
export default {
    props: {
        whatsapp: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            whatsappUrl: ''
        };
    },
    watch: {
        whatsapp: {
            handler(newVal) {
                this.whatsappUrl = `https://wa.me/${newVal.numero}?text=${encodeURIComponent(newVal.mensaje)}`;
            },
            deep: true
        }
    }
};
</script>

<style scoped>
.whatsapp-float {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 999;
    width: 125px;
    height: 100px;
}

.whatsapp-float img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    transition: transform 0.3s ease;
}

.whatsapp-float img:hover {
    transform: scale(1.1);
}
</style>
