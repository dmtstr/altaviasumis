<!--
    Styles
-->

<style>

    .r-order > .address {
        margin-bottom: 30px;
    }

</style>



<!--
    Template
-->

<template>
    <div class="r-order l-col">
        <view-address class="address" :data="item.address"></view-address>
        <view-table class="l-flex" :data="item.order"></view-table>
    </div>
</template>



<!--
    Scripts
-->

<script>

    import {mapGetters} from 'vuex'
    import Util from '@/common/util'
    import viewAddress from '@/components/layout/view/address.vue'
    import viewTable from '@/components/layout/view/table.vue'

    export default {

        components: {
            viewAddress,
            viewTable
        },

        computed: {

            ...mapGetters('dashboard', [
                'dataActive'
            ]),

            item () {
                const item = JSON.parse(this.dataActive.content);
                item.order = Util.arrayToTable(item.order);
                return item;
            }

        }


    }

</script>
