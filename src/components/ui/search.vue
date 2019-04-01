<!--
    Styles
-->

<style>

    .ui-search svg {
        width: 20px;
        height: 20px;
        margin: 10px;
    }
    .ui-search input[type=text] {
        height: 40px;
        padding: 0;
        background: none;
        border: none;
    }
    
</style>



<!--
    Template
-->

<template>
    <div class="ui-search frame l-clear">
        <svg-search class="l-fl"></svg-search>
        <ui-dropdown class="l-fr"></ui-dropdown>
        <div class="l-ff">
            <input type="text" placeholder="Search..." v-model="query" @focus="focus = true" @blur="focus = false"/>
        </div>
    </div>
</template>



<!--
    Scripts
-->

<script>

    import svgSearch from '@/assets/icons/search.svg';
    import uiDropdown from '@/components/ui/dropdown.vue';

    export default {

        components: {
            svgSearch,
            uiDropdown
        },

        computed: {
            query: {
                get () {
                    return this.$store.state.filter.query
                },
                set (query) {
                    this.$store.commit('filter:set', {query: query, offset: 0});
                    this.$store.commit('pager:current', 1);
                    this.$store.dispatch('load', {endpoint: this.$route.name});
                }
            }
        }

    }

</script>
