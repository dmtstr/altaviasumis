<!--
    Styles
-->

<style>



    /* main */

    #aside {

    }

    #aside .pages {
        position: fixed;
        left: 570px;
        width: 240px;
        margin-top: 20px;
        transform: rotate(90deg) translateX(-20px);
        transform-origin: 0 0;
        /*border-top: 1px solid var(--bg-border);*/
        /*padding-top: 20px;*/
    }

    #aside .pages .table {

        display: table;
        table-layout: fixed;
        width: 100%;
        height: 42px;
        border-collapse: collapse;
        border-radius: 3px;
        overflow: hidden;
    }
    #aside .pages a {

        /*padding-top: 20px;*/
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        color: var(--color-black);
        background: var(--bg-grey-light);
        /*border: 1px solid var(--bg-white-dark);*/
        /*border-radius: 3px;*/
        font-size: 12px;
    }

    /*#aside .pages a.icon {*/
        /*background: var(--bg-black);*/
    /*}*/

    #aside .pages a svg {
        width: 16px;
        height: 16px;
        display: inline-block;
        fill: #000;
    }


    #aside .pages a:hover,
    #aside .pages a.active {

        /*background: var(--bg-grey-light);*/
        /*border: 1px solid var(--bg-red);*/
        color: var(--color-red);

    }

    #aside .scroll {
        overflow-y: scroll;
    }


    /* link */

    #aside .scroll a {
        background-color: var(--bg-white-dark);
        margin-bottom: 4px;
        padding: 24px 30px;
        border: 1px solid transparent;
    }

    #aside .scroll a p.large {
        font-size: 18px;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    #aside .scroll a p.small {
        color: var(--color-grey-light);
        font-size: 12px;
    }


    /* hover state */

    #aside .scroll a:hover p.large {
        color: var(--color-red)
    }
    #aside .scroll a:hover p.small {
        color: var(--color-grey)
    }


    /* active state */

    #aside .scroll a.active {
        position: relative;
        background: var(--bg-grey-light);
    }
    #aside .scroll a.active p.large {
        color: var(--color-red);
    }
    #aside .scroll a.active p.small {
        color: var(--color-grey);
    }


    /* scrollbar */

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
    <div id="aside" class="l-aside l-col">




        <div class="scroll l-flex" ref="scroll">
            <a v-for="(item, index) in data"
               :class="{active: index === active}"
               :key="item.id"
               @click="select(index)">

                <p class="large t-bold">{{item.shop_id.name}}</p>

                <p class="small">
                    <span class="t-bold">{{item.modified_by.first_name}}</span>
                    <span>-</span>
                    <span>{{item.modified_on}}</span>
                </p>

            </a>
        </div>

        <div class="pages" :style="{'padding-right': scroll}">
            <div class="table">
                <a class="icon">
                    <svg-first></svg-first>
                </a>
                <a class="icon">
                    <svg-prev></svg-prev>
                </a>
                <a class="">1</a>
                <a class="active">2</a>
                <a class="">3</a>
                <a class="icon">
                    <svg-next></svg-next>
                </a>
                <a class="icon">
                    <svg-last></svg-last>
                </a>
            </div>
        </div>



    </div>
</template>



<!--
    Scripts
-->

<script>

    import svgFirst from '@/assets/icons/first.svg';
    import svgLast from '@/assets/icons/last.svg';
    import svgNext from '@/assets/icons/next.svg';
    import svgPrev from '@/assets/icons/prev.svg';

    export default {

        components: {
            svgFirst,
            svgLast,
            svgNext,
            svgPrev
        },

        props: [
            'data',
            'active',
            'meta'
        ],

        data () {

            return {
                scroll: 0
            }

        },


        methods: {

            select (index) {
                this.$emit('select', index)
            }

        },

        watch: {

            meta (value) {
                console.log(value)
            }

        },

        mounted () {
            const $scroll = this.$refs.scroll;
            const $child = document.createElement('div');
            $scroll.appendChild($child);
            this.scroll = $scroll.offsetWidth - $child.offsetWidth + 'px';
            $scroll.removeChild($child);
        }


    }

</script>
