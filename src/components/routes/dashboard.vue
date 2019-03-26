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

        Here

        <router-view @init="init" @load="load"></router-view>

        <!-- toolbar -->

        <!--<layout-toolbar-->
                <!--:create="create"-->
                <!--:reload="load"-->
                <!--:filter="filter"-->
                <!--@filter="load">-->
        <!--</layout-toolbar>-->


        <!--&lt;!&ndash; content &ndash;&gt;-->

        <!--<article class="l-container l-flex l-row" v-show="!error">-->

            <!--<layout-aside-->
                    <!--:data="orders"-->
                    <!--:meta="meta"-->
                    <!--:active="selected"-->
                    <!--@select="select">-->
            <!--</layout-aside>-->
            <!---->
            <!--<router-view -->
                    <!--class="l-flex">                -->
            <!--</router-view>-->

        <!--</article>-->


    </section>
</template>



<!--
    Scripts
-->

<script>

    export default {

        props: [
            'test'
        ],



        methods: {

            init (test) {
                console.log(test)
            },

            load (next, what) {
                console.log('loading', what);
                setTimeout(next, 1000);
            }

        }

    }

</script>
