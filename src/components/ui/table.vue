<!--
    Styles
-->

<style>


    /* main */

    .ui-table {
        width: 100%;
        font-size: 14px;
    }
    .ui-table table {
        border-collapse: collapse;
    }
    .ui-table table td {
        padding: 0 10px;
    }
    .ui-table table td:first-child {
        padding-left: 0;
    }
    .ui-table table td:last-child {
        padding-right: 0;
    }



    /* headings */

    .ui-table .headings {
        position: fixed;
        background: #fff;
        border-bottom: 2px solid #ededed;
    }
    .ui-table .headings td {
        height: 66px;
        padding-top: 30px;
        text-transform: uppercase;
        font-weight: 600;
    }
    .ui-table .headings + div {
        height: 72px;
    }


    /* results */

    .ui-table .results {
        width: 100%;
    }
    .ui-table .results td {
        height: 36px;
    }


</style>



<!--
    Template
-->

<template>
    <div class="ui-table">

        <table class="headings" :style="{width: width.row}">
            <tr>
                <td v-for="(heading, index) in headings" :style="{width: width.cell[index]}">{{heading}}</td>
            </tr>
        </table>

        <div></div>

        <table class="results">
            <tr v-for="row in filtered" ref="row">
                <td v-for="cell in row">{{cell}}</td>
            </tr>
        </table>

    </div>


</template>



<!--
    Scripts
-->

<script>
    
    export default {

        props: [
            'data',
            'search'
        ],

        data () {
            return {
                results: null,
                headings: null,
                width: {
                    row: 0,
                    cell: []
                }
            }
        },

        methods: {

            resize () {
                const $row = this.$refs.row[0];
                if (!$row) return;
                this.width.row = $row.offsetWidth + 'px';
                this.width.cell = [];
                for (let i = 0; i < $row.children.length; i++) {
                    this.width.cell.push($row.children[i].offsetWidth + 'px');
                }
            }

        },

        computed: {

            filtered () {
                if (!this.search) return this.results;
                return this.results.filter(cells => {
                    for (let i = 0; i < cells.length; i++) {
                        if (cells[i].indexOf(this.search) !== -1) return cells;
                    }
                })
            }

        },

        watch: {

            data: {
                immediate: true,
                handler () {
                    this.headings = this.data[0];
                    this.results = this.data.slice(1, this.data.length);
                    this.$nextTick(this.resize);
                }
            },

            filtered () {
                this.$nextTick(this.resize);
            }

        }

    }

</script>
