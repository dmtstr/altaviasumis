<!--
    Styles
-->

<style>
    
</style>



<!--
    Template
-->

<template>
    <form class="f-form" @submit.prevent="submit">

        <label class="f-label required">First field</label>
        <input class="f-input" type="text" v-model="first"/>

        <label class="f-label required">Second field</label>
        <input class="f-input" type="text" v-model="second"/>

        <div class="buttons l-clear">
            <input class="l-fl f-button primary wide" type="submit" value="Create"/>
            <a class="l-fl f-button blank" @click="create(false)">Cancel</a>
        </div>

        <p class="f-error" v-show="error">{{error}}</p>

    </form>
</template>



<!--
    Scripts
-->

<script>

    import {mapActions} from 'vuex';

    export default {

        data () {
            return {
                first: null,
                second: null,
                error: null
            }
        },

        methods: {

            ...mapActions('dashboard', [
                'create'
            ]),

            submit () {
                this.error = 'Not working yet';
            }

        }

    }

</script>
