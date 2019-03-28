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



//        beforeRouteEnter: (to, from, next) => {
//
//            next(vm => {
//                setTimeout(next, 1000)
//            })
//
////            this.$emit('load', 'stocks');
//        },

        data () {
            return {
                stock: 1
            }
        },


        mounted () {

            this.$emit('init', {
                API: 'orders'
            });
        }

    }

</script>
