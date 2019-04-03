<!--
    Styles
-->

<style>

    #app {
        height: 100%;
    }

</style>



<!--
    Template
-->

<template>
    <div id="app" class="l-col">
        <layout-header></layout-header>
        <router-view class="l-flex"></router-view>
    </div>
</template>



<!--
    Scripts
-->

<script>


    import layoutHeader from '@/components/layout/header/index.vue'


    export default {

        components: {
            layoutHeader
        }

    }

</script>
