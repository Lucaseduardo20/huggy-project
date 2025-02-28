<script setup>
import Header from "../components/utils/Header.vue";
import Container from "../components/utils/Container.vue";
import HomeTable from "../components/Home/HomeTable.vue";
import DashboardHeader from '../components/Dashboard/DashboardHeader.vue'
import DashboardContent from "../components/Dashboard/DashboardContent.vue";
</script>

<template>
    <section class="flex flex-col items-center justify-center min-h-screen p-4">
        <article class="w-full max-w-[930px]">
            <Header title="Dashboard" />
            <Container>
                <template v-slot:content>
                    <DashboardHeader></DashboardHeader>
                    <DashboardContent />
                </template>
            </Container>
        </article>
    </section>
</template>

<style scoped>

</style>
