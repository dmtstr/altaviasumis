<!--
    Styles
-->

<style>

</style>



<!--
    Template
-->

<template>
    <form class="form" @submit.prevent="create">

        <!-- email -->

        <label>
            <span>ID</span>
            <i class="t-red">*</i>
        </label>

        <input type="text" v-model="id" />


        <!-- password -->

        <label>
            <span>Quantity</span>
            <i class="t-red">*</i>
        </label>

        <input type="text" v-model="quantity"/>


        <!-- submit -->

        <input type="submit" value="Create" class="button primary"/>


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
                id: '',
                quantity: '',
                error: null
            }
        },

        methods: {

            create () {
                if (!this.id) return (this.error = 'ID is required');
                if (!this.quantity) return (this.error = 'Quantity is required');
                if (!+this.quantity) return (this.error = 'Quantity must be a number');
            }

        }
    }

</script>
