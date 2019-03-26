<!--
    Styles
-->

<style>


    /* main */

    #toolbar {
        height: 106px;
        background: var(--bg-black);
        padding: 32px 0;
    }


    /* aside */

    #toolbar .l-aside .button.secondary {
        margin-left: 12px;
    }


    /* frame */

    #toolbar .frame svg {
        width: 20px;
        height: 20px;
        margin: 10px;
    }
    #toolbar .frame input {
        height: 40px;
        padding: 0;
        background: none;
        border: none;
    }
    #toolbar .frame .dropdown {
        position: relative;
        padding: 0 20px;
    }


    /* dropdown .current */

    #toolbar .frame .current {
        line-height: 40px;
        font-size: 12px;
        color: var(--color-grey-light);
    }
    #toolbar .frame .current.selected {
        color: var(--color-black);
    }
    #toolbar .frame .current:hover {
        color: var(--color-red);
    }
    #toolbar .frame .current.active {
        color: var(--color-red);
    }
    #toolbar .frame .current span {
        display: inline-block;
        width: 10px;
        text-align: right;
    }


    /* popup */

    #toolbar .frame .popup {
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
    #toolbar .frame .popup a {
        white-space: nowrap;
        font-size: 12px;
        padding: 6px 0;
    }
    #toolbar .frame .popup a:hover {
        color: var(--color-red);
    }
    #toolbar .frame .popup a.active {
        color: var(--color-black);
    }


</style>



<!--
    Template
-->

<template>
    <div id="toolbar">
        <div class="l-container l-row">


            <!-- aside -->

            <div class="l-aside l-clear">

                <a class="l-fr button secondary" v-if="reload" @click="reload">
                    <svg-reload></svg-reload>
                </a>

                <a class="l-ff button primary" v-if="create" @click="create">
                    <svg-plus></svg-plus>
                    <span>Create</span>
                </a>

            </div>


            <!-- frame -->

            <div class="frame l-flex l-clear" v-if="filter">
                <svg-search class="l-fl"></svg-search>

                <div class="l-fr dropdown" v-if="filter.fields">

                    <a @click="toggle" class="current" :class="{selected: filter.active, active: popup}">
                        {{filter.fields[filter.active]}}
                        <span>&#x25BE;</span>
                    </a>
                    <div class="popup" v-show="popup">
                        <a v-for="(name, key) in filter.fields" :class="{active: key === filter.active}" @click="activate(key)">{{name}}</a>
                    </div>

                </div>

                <div class="l-ff">
                    <input type="text" placeholder="Search..." v-model="filter.query"/>
                </div>

            </div>

        </div>
    </div>
</template>



<!--
    Scripts
-->

<script>

    import svgPlus from '@/assets/icons/plus.svg';
    import svgReload from '@/assets/icons/reload.svg';
    import svgSearch from '@/assets/icons/search.svg';

    export default {

        components: {
            svgPlus,
            svgReload,
            svgSearch
        },

        props: [
            'create',
            'reload',
            'filter'
        ],

        data () {
            return {
                popup: false
            }
        },

        watch: {
            'filter.query' () {
                this.emit();
            },
            'filter.active' () {
                this.emit();
            }
        },


        methods: {

            toggle () {
                this.popup = !this.popup;
            },

            activate(index) {
                this.filter.active = index;
                this.popup = false;
            },

            emit() {
                this.$emit('filter', this.filter.query, this.filter.active);
            }

        }


    }

</script>
