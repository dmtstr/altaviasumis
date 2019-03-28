<!--
    Styles
-->

<style scoped>
    form {
        max-width: 640px;
        margin: 0 auto;
        padding-top: 48px;
        padding-bottom: 48px;
    }
</style>



<!--
    Template
-->

<template>
    <section>
        <form-login @success="success"></form-login>
    </section>
</template>



<!--
    Scripts
-->

<script>

    import formLogin from '@/components/forms/login.vue';

    export default {

        components: {
            formLogin
        },

        methods: {
            success (response) {
                this.$store.commit('session:create', response.data.data.token);
                this.$router.push('/');
            }
        },

        mounted () {
            this.$store.commit('session:destroy');
        }

    }

</script>
