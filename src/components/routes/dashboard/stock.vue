<!--
    Styles
-->

<style>
    
</style>



<!--
    Template
-->

<template>
    <h1>Stock</h1>
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
            this.$emit('load', 'stocks');
        },

        mounted () {

            this.$emit('init', this.test);
        }

    }

</script>
