<script setup>
    import Button from "../components/utils/Button.vue";

    const login = () => {
        const clientId = 'APP-96c6a8a8-b2d7-4c28-996e-f2354833a602';
        const redirectUri = 'https://8c9e-2804-1b1-f800-5f83-713f-e064-f80c-e8fd.ngrok-free.app/auth/callback';
        const scope = 'install_app read_agent_profile';
        const authUrl = `https://auth.huggy.app/oauth/authorize?scope=${scope}&response_type=code&redirect_uri=${redirectUri}&client_id=${clientId}`;

        window.location.href = authUrl;
    }
</script>

<template>
    <section class="w-full h-full flex flex-col justify-center items-center gap-[24px]">
        <h1 class="font-roboto font-[400] text-[24px]">Login</h1>
        <Button width="250px" @click="login" label="Fazer login com a Huggy"></Button>
    </section>
</template>

<style scoped>

</style>
