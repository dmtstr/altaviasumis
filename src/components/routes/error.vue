<!--
    Styles
-->

<style>

</style>



<!--
    Template
-->

<template>
    <form-error :error="error" @repeat="back"></form-error>
</template>



<!--
    Scripts
-->

<script>

    import formError from '@/components/forms/error.vue'
    
    export default {

        components: {
            formError
        },

        props: [
            'error'
        ],

        beforeRouteEnter (to, from, next) {
            if (to.params.error) next(vm => {
                vm.previous = from.path;
            });
            else next({
                path: from.path,
                replace: true
            });
        },

        methods: {

            back () {
                this.$router.replace(this.previous);
            }

        }

    }

</script>
