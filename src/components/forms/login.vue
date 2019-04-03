<!--
    Styles
-->

<style>
    
</style>



<!--
    Template
-->

<template>
    <form class="f-form" @submit.prevent="login">
        <label class="f-label required">Email</label>
        <input class="f-input" type="text" v-model="email"/>
        <label class="f-label required">Password</label>
        <input class="f-input" type="password" v-model="password"/>
        <input class="f-button primary wide" type="submit" value="Sign in"/>
        <p class="f-error" v-show="error">An error occurred: {{error}}</p>
    </form>
</template>



<!--
    Scripts
-->

<script>

    import {mapActions} from 'vuex';
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

            ...mapActions([
                'loading'
            ]),

            login () {

                this.error = null;
                this.loading(true);

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
                        this.loading(false);
                    })

            }

        }

    }

</script>
