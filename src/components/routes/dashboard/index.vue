<!--
    Styles
-->

<style>

    .r-dashboard > .c-toolbar {
        position: relative;
        z-index: 2;
    }
    .r-dashboard > .l-container {
        position: relative;
        padding-top: 30px;
        padding-bottom: 30px;
        z-index: 1;
    }

</style>



<!--
    Template
-->

<template>
    <section class="r-dashboard l-col">
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


    import API from '@/common/api'
    import Store from '@/common/store/index'
    import layoutToolbar from '@/components/layout/toolbar/index.vue'
    import layoutAside from '@/components/layout/aside/index.vue'

    function preload(to, from, next) {
        Store.dispatch('dashboard/init', to.name).then(next);
    }

    export default {

        components: {
            layoutToolbar,
            layoutAside
        },

        beforeRouteEnter: preload,
        beforeRouteUpdate: preload,

        methods: {

            load () {
                Store.dispatch('dashboard/load');
            }

        }

    }

</script>
