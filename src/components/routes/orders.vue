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
        <div class="l-fl t-black">
            <p v-for="order in orders">{{order.customer_id}} / {{order.content.BODY.HEAD.ORDER_NO}} / {{order.state}}</p>
        </div>
        <pre class="l-ff" v-show="orders">{{orders}}</pre>
    </div>
</template>



<!--
    Scripts
-->

<script>

    import API from '@/common/api'
    import Event from '@/common/event'

    export default {

        data () {
            return {
                error: null,
                orders: false
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
                })


        }

    }

</script>
