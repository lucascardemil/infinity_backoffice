<template>
    <div class="container-fluid pt-5 pb-5">
        <div class="container">
            <div class="row justify-content-center pb-5">
                <div class="col-auto text-center">
                    <p class="text-uppercase texto-titulo">NUESTROS COLABORADORES</p>
                    <h3>Conozca a nuestros colaboradores</h3>
                </div>
            </div>

            
            <swiper 
                :slides-per-view="slidesPerView" 
                :space-between="spaceBetween"
                :mousewheel="{ releaseOnEdges: true }" 
                :loop="true" direction="horizontal" 
                :navigation="false"
                :breakpoints="{
                    '320': {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    '375': {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    '425': {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    '768': {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    '1024': {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    },
                }" class="mySwiper">
                <swiper-slide v-for="(image, index) in images" :key="index">
                    <div class="slide-wrapper">
                        <img :src="image" alt="colaborador" />
                    </div>
                </swiper-slide>
            </swiper>
        </div>
    </div>
</template>

<script>
import { Navigation, Pagination } from "swiper";
import { SwiperCore, Swiper, SwiperSlide } from "swiper-vue2";

// Import Swiper styles
import "swiper/swiper-bundle.css";

SwiperCore.use([Navigation, Pagination]);

export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            images: [
                '/images/colaborador1.jpeg',
                '/images/colaborador1.jpeg',
                '/images/colaborador1.jpeg',
                '/images/colaborador1.jpeg',
                '/images/colaborador1.jpeg',
                '/images/colaborador1.jpeg',
            ],
            slidesPerView: 2,
            spaceBetween: 20
        };
    }

};
</script>

<style scoped>
.mySwiper {
    width: 100%;
}

.swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
}

.slide-wrapper {
    width: 100%;
    max-width: 300px;
}

.slide-wrapper img {
    width: 100%;
    max-height: 200px;
    object-fit: contain;
}
</style>