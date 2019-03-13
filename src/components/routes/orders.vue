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
        <ui-create @click.native="select(-1)" :active="selected === -1"></ui-create>

        <div class="l-fl l-column">
            <ui-tab v-for="(order, index) in orders"
                    :data="order"
                    :active="index === selected"
                    :key="order.id"
                    @click.native="select(index)">
            </ui-tab>
        </div>

        <div class="l-ff">
            <ui-sidebar ref="sidebar">
                <form-order v-show="selected === -1"></form-order>
                <pre v-show="selected > -1">{{orders[selected]}}</pre>
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
    import formOrder from '@/components/forms/order.vue'

    export default {

        components: {
            uiTab,
            uiSidebar,
            uiCreate,
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
                this.$refs.sidebar.scroll();
            }

        },

        mounted () {

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

    }

</script>
