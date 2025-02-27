<script setup>
import Header from '../components/utils/Header.vue';
import Container from "../components/utils/Container.vue";
import HomeTable from "../components/Home/HomeTable.vue";
</script>

<template>
    <section class="flex flex-col items-center justify-center min-h-screen p-4">
        <article class="w-full max-w-[930px]">
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
@media (max-width: 768px) {
    article {
        width: 100%;
        padding: 0 16px;
    }
}

@media (max-width: 480px) {
    article {
        padding: 0 8px;
    }
}
</style>
