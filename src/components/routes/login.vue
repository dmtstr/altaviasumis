<!--
    Styles
-->

<style>

</style>



<!--
    Template
-->

<template>
    <form @submit.prevent="login">


        <!-- email -->

        <label class="t-bold">
            <span class="t-black">Email</span>
            <i class="t-red">*</i>
        </label>

        <input type="text" v-model="email"/>


        <!-- password -->

        <label class="t-bold">
            <span class="t-black">Password</span>
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
    import Event from '@/common/event';

    export default {
        data () {
            return {
                email: 'dmitriy@dmitriy.com',
                password: 'test',
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

                this.error = null;
                Event.$emit('loading', true);

                API.login({
                    email: this.email,
                    password: this.password
                })
                .then((response) => {
                    Session.create(response.data.data.token);
                    this.$router.push('/');
                })
                .catch((error) => {
                    this.error = error.message;
                })
                .then(() => {
                    Event.$emit('loading', false);
                });


            }
        },
        mounted () {
            Session.destroy();
        }
    }

</script>
