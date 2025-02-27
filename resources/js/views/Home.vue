<script setup>
import Header from '../components/utils/Header.vue'
import Container from "../components/utils/Container.vue";
import HomeTable from "../components/Home/HomeTable.vue";
</script>

<template>
    <section class="flex flex-col items-center justify-center overflow-y-none">
        <article class="w-[930px]">
            <Header title="Contatos" />
            <Container>
                <template v-slot:content>
                    <HomeTable />
                </template>
            </Container>
        </article>
    </section>
</template>

<style scoped>

</style>
