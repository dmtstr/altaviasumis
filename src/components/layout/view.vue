<!--
    Styles
-->

<style scoped>

    .loading {
        position: relative;
    }
    .loading:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

</style>



<!--
    Template
-->

<template>
    <router-view :class="{loading: loading}"></router-view>
</template>



<!--
    Scripts
-->

<script>

    import Event from '@/common/event';

    export default {
        data() {
            return {
                loading: false
            }
        },
        mounted() {
            Event.$on('loading', value => this.loading = value);
        }
    }

</script>
