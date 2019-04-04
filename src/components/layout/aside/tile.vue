<!--
    Styles
-->

<style>


    /* main */

    .c-tile {
        background-color: var(--bg-white-dark);
        padding: 24px 30px;
        border: 1px solid transparent;
    }

    .c-tile p.large {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .c-tile p.small {
        color: var(--color-grey-light);
        font-size: 12px;
    }
    .c-tile p.small span:first-child {
        font-weight: 600;
    }


    /* hover state */

    .c-tile:hover p.large {
        color: var(--color-red)
    }
    .c-tile:hover p.small {
        color: var(--color-grey)
    }


    /* active state */

    .c-tile.active {
        position: relative;
        background: var(--bg-grey-light);
    }
    .c-tile.active p.large {
        color: var(--color-red);
    }
    .c-tile.active p.small {
        color: var(--color-grey);
    }


</style>



<!--
    Template
-->

<template>
    <a class="c-tile" :class="{active: item === dataActive && !creating}" @click="activate(item)">
        <p class="large">{{item.shop_id.name}}</p>
        <p class="small">
            <span>{{item.modified_by.first_name}}</span>
            <span>-</span>
            <span>{{item.modified_on}}</span>
        </p>
    </a>
</template>



<!--
    Scripts
-->

<script>

    import {mapGetters, mapActions} from 'vuex';

    export default {

        props: [
            'item'
        ],

        computed: mapGetters('dashboard', [
            'creating',
            'dataActive'
        ]),

        methods: mapActions('dashboard', [
            'activate'
        ])

    }

</script>
