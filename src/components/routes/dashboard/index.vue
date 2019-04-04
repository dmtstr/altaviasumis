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

        <form-error class="l-container" :error="error" @repeat="load" v-show="!dataLength"></form-error>

        <div class="l-container l-flex l-row" v-if="dataLength">
            <layout-aside></layout-aside>
            <router-view class="l-flex"></router-view>
        </div>

    </section>
</template>



<!--
    Scripts
-->

<script>


    import {mapGetters, mapActions} from 'vuex';
    import API from '@/common/api'
    import Store from '@/common/store/index'
    import layoutToolbar from '@/components/layout/toolbar/index.vue'
    import layoutAside from '@/components/layout/aside/index.vue'
    import formError from '@/components/forms/error.vue'

    function preload(to, from, next) {
        Store.dispatch('dashboard/init', to.name).then(next);
    }

    export default {

        components: {
            layoutToolbar,
            layoutAside,
            formError
        },

        beforeRouteEnter: preload,
        beforeRouteUpdate: preload,

        data () {
            return {
                error: {
                    code: 404,
                    message: 'No results were found'
                }
            }
        },

        computed: mapGetters('dashboard', [
            'dataLength'
        ]),

        methods: mapActions('dashboard', [
            'load'
        ])

    }

</script>
