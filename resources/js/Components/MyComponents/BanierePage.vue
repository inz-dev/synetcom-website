<script setup>
import { computed, onMounted } from "vue";
const props = defineProps({
    backgroundImage: String,
    title: String,
});
const backgroudStyle = computed(() => {
    return {
        background: `url(${props.backgroundImage}) no-repeat center`,
        backgroundSize: "cover",
        backgroundPosition: "center",
        minHeight: "80vh",
        paddingTop: "20px",
        paddingBottom: "20px",
    };
});
onMounted(() => {
    //console.log("styel:", backgroudStyle);
});
</script>

<template>
    <div :style="backgroudStyle">
        <div class="container my-3 py-4 mt-10">
            <h1
                class="mt-10 text-center text-white fw-medium font-family-Montserrat"
            >
                {{ title }}
            </h1>
             <slot/>
        </div>

    </div>
</template>

<style>
.bg-image {
    /* Workaround for some mobile browsers */
    background: url("/images/background1.png") no-repeat center center;
    background-size: cover;
    min-height: 80vh;
    padding-top: 20px;
    padding-bottom: 20px;
}
</style>
