<!--
    Styles
-->

<style scoped>

    #content {
        padding-top: 30px;
    }

</style>



<!--
    Template
-->

<template>
    <div>

        <layout-toolbar
                :create="create"
                :reload="load">
        </layout-toolbar>

        <layout-aside
                :data="orders"
                :active="selected"
                :click="select">
        </layout-aside>

        <layout-content>
            <form-order v-show="selected === -1"></form-order>
            <pre v-show="selected > -1">{{orders[selected]}}</pre>
        </layout-content>

    </div>
</template>



<!--
    Scripts
-->

<script>

    import API from '@/common/api'
    import Event from '@/common/event'
    import layoutAside from '@/components/layout/aside.vue'
    import layoutToolbar from '@/components/layout/toolbar.vue'
    import layoutContent from '@/components/layout/content.vue'
    import formOrder from '@/components/forms/order.vue'

    export default {

        components: {
            layoutAside,
            layoutToolbar,
            layoutContent,
            formOrder
        },

        data () {
            return {
                error: null,
                orders: false,
                selected: false
            }
        },

        methods: {

            select (index) {
                this.selected = index;
            },

            create () {
                this.selected = -1;
            },

            load () {

                this.error = null;
                this.orders = false;
                Event.$emit('loading', true);

                API.orders()
                    .then((response) => {
                        this.orders = response.data.data;
                        this.select(0);
                    })
                    .catch((error) => {
                        this.error = error.message;
                    })
                    .then(() => {
                        Event.$emit('loading', false);
                    });

            }

        },

        mounted () {
            this.load();
        }

    }

</script>
