<!--
    Styles
-->

<style scoped>

    .l-container {
        padding-top: 30px;
        padding-bottom: 30px;
    }

</style>



<!--
    Template
-->

<template>

    <section class="l-col">
        <layout-toolbar @reload="load"></layout-toolbar>
        <div class="l-container l-flex l-row">
            <layout-aside></layout-aside>
            <router-view class="l-flex"></router-view>
        </div>
    </section>

</template>



<!--
    Scripts
-->

<script>


    // modules

    import Store from '@/common/store';
    import Axios from '@/common/axios';
    import layoutAside from '@/components/layout/aside.vue';
    import layoutToolbar from '@/components/layout/toolbar.vue';


    // helpers

    function preload(to, from, next) {
        Store.commit('filter:reset');
        Store.dispatch('load', {
            endpoint: to.name,
            callback: next
        });
    }


    // exports

    export default {

        components: {
            layoutAside,
            layoutToolbar
        },

        beforeRouteEnter: preload,
        beforeRouteUpdate: preload,

        methods: {

            load () {
                this.$store.dispatch('load', {endpoint: this.$route.name});
            }

        }

    }

</script>
