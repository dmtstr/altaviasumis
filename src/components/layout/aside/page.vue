<!--
    Styles
-->

<style>

    .c-page .number {
        position: relative;
        border-top: 1px solid var(--bg-border);
        margin: 20px auto;
        width: 90%;
    }
    .c-page .number span {
        font-size: 10px;
        padding: 0 10px;
        color: var(--color-grey-light);
        background: var(--bg-white);
    }

    .c-page:first-child .number {
        display: none;
    }

</style>



<!--
    Template
-->

<template>
    <div class="c-page">
        <div class="number">
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
                    if (this.pager.offset === this.page) return;
                    if (this.$el.offsetTop < view.st + view.oh) this.move(this.page);
                }
            }

        },

        methods: mapActions('dashboard', [
            'move'
        ]),

    }

</script>
