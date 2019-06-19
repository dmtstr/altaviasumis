<!--
    Styles
-->

<style>


    /* main */

    .c-tile {
        background-color: var(--bg-white-dark);
        padding: 16px 24px;
        border: 1px solid transparent;
    }

    .c-tile p.large {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
        text-transform: uppercase;
    }
    .c-tile p.small {
        color: var(--color-grey-light);
        font-size: 11px;
        line-height: 14px;
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
        <p class="large">{{item[config.title]}}</p>
        <p class="small" v-for="field in config.fields">{{field}}: <b>{{item[field]}}</b></p>
    </a>
</template>



<!--
    Scripts
-->

<script>

    import {mapGetters, mapActions} from 'vuex';

    export default {

        props: [
            'item',
            'config'
        ],

        computed: mapGetters('dashboard', [
            'creating',
            'dataActive',
            'route'
        ]),

        methods: mapActions('dashboard', [
            'activate'
        ])

    }

</script>
