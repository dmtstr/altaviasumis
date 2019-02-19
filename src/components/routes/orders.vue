<!--
    Styles
-->

<style>
    
</style>



<!--
    Template
-->

<template>
    <div id="orders">
        orders
    </div>
</template>



<!--
    Scripts
-->

<script>

    import API from '@/common/api'
    
    export default {

        mounted () {

            API.orders()


        }

    }

</script>
