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

            <div class="l-ff l-split">
                <input type="text" placeholder="Search..." v-if="searchable" :value="search" @input="input($event)"/>
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

    export default {

        components: {
            svgPlus,
            svgReload
        },

        props: [
            'create',
            'reload',
            'search'
        ],

        computed: {

            searchable() {
                return this.search !== undefined;
            }

        },

        methods: {

            input(event) {
                this.$emit('input', event.target.value);
            }

        }

    }

</script>
