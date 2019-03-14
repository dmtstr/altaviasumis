<!--
    Styles
-->

<style>



</style>



<!--
    Template
-->

<template>
    <div id="orders" class="l-clear">

        <p class="t-red" v-show="error">An error occurred: {{error}}</p>

        <div class="l-fl l-column">
            <ui-tab v-for="(stock, index) in stocks"
                    :data="stock"
                    :active="index === selected"
                    :key="stock.id"
                    @click.native="select(index)">
            </ui-tab>
        </div>

        <div class="l-ff">
            <ui-sidebar>
                <table v-if="stocks[selected]">
                    <tr v-for="row in stocks[selected].content">
                        <td v-for="cell in row">{{cell}}</td>
                    </tr>
                </table>
            </ui-sidebar>
        </div>

    </div>
</template>



<!--
    Scripts
-->

<script>

    import API from '@/common/api'
    import Event from '@/common/event'
    import uiTab from '@/components/ui/tab.vue'
    import uiSidebar from '@/components/ui/sidebar.vue'


    function csvToArray(csv) {
        const rows = csv.replace(/"/g, '').split('\n');
        return rows.map(row => row.split(','))
    }


    export default {

        components: {
            uiTab,
            uiSidebar
        },

        data () {
            return {
                error: null,
                stocks: false,
                selected: 0
            }
        },

        methods: {

            select (index) {
                this.selected = index;
            }

        },

        mounted () {

            Event.$emit('loading', true);

            API.stocks()
                .then((response) => {
                    this.stocks = response.data.data.map(item => {
                        item.content = csvToArray(item.content);
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

    }

</script>
