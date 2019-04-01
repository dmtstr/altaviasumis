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

        <div class="scroll l-flex" @scroll="scroll" ref="scroll">

            <ui-tile v-for="(item, index) in items.data"
                     :data="item"
                     :active="index === items.selected"
                     :key="item.id"
                     :style="{marginTop: margin + 'px'}"
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

        data () {
            return {
                top: 0,
                margin: 4,
                height: 0
            }
        },

        computed: {

            items () {
                return this.$store.state.items;
            },

            pager () {
                return this.$store.state.pager;
            },

            limit () {
                return this.$store.state.filter.limit
            }

        },

        mounted () {
            this.$refs.scroll.scrollTop = this.margin;
        },

        methods: {

            select (index) {
                this.$store.commit('items:select', index);
                this.$store.commit('items:create', false);
            },

            test () {
                this.$nextTick(() => {
                    const sh = this.$refs.scroll.scrollHeight;
                    const st = sh - this.height;
                    this.$refs.scroll.scrollTop = st;
                })
            },

            scroll (event) {

                const down = this.$refs.scroll.scrollTop > this.top;
                const first = this.pager.current === 1;
                const last = this.pager.current === this.pager.total;

                const oh = this.$refs.scroll.offsetHeight;
                const st = this.$refs.scroll.scrollTop;
                const sh = this.$refs.scroll.scrollHeight;
                this.top = event.target.scrollTop;

                if (!last && down && oh + st === sh) {
                    this.$store.commit('filter:set', {offset: this.pager.current * this.limit});
                    this.$store.commit('pager:current', this.pager.current + 1);
                    this.$store.dispatch('load', {endpoint: this.$route.name, lazy: 1});
                }
                if (!first && !down && !st) {
                    this.height = sh;
                    this.$store.commit('filter:set', {offset: (this.pager.current - 2) * this.limit});
                    this.$store.commit('pager:current', this.pager.current - 1);
                    this.$store.dispatch('load', {endpoint: this.$route.name, lazy: -1, callback: this.test});

                }
            }

        }

    }

</script>
