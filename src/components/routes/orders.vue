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
                :reload="load"
                :filter="filter"
                @filter="load">
        </layout-toolbar>

        <layout-aside
                :data="orders"
                :active="selected"
                :click="select">
        </layout-aside>

        <layout-content v-if="selected !== false">
            <div class="l-content" v-if="selected > -1 && orders[selected]">
                <ui-address :data="orders[selected].content.address"></ui-address>
                <ui-table :data="orders[selected].content.order"></ui-table>
            </div>
            <form-order v-show="selected === -1"></form-order>
        </layout-content>

        <layout-error
                v-if="error"
                :error="error">
        </layout-error>

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
    import layoutError from '@/components/layout/error.vue'
    import formOrder from '@/components/forms/order.vue'
    import uiTable from '@/components/ui/table.vue'
    import uiAddress from '@/components/ui/address.vue'


    export default {

        components: {
            layoutAside,
            layoutToolbar,
            layoutContent,
            layoutError,
            formOrder,
            uiTable,
            uiAddress
        },

        data () {
            return {
                error: null,
                selected: false,
                orders: [],
                filter: {
                    query: '',
                    active: '',
                    fields: {
                        '': 'All fields',
                        'content': 'Content',
                        'shop_id.name': 'Shop name'
                    }
                }
            }
        },

        methods: {

            select (index) {
                this.selected = index;
            },

            create () {
                this.selected = -1;
            },

            load (query, field) {

                this.error = null;

                API.abort();
                Event.$emit('loading', true);

                API.orders(query, field)
                    .then((response) => {
                        this.orders = response.data.data.map(item => {
                            item.content = JSON.parse(item.content);
                            item.content.order = Util.arrayToTable(item.content.order);
                            return item;
                        });
                        this.select(0);
                        Event.$emit('loading', false);
                    })
                    .catch((error) => {
                        if (!error.message) return;
                        this.error = error.message;
                        Event.$emit('loading', false);
                    })

            }

        },

        mounted () {
            this.load();
        }

    }

</script>
