<!--
    Styles
-->

<style scoped>

    .ui-address {
        padding-bottom: 30px;
    }

</style>



<!--
    Template
-->

<template>
    <section class="l-col">


        <!-- toolbar -->

        <layout-toolbar
                :create="create"
                :reload="load"
                :filter="filter"
                @filter="load">
        </layout-toolbar>


        <!-- error -->

        <article class="l-container l-flex" v-show="error">
            <layout-error :error="error"></layout-error>
        </article>


        <!-- content -->

        <article class="l-container l-flex l-row" v-show="!error">

           <layout-aside
               :data="orders"
               :active="selected"
               :click="select">
           </layout-aside>

            <div class="l-col l-flex" v-if="selected > -1 && orders[selected]">
                <ui-address :data="orders[selected].content.address"></ui-address>
                <ui-table class="l-flex" :data="orders[selected].content.order"></ui-table>
            </div>

            <form-order class="l-flex" v-if="selected === -1"></form-order>

        </article>


    </section>
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
    import layoutError from '@/components/layout/error.vue'
    import formOrder from '@/components/forms/order.vue'
    import uiTable from '@/components/ui/table.vue'
    import uiAddress from '@/components/ui/address.vue'


    const parse = item => {
        item.content = JSON.parse(item.content);
        item.content.order = Util.arrayToTable(item.content.order);
        return item;
    };


    export default {

        components: {
            layoutAside,
            layoutToolbar,
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
                        Event.$emit('loading', false);
                        this.orders = response.data.data.map(parse);
                        if (this.orders.length) this.select(0);
                        else this.error = 'No results';
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
