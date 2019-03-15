<!--
    Styles
-->

<style>

    #view > * {
        position: relative;
    }
    #view.loading {
        position: relative;
    }
    #view.loading:after {
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
    <section id="view" class="l-container" :class="{loading: loading}">
        <router-view></router-view>
    </section>
</template>



<!--
    Scripts
-->

<script>

    import Event from '@/common/event';

    export default {
        data() {
            return {
                loading: false
            }
        },
        mounted() {
            Event.$on('loading', value => this.loading = value);
        }
    }

</script>
