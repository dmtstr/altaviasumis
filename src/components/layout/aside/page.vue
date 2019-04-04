<!--
    Styles
-->

<style>


    /* main */

    .c-page {
        padding-top: 4px;
    }


    /* number */

    .c-page .number {
        position: relative;
        height: 32px;

    }
    .c-page .number span {
        font-size: 10px;
        padding: 0 10px;
        color: var(--color-grey-light);
        background: var(--bg-white);
    }
    .c-page .number .line {
        border-top: 1px solid var(--bg-border);
        width: 90%;
    }


    /* tile */

    .c-page .c-tile {
        margin-top: 4px;
    }


    /* first page */

    .c-page:first-child .number {
        display: none;
    }
    .c-page:first-child .number + .c-tile {
        margin-top: 0;
    }


</style>



<!--
    Template
-->

<template>
    <div class="c-page">
        <div class="number">
            <div class="line l-center"></div>
            <span class="l-center">{{number}}</span>
        </div>
        <slot></slot>
    </div>
</template>



<!--
    Scripts
-->

<script>


    import {mapState, mapActions} from 'vuex';

    
    export default {

        props: [
            'page',
            'view'
        ],

        computed: {

            ...mapState('dashboard', [
                'pager'
            ]),

            number () {
                return this.pager.active + this.page;
            }

        },

        watch: {

            view: {
                deep: true,
                handler (view) {
                    const y11 = this.$el.offsetTop;
                    const y12 = y11 + this.$el.offsetHeight;
                    const y21 = view.st;
                    const y22 = y21 + view.oh;
                    const h = Math.min(y12, y22) - Math.max(y11, y21);
                    if (h > view.oh / 2) this.move(this.page);
                }
            }

        },

        methods: mapActions('dashboard', [
            'move'
        ]),

    }

</script>
