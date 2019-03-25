<!--
    Styles
-->

<style>

    #toolbar {
        position: fixed;
        top: 72px;
        left: 0;
        width: 100%;
        height: 106px;
        background: #252525;
        padding: 32px 0;
    }

    #toolbar .button.secondary {
        margin-left: 12px;
    }
    #toolbar input:focus {
        border-color: #d6001c;
    }
    #toolbar .content {
        margin-left: 30px;
    }


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
    #toolbar .frame .dropdown .current {
        line-height: 40px;
        font-size: 12px;
    }
    #toolbar .frame .dropdown .current.active {
        color: #363636;
    }
    #toolbar .frame .dropdown .current span {
        display: inline-block;
        width: 10px;
        text-align: right;
    }
    #toolbar .frame .dropdown .popup {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        background: #ffffff;
        z-index: 1000;
        padding: 14px 30px 14px 20px;
        border-radius: 3px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    #toolbar .frame .dropdown .popup a {
        white-space: nowrap;
        font-size: 12px;
        padding: 6px 0;
    }
    #toolbar .frame .dropdown .popup a.active {
        color: #363636;
    }

</style>



<!--
    Template
-->

<template>
    <div id="toolbar">
        <div class="l-container l-clear">

            <div class="l-fl l-aside l-clear">
                <a class="l-fr button secondary" v-if="reload" @click="reload">
                    <svg-reload></svg-reload>
                </a>
                <a class="l-ff button primary" v-if="create" @click="create">
                    <svg-plus></svg-plus>
                    <span>Create</span>
                </a>
            </div>

            <div class="content l-content l-fl" v-if="filter">
                <div class="frame l-clear">

                    <svg-search class="l-fl"></svg-search>

                    <div class="l-fr dropdown" v-if="filter.fields">
                        <a @click="toggle" class="current t-grey" :class="{active: filter.active}">
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
