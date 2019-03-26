<!--
    Styles
-->

<style>
    
</style>



<!--
    Template
-->

<template>
    <h1>Order</h1>
</template>



<!--
    Scripts
-->

<script>
    
    export default {

        props: [
            'test'
        ],

        beforeRouteEnter: (to, from, next) => {
            this.$emit('load', 'orders');
        },

        mounted () {

            this.$emit('init', this.test);
        }

    }

</script>
