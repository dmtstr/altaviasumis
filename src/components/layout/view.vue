<!--
    Styles
-->

<style>

    #view {
        position: relative;
        top: 72px;
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
    #view > * {
        position: relative;
    }

</style>



<!--
    Template
-->

<template>
    <section id="view" :class="{loading: loading}">
        <router-view class="l-container"></router-view>
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
