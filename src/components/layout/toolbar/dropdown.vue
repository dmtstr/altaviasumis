<!--
    Styles
-->

<style>


    /* main */

    .c-dropdown {
        position: relative;
        padding: 0 20px;
    }


    /* current */

    .c-dropdown .current {
        line-height: 42px;
        font-size: 12px;
        color: var(--color-grey);
    }
    .c-dropdown .current.selected {
        color: var(--color-black);
    }
    .c-dropdown .current:hover {
        color: var(--color-red);
    }
    .c-dropdown .current.active {
        color: var(--color-red);
    }
    .c-dropdown .current .arrow {
        width: 14px;
        text-align: right;
    }


    /* popup */

    .c-dropdown .popup {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: -2px;
        padding-top: 2px;
        background: var(--bg-white);
        border-radius: 0 0 3px 3px;
        box-shadow: var(--shadow);
    }
    .c-dropdown .popup .line {
        height: 1px;
        background: var(--bg-border);
    }
    .c-dropdown .popup .options {
        padding: 12px 34px 12px 20px;
    }


    /* popup links */

    .c-dropdown .popup a {
        white-space: nowrap;
        font-size: 12px;
        padding: 6px 0;
        color: var(--color-grey);
    }
    .c-dropdown .popup a:hover {
        color: var(--color-red);
    }
    .c-dropdown .popup a.active {
        color: var(--color-black);
    }


</style>



<!--
    Template
-->

<template>
    <div class="c-dropdown">

        <a class="current l-clear" :class="{selected: filterField, active: popup}" @click="toggle">
            <span class="l-fl">{{fields[filterField]}}</span>
            <span class="l-fl arrow">&#x25BE;</span>
        </a>

        <div class="popup" v-show="popup">
            <div class="line"></div>
            <div class="options">
                <a v-for="(name, field) in fields" :class="{active: field === filterField}" @click="activate({field})">{{name}}</a>
            </div>
        </div>

    </div>
</template>



<!--
    Scripts
-->

<script>

    import {mapGetters, mapActions} from 'vuex';

    export default {

        data () {
            return {
                popup: false,
                fields: {
                    ''            : 'All fields',
                    'content'     : 'Content',
                    'shop_id.name': 'Shop name'
                }
            }
        },

        computed: mapGetters('dashboard', [
            'filterField'
        ]),

        methods: {

            ...mapActions('dashboard', [
                'filter'
            ]),

            toggle () {
                this.popup = !this.popup;
            },

            activate (field) {
                this.popup = false;
                this.filter(field);
            }

        }

    }

</script>
