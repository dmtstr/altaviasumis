<!--
    Styles
-->

<style>
    
</style>



<!--
    Template
-->

<template>
    <form class="form" @submit.prevent="login">


        <!-- email -->

        <label>
            <span>Email</span>
            <i class="t-red">*</i>
        </label>

        <input type="text" v-model="email"/>


        <!-- password -->

        <label>
            <span>Password</span>
            <i class="t-red">*</i>
        </label>

        <input type="password" v-model="password"/>


        <!-- submit -->

        <input type="submit" value="Sign in" class="button primary"/>


        <!-- error -->

        <p class="t-small t-red" v-show="error">An error occurred: {{error}}</p>


    </form>
</template>



<!--
    Scripts
-->

<script>


    import API from '@/common/api';


    export default {

        data () {
            return {
                email: 'dmitriy@dmitriy.com',
                password: 'test',
                error: null
            }
        },

        methods: {

            login () {

                this.error = null;
                this.$store.commit('loading', true);

                API.login({
                        email: this.email,
                        password: this.password
                    })
                    .then(response => {
                        this.$emit('success', response);
                    })
                    .catch(error => {
                        if (!error) return;
                        this.error = error.message;
                        this.$store.commit('loading', false);
                    })

            }

        }

    }

</script>
