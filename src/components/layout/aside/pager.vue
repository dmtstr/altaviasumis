<!--
    Styles
-->

<style>

    .c-pager {
        width: 42px;
        border-radius: 3px;
        overflow: hidden;
    }

    .c-pager a {
        height: 42px;
        text-align: center;
        padding-top: 11px;
        background: var(--bg-white-dark);
        color: var(--color-grey);
        fill: var(--color-grey);
        border: 1px solid transparent;
    }

    .c-pager a svg {
        margin: 0 auto;
        width: 20px;
        height: 20px;
    }

    .c-pager a span {
        line-height: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .c-pager a:hover {
        color: var(--color-red);
        fill: var(--color-red);
    }

    .c-pager a.active {
        background: #ffffff;
        border-radius: 3px;
        border-color: var(--bg-red);
        color: var(--color-red);
        fill: var(--color-red);
    }

    .c-pager a.disabled {
        pointer-events: none;
    }

</style>



<!--
    Template
-->

<template>
    <div class="c-pager" v-show="pagerPages.length > 1">

        <a :class="{disabled: pagerCurrent === 1}" @click="flip(1)">
            <svg-first></svg-first>
        </a>

        <a :class="{disabled: pagerCurrent === 1}" @click="flip(pagerCurrent - 1)">
            <svg-prev></svg-prev>
        </a>

        <a v-for="page in pagerPages" :class="{active: page === pagerCurrent}" @click="flip(page)">
            <span>{{page}}</span>
        </a>

        <a :class="{disabled: pagerCurrent === pagerTotal}" @click="flip(pagerCurrent + 1)">
            <svg-next></svg-next>
        </a>

        <a :class="{disabled: pagerCurrent === pagerTotal}" @click="flip(pagerTotal)">
            <svg-last></svg-last>
        </a>

    </div>
</template>



<!--
    Scripts
-->

<script>


    // imports

    import {mapGetters, mapState, mapActions} from 'vuex';
    import svgFirst from '@/assets/icons/first.svg';
    import svgLast from '@/assets/icons/last.svg';
    import svgNext from '@/assets/icons/next.svg';
    import svgPrev from '@/assets/icons/prev.svg';


    // exports

    export default {

        components: {
            svgFirst,
            svgLast,
            svgNext,
            svgPrev
        },

        computed: mapGetters('dashboard', [
            'pagerCurrent',
            'pagerTotal',
            'pagerPages'
        ]),

        methods: mapActions('dashboard', [
            'flip'
        ])


    }

</script>
