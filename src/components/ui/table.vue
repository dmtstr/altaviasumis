<!--
    Styles
-->

<style>


    /* main */

    .ui-table table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        font-size: 14px;
    }


    /* cells */

    .ui-table td {
        padding: 0 10px;
        height: 36px;
    }
    .ui-table td:first-child {
        padding-left: 0;
    }
    .ui-table td:last-child {
        padding-right: 0;
    }


    /* heading */

    .ui-table .heading {
        border-bottom: 1px solid var(--bg-border);
    }
    .ui-table .heading td {
        position: relative;
    }
    .ui-table .heading span {
        position: absolute;
        top: 10px;
        text-transform: uppercase;
        font-weight: 600;
        line-height: 16px;
        transform-origin: 0 0;
        transition: transform 0.2s ease;
    }
    .ui-table .heading input {
        position: relative;
        height: 100%;
        background: none;
        border: none;
        padding: 0;
        z-index: 1;
        color: var(--color-red);
    }
    .ui-table .heading input:focus + span,
    .ui-table .heading input:valid + span {
        transform: translateY(-10px) scale(0.5);
    }


    /* scroll */

    .ui-table .scroll {
        overflow: auto;
    }
    .ui-table .scroll::-webkit-scrollbar {
        -webkit-appearance: none;
    }
    .ui-table .scroll::-webkit-scrollbar:vertical {
        width: 4px;
        background: var(--bg-white-dark);
    }
    .ui-table .scroll::-webkit-scrollbar-thumb {
        border-radius: 2px;
        background-color: var(--bg-red);
    }


</style>



<!--
    Template
-->

<template>
    <div class="ui-table l-col">

        <table class="heading">
            <tr>
                <td v-for="(heading, index) in headings">
                    <input type="text" required v-model="filters[index]"/>
                    <span>{{heading}}</span>
                </td>
            </tr>
        </table>

        <div class="l-flex scroll" ref="scroll">
            <table>
                <tr v-for="row in filtered" ref="row">
                    <td v-for="cell in row">{{cell}}</td>
                </tr>
            </table>
        </div>

    </div>
</template>



<!--
    Scripts
-->

<script>
    
    export default {

        props: [
            'data'
        ],

        data () {
            return {
                results: [],
                headings: [],
                filters: []
            }
        },

        methods: {

            scrollTop () {
                this.$refs.scroll.scrollTop = 0;
            }

        },

        computed: {

            filtered () {
                return this.results.filter(cells => {
                    let valid = cells.filter((cell, index) => cell.indexOf(this.filters[index]) !== -1);
                    if (valid.length === cells.length) return cells;
                })
            }

        },

        watch: {

            data: {
                immediate: true,
                handler () {
                    this.headings = this.data[0];
                    this.filters = this.headings.map(heading => '');
                    this.results = this.data.slice(1, this.data.length);
                    this.$nextTick(this.scrollTop);
                }
            }

        }

    }

</script>
