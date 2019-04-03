<!--
    Styles
-->

<style>

    .c-toolbar {
        height: 106px;
        background: var(--bg-black);
        padding: 32px 0;
    }

    .c-toolbar .actions .secondary {
        margin-right: 12px;
    }

    .c-toolbar .search {
        padding-right: 0;
        padding-left: 16px;
        background: var(--color-white);
        border: none;
    }
    .c-toolbar .search svg {
        width: 20px;
        height: 20px;
        margin: 11px 8px 0 0;
        fill: var(--color-grey);
    }
    .c-toolbar .search input[type=text] {
        height: 42px;
        padding: 0;
        background: none;
        border: none;
        color: var(--color-black);
    }

</style>



<!--
    Template
-->

<template>
    <div class="c-toolbar">
        <div class="l-container l-row">


            <!-- actions -->

            <div class="actions l-aside l-clear">

                <a class="l-fl f-button secondary" @click="$emit('reload')">
                    <svg-reload></svg-reload>
                </a>
                <a class="l-ff f-button primary">
                    <svg-plus></svg-plus>
                    <span>Create</span>
                </a>
            </div>


            <!-- search -->

            <div class="search f-input l-flex">
                <toolbar-dropdown class="l-fr"></toolbar-dropdown>
                <svg-search class="l-fl"></svg-search>
                <div class="l-ff">
                    <input type="text" class="f-input" placeholder="Search..." :value="filterQuery" @input="input"/>
                </div>
            </div>


        </div>
    </div>
</template>



<!--
    Scripts
-->

<script>

    import {mapGetters, mapActions} from 'vuex';

    import svgPlus from '@/assets/icons/plus.svg';
    import svgReload from '@/assets/icons/reload.svg';
    import svgSearch from '@/assets/icons/search.svg';
    import toolbarDropdown from './dropdown.vue';

    export default {

        components: {
            svgPlus,
            svgReload,
            svgSearch,
            toolbarDropdown
        },

        computed: mapGetters('dashboard', [
            'filterQuery'
        ]),

        methods: {

            ...mapActions('dashboard', [
                'filter'
            ]),

            input (event) {
                this.filter({query: event.target.value});
            }

        }


    }

</script>
