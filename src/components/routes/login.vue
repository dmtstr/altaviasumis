<!--
    Styles
-->

<style>

</style>



<!--
    Template
-->

<template>
    <form id="login" @submit.prevent="login" :class="{'l-loading': loading}">


        <!-- email -->

        <label class="t-bold">
            <span>Email</span>
            <i class="t-red">*</i>
        </label>

        <input type="text" v-model="email"/>


        <!-- password -->

        <label class="t-bold">
            <span>Password</span>
            <i class="t-red">*</i>
        </label>

        <input type="password" v-model="password"/>


        <!-- submit -->

        <input type="submit" :value="status" class="button primary"/>


        <!-- error -->

        <p class="t-small t-red" v-show="error">An error occurred: {{error}}</p>


    </form>
</template>



<!--
    Scripts
-->

<script>

    import API from '@/common/api';
    import Session from '@/common/session';

    export default {
        data () {
            return {
                email: 'test@test.com',
                password: 'secret',
                loading: false,
                error: null
            }
        },
        computed: {
            status () {
                return this.loading ? 'Processing...' : 'Sign in'
            }
        },
        methods: {
            login () {

                this.loading = true;
                this.error = null;

                API.login({
                    email: this.email,
                    password: this.password
                })
                .then((response) => {
                    Session.create(response.data.token);
                    this.$router.push('/');
                })
                .catch((error) => {
                    this.error = error.message;
                })
                .then(() => {
                    this.loading = false;
                });


            }
        },
        mounted () {
            Session.destroy();
        }
    }

</script>
