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
        <layout-view class="l-flex"></layout-view>
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