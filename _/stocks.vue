<!--
    Styles
-->

<style>

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
                    :data="stocks"
                    :active="selected"
                    :click="select">
            </layout-aside>

            <ui-table class="l-flex" v-if="stocks[selected]" :data="stocks[selected].content"></ui-table>

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
    import uiTable from '@/components/ui/table.vue'


    const parse = item => {
        item.content = Util.csvToTable(item.content);
        return item;
    };


    export default {

        components: {
            uiTable,
            layoutAside,
            layoutToolbar,
            layoutError
        },

        data () {
            return {
                error: null,
                selected: false,
                stocks: [],
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

            },

            input (value) {
                this.search = value;
            },

            load (query, field) {

                this.error = null;

                API.abort();
                Event.$emit('loading', true);

                API.stocks(query, field)
                    .then((response) => {
                        Event.$emit('loading', false);
                        this.stocks = response.data.data.map(parse);
                        if (this.stocks.length) this.select(0);
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
