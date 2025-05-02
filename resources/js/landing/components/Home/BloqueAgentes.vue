<template>
    <div class="container-fluid pt-5 pb-5">
        <div class="container">
            <div class="row justify-content-center pb-5">
                <div class="col-auto">
                    <p class="text-center texto-titulo">NUESTROS EQUIPOS</p>
                    <h3>Conozca a nuestros agentes</h3>
                </div>
            </div>

            <div class="row justify-content-center">
                <template v-for="(agente, index) in agentes">
                    <div class="col-lg-3 col-md-12 col-12 d-flex justify-content-center gap-3">
                        <div class="card-agente fade-in mb-4 p-3" :style="{ animationDelay: (index * 0.1) + 's' }">
                            <div class="mb-3" v-if="agente.imagenes.length > 0">
                                <img :src="agente.imagenes[0].ruta_imagen" class="img-fluid rounded-3">
                            </div>
                            <div class="mb-3" v-else>
                                <img src="/images/agente-defecto.png" class="img-fluid rounded-3">
                            </div>
                            <h3 class="mb-3">{{ agente.name }}</h3>
                            <ul class="p-0">
                                <li class="d-flex align-items-center gap-3" v-if="agente.propiedades.length > 0">
                                    <i class="bi bi-house-door fs-5"></i>
                                    <span class="fs-5">{{ agente.propiedades.length }} {{ agente.propiedades.length ===
                                        1 ? 'Propiedad' : 'Propiedades' }}</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <a :href="'tel:' + agente.phone" class="text-decoration-none d-flex gap-3">
                                        <i class="bi bi-telephone texto-titulo fs-5"></i>
                                        <span class="texto-titulo fs-5">{{ agente.phone }}</span>
                                    </a>
                                </li>
                                <li class="d-flex align-items-center gap-3">
                                    <a :href="'mailto:' + agente.email" class="text-decoration-none d-flex gap-3">
                                        <i class="bi bi-envelope texto-titulo fs-5"></i>
                                        <span class="texto-titulo fs-5">{{ agente.email }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        agentes: {
            type: Array,
            required: true,
        },
    }
}
</script>
<style>
.fade-in {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.6s ease forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Estilo y animación al hacer hover */
.card-agente {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    background-color: #fff;
}

.card-agente:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}
</style>