<!--
    Styles
-->

<style>

</style>



<!--
    Template
-->

<template>
    <view-table :data="item"></view-table>
</template>



<!--
    Scripts
-->

<script>

    import {mapGetters} from 'vuex'
    import Util from '@/common/util'
    import viewTable from '@/components/layout/view/table.vue'


    export default {

        components: {
            viewTable
        },

        computed: {

            ...mapGetters('dashboard', [
                'dataActive'
            ]),

            item () {
                return Util.csvToTable(this.dataActive.content);
            }

        }

    }

</script>
