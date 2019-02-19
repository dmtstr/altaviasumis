<!--
    Styles
-->

<style>

</style>



<!--
    Template
-->

<template>
    <div id="stocks" class="l-clear">
        <p class="t-red" v-show="error">An error occurred: {{error}}</p>
        <div class="l-fl t-black">
            <p>{{stocks.CustNum}}</p>
        </div>
        <pre class="l-ff" v-show="stocks">{{stocks}}</pre>
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
                stocks: false
            }
        },

        mounted () {

            Event.$emit('loading', true);

            API.stocks()
                .then((response) => {
                    this.stocks = response.data;
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
