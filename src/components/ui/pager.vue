<!--
    Styles
-->

<style>

    .ui-pager {
        width: 42px;
    }

    .ui-pager a {
        height: 42px;
        text-align: center;
        padding-top: 11px;
        border-radius: 3px;
        background: var(--bg-white-dark);
        color: var(--color-grey);
        fill: var(--color-grey);
        border: 1px solid transparent;
    }

    .ui-pager a svg {
        margin: 0 auto;
        width: 20px;
        height: 20px;
    }

    .ui-pager a span {
        line-height: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .ui-pager a:hover {
        color: var(--color-red);
        fill: var(--color-red);
    }

    .ui-pager a.active {
        background: #ffffff;
        border-color: var(--bg-red);
        color: var(--color-red);
        fill: var(--color-red);
    }

    .ui-pager a.disabled {
        pointer-events: none;
    }

</style>



<!--
    Template
-->

<template>
    <div class="ui-pager l-col" v-show="pages.length > 1">

        <a :class="{disabled: pager.current === 1}" @click="update(1)">
            <svg-first></svg-first>
        </a>

        <a :class="{disabled: pager.current === 1}" @click="update(pager.current - 1)">
            <svg-prev></svg-prev>
        </a>

        <a v-for="page in pages" :class="{active: page === pager.current}" @click="update(page)">
            <span>{{page}}</span>
        </a>

        <a :class="{disabled: pager.current === pager.total}" @click="update(pager.current + 1)">
            <svg-next></svg-next>
        </a>

        <a :class="{disabled: pager.current === pager.total}" @click="update(pager.total)">
            <svg-last></svg-last>
        </a>

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


    function pages(from, to) {
        let data = [];
        for (let i = from; i <= to; i++) {
            data.push(i);
        }
        return data;
    }

    
    export default {

        components: {
            svgFirst,
            svgLast,
            svgNext,
            svgPrev
        },

        computed: {

            pager () {
                return this.$store.state.pager
            },

            limit () {
                return this.$store.state.filter.limit
            },

            pages () {
                if (this.pager.current < 3) return pages(1, Math.min(this.pager.total, 3));
                if (this.pager.current > this.pager.total - 2) return pages(this.pager.total - 2, this.pager.total);
                return pages(this.pager.current - 1, this.pager.current + 1);
            }

        },

        methods: {

            update (page) {
                this.$store.commit('filter:set', {offset: (page - 1) * this.limit});
                this.$store.commit('pager:current', page);
                this.$store.dispatch('load', {endpoint: this.$route.name});
            }

        }


    }

</script>
