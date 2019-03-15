<!--
    Styles
-->

<style>

    #orders .ui-table {
        padding-top: 122px;
    }

</style>



<!--
    Template
-->

<template>
    <div id="orders">

        <layout-toolbar
                :create="create"
                :reload="load">
        </layout-toolbar>

        <layout-aside
                :data="orders"
                :active="selected"
                :click="select">
        </layout-aside>

        <layout-content v-if="selected !== false">
            <ui-address v-show="selected > -1" :data="orders[selected].content.address"></ui-address>
            <ui-table v-show="selected > -1" :data="orders[selected].content.order"></ui-table>
            <form-order v-show="selected === -1"></form-order>
        </layout-content>

    </div>
</template>



<!--
    Scripts
-->

<script>

    import API from '@/common/api'
    import Event from '@/common/event'
    import Util from '@/common/util'
    import layoutAside from '@/components/layout/aside.vue'
    import layoutToolbar from '@/components/layout/toolbar.vue'
    import layoutContent from '@/components/layout/content.vue'
    import formOrder from '@/components/forms/order.vue'
    import uiTable from '@/components/ui/table.vue'
    import uiAddress from '@/components/ui/address.vue'


    export default {

        components: {
            layoutAside,
            layoutToolbar,
            layoutContent,
            formOrder,
            uiTable,
            uiAddress
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
                        this.orders = response.data.data.map(item => {
                            item.content = JSON.parse(item.content);
                            item.content.order = Util.arrayToTable(item.content.order);
                            return item;
                        });
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
