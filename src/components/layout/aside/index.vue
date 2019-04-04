<!--
    Styles
-->

<style>

    .c-aside .pager {
        margin-right: 12px;
    }
    .c-aside .scroll {
        overflow-y: scroll;
        position: relative;
    }
    .c-aside .scroll::-webkit-scrollbar {
        -webkit-appearance: none;
    }
    .c-aside .scroll::-webkit-scrollbar:vertical {
        width: 12px;
    }
    .c-aside .scroll::-webkit-scrollbar-thumb {
        border-radius: 8px;
        border: 4px solid var(--bg-white);
        background-color: var(--bg-grey-light);
    }

    
</style>



<!--
    Template
-->

<template>
    <aside class="c-aside l-aside l-row">

        <aside-pager class="pager"></aside-pager>

        <div class="scroll l-flex"
             @scroll="scroll"
             ref="scroll">

            <aside-page v-for="(page, index) in dataChunk" :key="index" :page="index" :view="view">
                <aside-tile v-for="item in page" :item="item" :key="item.id"></aside-tile>
            </aside-page>

        </div>
    </aside>
</template>



<!--
    Scripts
-->

<script>


    // imports

    import {mapActions, mapGetters} from 'vuex';
    import Util from '@/common/util';
    import asidePage from './page.vue'
    import asidePager from './pager.vue'
    import asideTile from './tile.vue'


    export default {

        components: {
            asidePage,
            asidePager,
            asideTile
        },

        data () {
            return {
                view: {
                    st: 0,
                    sh: 0,
                    oh: 0
                }
            }
        },

        computed: mapGetters('dashboard', [
            'dataChunk',
            'dataLazy',
            'pagerCurrent',
            'pagerTotal'
        ]),

        watch: {

            'dataChunk': {
                immediate: true,
                handler () {
                    this.$nextTick(this.align);
                }
            }

        },

        methods: {

            ...mapActions('dashboard', [
                'lazy'
            ]),

            align () {
                const $scroll =  this.$refs.scroll;
                if (!this.dataLazy) $scroll.scrollTop = 4;
                if (this.dataLazy === -1) $scroll.scrollTop = $scroll.scrollHeight - this.view.sh;
            },

            scroll () {
                const $scroll = this.$refs.scroll;
                const oh = $scroll.offsetHeight;
                const st = $scroll.scrollTop;
                const sh = $scroll.scrollHeight;
                const down = st > this.view.st;
                const first = this.pagerCurrent === 1;
                const last = this.pagerCurrent === this.pagerTotal;
                this.view.st = st;
                this.view.sh = sh;
                this.view.oh = oh;
                if (!last && down && oh + st === sh) this.lazy(1);
                if (!first && !down && !st) this.lazy(-1);
            }

        }
    }

</script>
