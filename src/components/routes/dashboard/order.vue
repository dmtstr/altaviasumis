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
        <form-order v-if="creating"></form-order>
        <view-address v-show="!creating" class="address" :data="item.address"></view-address>
        <view-table v-show="!creating" class="l-flex" :data="item.order"></view-table>
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
    import formOrder from '@/components/forms/order.vue'

    export default {

        components: {
            viewAddress,
            viewTable,
            formOrder
        },

        data () {
            return {
                item: {}
            }
        },

        computed: mapGetters('dashboard', [
            'route',
            'creating',
            'dataActive'
        ]),

        watch: {

            dataActive: {
                immediate: true,
                handler (value) {
                    if (this.route !== this.$route.name) return;
                    this.item = JSON.parse(this.dataActive.content);
                    this.item.order = Util.arrayToTable(this.item.order);
                }

            }

        }


    }

</script>
