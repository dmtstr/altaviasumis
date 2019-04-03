<!--
    Styles
-->

<style>
    .r-login {
        width: 640px;
        margin: 0 auto;
        padding-top: 48px;
        padding-bottom: 48px;
    }
</style>



<!--
    Template
-->

<template>
    <section class="r-login">
        <form-login @success="success"></form-login>
    </section>
</template>



<!--
    Scripts
-->

<script>


    import {mapActions} from 'vuex';
    import formLogin from '@/components/forms/login.vue';

    export default {

        components: {
            formLogin
        },

        methods: {

            ...mapActions('session', [
                'create',
                'destroy'
            ]),

            ...mapActions([
                'loading'
            ]),

            success (response) {
                this.create(response.data.data.token);
                this.$router.push('/');
            }
        },

        mounted () {
            this.loading(false);
            this.destroy();
        }

    }

</script>
