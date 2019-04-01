<!--
    Styles
-->

<style scoped>

    .ui-address {
        margin-bottom: 30px;
    }

</style>



<!--
    Template
-->

<template>
    <div class="l-col">
        <ui-address v-if="data" :data="data.address"></ui-address>
        <ui-table v-if="data" class="l-flex" :data="data.order"></ui-table>
    </div>
</template>



<!--
    Scripts
-->

<script>


    import Util from '@/common/util'
    import formOrder from '@/components/forms/order.vue'
    import uiAddress from '@/components/ui/address.vue'
    import uiTable from '@/components/ui/table.vue'

    export default {

        components: {
            formOrder,
            uiAddress,
            uiTable
        },

        computed: {

            data () {
                const index = this.$store.state.items.selected;
                const item = this.$store.state.items.data[index];
                if (!item) return null;
                const content = JSON.parse(item.content);
                content.order = Util.arrayToTable(content.order);
                return content;
            }

        }


    }

</script>
