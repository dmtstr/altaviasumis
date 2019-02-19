<!--
    Styles
-->

<style>
    #app {
    }
</style>



<!--
    Template
-->

<template>
    <div id="app">
        <layout-header></layout-header>
        <layout-view></layout-view>
    </div>
</template>



<!--
    Scripts
-->

<script>

    import layoutHeader from '@/components/layout/header.vue'
    import layoutView from '@/components/layout/view.vue'


    export default {
        components: {
            layoutHeader,
            layoutView
        }
    }

</script>