<!--
    Styles
-->

<style>

    #app {
        height: 100%;
    }

    #app > .loading {
        position: relative;
    }

    #app > .loading:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

</style>



<!--
    Template
-->

<template>
    <div id="app" class="l-col">
        <ui-loader v-show="loading"></ui-loader>
        <layout-header></layout-header>
        <router-view class="l-flex" :class="{loading: loading}"></router-view>
    </div>
</template>



<!--
    Scripts
-->

<script>

    import layoutHeader from '@/components/layout/header.vue'
    import uiLoader from '@/components/ui/loader.vue'

    export default {

        components: {
            layoutHeader,
            uiLoader
        },

        computed: {
            loading () {
                return this.$store.state.loading;
            }
        }

    }

</script>