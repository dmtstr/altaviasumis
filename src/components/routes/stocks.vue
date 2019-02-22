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
                    :large="stock.CustItem"
                    :small="stock.StckStatus"
                    :active="index === selected"
                    :key="index"
                    @click.native="select(index)">
            </ui-tab>
        </div>

        <div class="l-ff">
            <ui-sidebar>
                <pre>{{stocks[selected]}}</pre>
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
                    this.stocks = response.data.StockUpdate;
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
