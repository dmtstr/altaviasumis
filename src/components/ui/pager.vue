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
    <div class="ui-pager l-col">

        <a :class="{disabled: current === 1}" @click="update(1)">
            <svg-first></svg-first>
        </a>

        <a :class="{disabled: current === 1}" @click="update(current - 1)">
            <svg-prev></svg-prev>
        </a>

        <a v-for="page in pages" :class="{active: page === current}" @click="update(page)">
            <span>{{page}}</span>
        </a>

        <a :class="{disabled: current === total}" @click="update(current + 1)">
            <svg-next></svg-next>
        </a>

        <a :class="{disabled: current === total}" @click="update(total)">
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

            total () {
                return Math.ceil(this.$store.state.pager.total / 200);
            },

            current () {
                return (this.$store.state.pager.offset || 0) / 200 + 1;
            },

            pages () {

                if (this.total === 1) return [];
                if (this.total === 2) return [1, 2];
                if (this.current < 3) return pages(1, 3);
                if (this.current > this.total - 2) return pages(this.total - 2, this.total);
                return pages(this.current - 1, this.current + 1);

            }

        },

        methods: {

            update (page) {
                this.$store.commit('pager', {offset: (page - 1) * 200})
            }

        }


    }

</script>
