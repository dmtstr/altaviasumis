<!--
    Styles
-->

<style>
    #header {
        z-index: 3;
    }
    #toolbar {
        z-index: 4;
    }
    #aside {
        z-index: 2;
    }
    #content {
        z-index: 1;
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