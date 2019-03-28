<!--
    Styles
-->

<style>

    #aside .ui-pager {
        margin-right: 12px;
    }
    #aside .scroll {
        overflow-y: scroll;
    }


    #aside .scroll::-webkit-scrollbar {
        -webkit-appearance: none;
    }
    #aside .scroll::-webkit-scrollbar:vertical {
        width: 12px;
    }
    #aside .scroll::-webkit-scrollbar-thumb {
        border-radius: 8px;
        border: 4px solid var(--bg-white);
        background-color: var(--bg-grey-light);
    }

</style>



<!--
    Template
-->

<template>
    <div id="aside" class="l-aside l-row">

        <ui-pager></ui-pager>

        <div class="scroll l-flex">
            <ui-tile v-for="(item, index) in items.data"
                     :data="item"
                     :active="index === items.selected"
                     :key="item.id"
                     @click.native="select(index)">
            </ui-tile>
        </div>

    </div>
</template>



<!--
    Scripts
-->

<script>


    import uiPager from '@/components/ui/pager.vue';
    import uiTile from '@/components/ui/tile.vue';


    export default {

        components: {
            uiPager,
            uiTile
        },

        computed: {
            items () {
                return this.$store.state.items;
            }
        },

        methods: {

            select (index) {
                this.$store.commit('items:select', index);
            }

        }

    }

</script>
