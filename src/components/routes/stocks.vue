<!--
    Styles
-->

<style>

</style>



<!--
    Template
-->

<template>
    <div>

        <layout-toolbar
                :create="create"
                :reload="load"
                :search="search"
                @input="input">
        </layout-toolbar>

        <layout-aside
                v-if="stocks"
                :data="stocks"
                :active="selected"
                :click="select">
        </layout-aside>

        <layout-content v-if="stocks[selected]">
            <ui-table :data="stocks[selected].content" :search="search"></ui-table>
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
    import uiTable from '@/components/ui/table.vue'


    export default {

        components: {
            uiTable,
            layoutAside,
            layoutToolbar,
            layoutContent,
            layoutError
        },

        data () {
            return {
                error: null,
                stocks: false,
                selected: 0,
                search: ''
            }
        },

        methods: {

            select (index) {
                this.selected = index;
                window.scrollTo(0, 0);
            },

            create () {

            },

            input (value) {
                this.search = value;
            },

            load () {

                this.stocks = false;
                this.error = false;
                this.search = '';
                Event.$emit('loading', true);

                API.stocks()
                    .then((response) => {
                        this.stocks = response.data.data.map(item => {
                            item.content = Util.csvToTable(item.content);
                            return item;
                        });
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
