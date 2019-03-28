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

        <div class="scroll l-flex" @scroll="load" ref="scroll">
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
            },

            last () {
                const total = this.$store.state.pager.total;
                const offset = this.$store.state.pager.offset;
                return total - offset < 200;
            },

            first () {
                return this.$store.state.pager.offset;
            }

        },

        watch: {

            'items.data' () {
                this.$refs.scroll.scrollTop = 0;
            }

        },

        methods: {

            select (index) {
                this.$store.commit('items:select', index);
            },

            load () {

                if (!this.last && this.$refs.scroll.offsetHeight + this.$refs.scroll.scrollTop === this.$refs.scroll.scrollHeight) {
                    return this.$store.commit('pager', {offset: (this.$store.state.pager.offset || 0) + 200});
                }

            }

        }

    }

</script>
