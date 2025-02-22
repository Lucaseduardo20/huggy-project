<script setup>
    import Button from "../components/utils/Button.vue";

    const login = () => {
        alert('bateu aqui')
    }
</script>

<template>
    <section class="w-full h-full flex flex-col justify-center items-center gap-[24px]">
        <h1 class="font-roboto font-[400] text-[24px]">Login</h1>
        <Button @click="login" label="Fazer login com a Huggy"></Button>
    </section>
</template>

<style scoped>

</style>
