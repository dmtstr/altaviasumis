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


            <ui-create></ui-create>


            <ui-tab v-for="(order, index) in orders"
                    :large="order.customer_id"
                    :small="order.content.BODY.HEAD.ORDER_NO + ' / ' + order.state"
                    :active="index === selected"
                    :key="index"
                    @click.native="select(index)">
            </ui-tab>
        </div>

        <div class="l-ff">
            <ui-sidebar>
                <pre>{{orders[selected]}}</pre>
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
    import uiCreate from '@/components/ui/create.vue'

    export default {

        components: {
            uiTab,
            uiSidebar,
            uiCreate
        },

        data () {
            return {
                error: null,
                orders: false,
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

            API.orders()
                .then((response) => {
                    this.orders = response.data;
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
