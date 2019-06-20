<!--
    Styles
-->

<style>


    /* main */

    .c-table table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }


    /* cells */

    .c-table td,
    .c-table th {
        padding: 0 10px;
        height: 36px;
    }
    .c-table td:first-child,
    .c-table th:first-child {
        padding-left: 0;
    }
    .c-table td:last-child,
    .c-table th:last-child {
        padding-right: 0;
    }


    /* heading */


    .c-table th {
        position: relative;
        text-align: left;
        text-transform: uppercase;
        font-weight: 600;
        line-height: 16px;
    }
    .c-table th span {
        position: absolute;
        top: 10px;

        transform-origin: 0 0;
        transition: transform 0.2s ease;
    }
    .c-table th input {
        position: relative;
        height: 100%;
        background: none;
        border: none;
        padding: 0;
        z-index: 1;
        color: var(--color-red);
    }
    .c-table th input:focus + span,
    .c-table th input:valid + span {
        transform: translateY(-10px) scale(0.5);
    }


    /* scroll */

    .c-table .scroll {
        overflow: auto;
    }
    .c-table .scroll th {
        visibility: hidden;
        height: 0;
        padding: 0;
        line-height: 10px;
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


    /* heading */

    .c-table .heading {
        border-bottom: 1px solid var(--bg-border);
    }

</style>



<!--
    Template
-->

<template>
    <div class="c-table l-col">

        <table class="heading">
            <tr>
                <th v-for="(heading, index) in headings" :style="{width: widths[index]}">
                    <input type="text" required v-model="filters[index]"/>
                    <span>{{heading}}</span>
                </th>
            </tr>
        </table>

        <div class="l-flex scroll" ref="scroll">
            <table>
                <tr>
                    <th v-for="(heading, index) in headings">
                        {{heading}}
                    </th>
                </tr>
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
                filters: [],
                widths: []
            }
        },

        methods: {

            scrollTop () {
                this.$refs.scroll.scrollTop = 0;
            },

            resize () {
                this.widths = [];
                const $td = this.$refs.row[0].children;
                for (let i = 0; i < $td.length; i++) {
                    this.widths.push($td[i].offsetWidth + 'px');
                }
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
            },

            filtered: {
                immediate: true,
                handler () {
                    this.$nextTick(this.resize);
                }

            }

        }

    }

</script>
