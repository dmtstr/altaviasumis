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

    import API from '@/common/api';
    import Store from '@/common/store';
    import Axios from '@/common/axios';
    import layoutAside from '@/components/layout/aside.vue';
    import layoutToolbar from '@/components/layout/toolbar.vue';


    // configs

    const Config = {

        orders: {
            API: API.orders
        },

        stocks: {
            API: API.stocks
        }

    };


    // helpers

    async function preload(key, callback) {
        Store.commit('loading', true);
        const config = Config[key];
        const response = await config.API(Store.getters.params);
        const data = response.data.data;
        const meta = response.data.meta;
        Store.commit('loading', false);
        Store.commit('items:update', data);
        Store.commit('items:select', 0);
        Store.commit('filter:set', {count: meta.result_count, total: meta.total_count});
        callback && callback();
    }


    // exports

    export default {

        components: {
            layoutAside,
            layoutToolbar
        },

        beforeRouteEnter (to, from, next) {
            Store.commit('filter:reset');
            preload(to.name, next);

        },

        beforeRouteUpdate (to, from, next) {
            this.watch = false;
            Store.commit('filter:reset');
            preload(to.name, next);
        },

        data () {
            return {
                watch: true
            }
        },

        computed: {

            params () {
                return this.$store.getters.params;
            }

        },

        watch: {

            params () {
                this.load();
            },

            $route () {
                this.watch = true;
            }

        },


        methods: {

            load () {
                if (!this.watch) return;
                console.log(this.params);
                Axios.abort();
                preload(this.$route.name);
            }

        }

    }

</script>
