<!--
    Styles
-->

<style>


    /* main */

    .c-table table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        font-size: 14px;
    }


    /* cells */

    .c-table td {
        padding: 0 10px;
        height: 36px;
    }
    .c-table td:first-child {
        padding-left: 0;
    }
    .c-table td:last-child {
        padding-right: 0;
    }


    /* heading */

    .c-table .heading {
        border-bottom: 1px solid var(--bg-border);
    }
    .c-table .heading td {
        position: relative;
    }
    .c-table .heading span {
        position: absolute;
        top: 10px;
        text-transform: uppercase;
        font-weight: 600;
        line-height: 16px;
        transform-origin: 0 0;
        transition: transform 0.2s ease;
    }
    .c-table .heading input {
        position: relative;
        height: 100%;
        background: none;
        border: none;
        padding: 0;
        z-index: 1;
        color: var(--color-red);
    }
    .c-table .heading input:focus + span,
    .c-table .heading input:valid + span {
        transform: translateY(-10px) scale(0.5);
    }


    /* scroll */

    .c-table .scroll {
        overflow: auto;
    }
    .c-table .scroll::-webkit-scrollbar {
        -webkit-appearance: none;
    }
    .c-table .scroll::-webkit-scrollbar:vertical {
        width: 4px;
        background: var(--bg-white-dark);
    }
    .c-table .scroll::-webkit-scrollbar-thumb {
        border-radius: 2px;
        background-color: var(--bg-red);
    }


</style>



<!--
    Template
-->

<template>
    <div class="c-table l-col">

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
