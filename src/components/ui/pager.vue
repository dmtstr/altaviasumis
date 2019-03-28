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

</style>



<!--
    Template
-->

<template>
    <div class="ui-pager l-col">
        <a class="icon">
            <svg-first></svg-first>
        </a>
        <a class="icon">
            <svg-prev></svg-prev>
        </a>
        <a class="">
            <span>1</span>
        </a>
        <a class="active">
            <span>2</span>
        </a>
        <a class="">
            <span>13</span>
        </a>
        <a class="icon">
            <svg-next></svg-next>
        </a>
        <a class="icon">
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
    
    export default {

        components: {
            svgFirst,
            svgLast,
            svgNext,
            svgPrev
        },


    }

</script>
