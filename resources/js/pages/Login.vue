<script setup>
    import Button from "../components/utils/Button.vue";

    const login = () => {
        const clientId = 'APP-95126f96-ee51-4085-9414-8da9c856dd57';
        const redirectUri = encodeURIComponent('http://192.168.15.28:8000/auth/redirect');
        const scope = 'install_app read_agent_profile';
        const authUrl = `https://auth.huggy.app/oauth/authorize?client_id=${clientId}&redirect_uri=${redirectUri}&response_type=code&scope=${scope}`;

        window.location.href = authUrl;
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
