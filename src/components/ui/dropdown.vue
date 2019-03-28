<!--
    Styles
-->

<style>

    .ui-dropdown {
        position: relative;
        padding: 0 20px;
    }


    /* dropdown .current */

    .ui-dropdown .current {
        line-height: 40px;
        font-size: 12px;
        color: var(--color-grey-light);
    }
    .ui-dropdown .current.selected {
        color: var(--color-black);
    }
    .ui-dropdown .current:hover {
        color: var(--color-red);
    }
    .ui-dropdown .current.active {
        color: var(--color-red);
    }
    .ui-dropdown .current span {
        display: inline-block;
        width: 10px;
        text-align: right;
    }


    /* popup */

    .ui-dropdown .popup {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        background: var(--bg-white);
        z-index: 1000;
        padding: 14px 30px 14px 20px;
        border-radius: 3px;
        box-shadow: var(--shadow);
    }
    .ui-dropdown .popup a {
        white-space: nowrap;
        font-size: 12px;
        padding: 6px 0;
        color: var(--color-grey);
    }
    .ui-dropdown .popup a:hover {
        color: var(--color-red);
    }
    .ui-dropdown .popup a.active {
        color: var(--color-black);
    }

</style>



<!--
    Template
-->

<template>
    <div class="ui-dropdown">

        <a class="current" :class="{selected: active, active: popup}" @click="toggle">
            {{fields[active]}}
            <span>&#x25BE;</span>
        </a>

        <div class="popup" v-show="popup">
            <a v-for="(name, field) in fields" :class="{active: field === active}" @click="activate(field)">{{name}}</a>
        </div>

    </div>
</template>



<!--
    Scripts
-->

<script>
    
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
        
        computed: {
            
            active () {
                return this.$store.state.filter.field || '';                
            }
            
        },

        methods: {

            toggle () {
                this.popup = !this.popup;
            },

            activate (field) {
                this.$store.commit('filter:set', {field});
                this.popup = false;
            }

        }

    }

</script>
