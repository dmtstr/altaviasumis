<!--
    Styles
-->

<style>
    
</style>



<!--
    Template
-->

<template>
    <ui-table v-if="data" :data="data"></ui-table>
</template>



<!--
    Scripts
-->

<script>


    import Util from '@/common/util'
    import uiTable from '@/components/ui/table.vue'


    export default {

        components: {
            uiTable
        },

        computed: {

            data () {
                const index = this.$store.state.items.selected;
                const item = this.$store.state.items.data[index];
                if (!item) return null;
                return Util.csvToTable(item.content);
            }

        }

    }

</script>
