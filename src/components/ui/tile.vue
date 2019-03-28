<!--
    Styles
-->

<style>


    /* main */

    .ui-tile {
        background-color: var(--bg-white-dark);
        margin-bottom: 4px;
        padding: 24px 30px;
        border: 1px solid transparent;
    }

    .ui-tile p.large {
        font-size: 18px;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .ui-tile p.small {
        color: var(--color-grey-light);
        font-size: 12px;
    }


    /* hover state */

    .ui-tile:hover p.large {
        color: var(--color-red)
    }
    .ui-tile:hover p.small {
        color: var(--color-grey)
    }


    /* active state */

    .ui-tile.active {
        position: relative;
        background: var(--bg-grey-light);
    }
    .ui-tile.active p.large {
        color: var(--color-red);
    }
    .ui-tile.active p.small {
        color: var(--color-grey);
    }
    
</style>



<!--
    Template
-->

<template>
    <a class="ui-tile" :class="{active: active}">
        
        <p class="large t-bold">{{data.shop_id.name}}</p>

        <p class="small">
            <span class="t-bold">{{data.modified_by.first_name}}</span>
            <span>-</span>
            <span>{{data.modified_on}}</span>
        </p>
        
    </a>
</template>



<!--
    Scripts
-->

<script>
    
    export default {

        props: [
            'data',
            'active'
        ]

    }

</script>
