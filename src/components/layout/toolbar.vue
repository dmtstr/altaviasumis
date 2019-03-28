<!--
    Styles
-->

<style>

    #toolbar {
        height: 106px;
        background: var(--bg-black);
        padding: 32px 0;
    }

    #toolbar .l-aside .secondary {
        margin-right: 12px;
    }

</style>



<!--
    Template
-->

<template>
    <div id="toolbar">
        <div class="l-container l-row">


            <!-- aside -->

            <div class="l-aside l-clear">

                <a class="l-fl button secondary" @click="$emit('reload')">
                    <svg-reload></svg-reload>
                </a>

                <a class="l-ff button primary" @click="create">
                    <svg-plus></svg-plus>
                    <span>Create</span>
                </a>

            </div>


            <!-- search -->

            <ui-search class="l-flex"></ui-search>


        </div>
    </div>
</template>



<!--
    Scripts
-->

<script>

    import svgPlus from '@/assets/icons/plus.svg';
    import svgReload from '@/assets/icons/reload.svg';
    import uiSearch from '@/components/ui/search.vue';

    export default {

        components: {
            svgPlus,
            svgReload,
            uiSearch
        },

        methods: {

            create () {
                this.$store.commit('items:select', -1);
            }

        }

    }

</script>
