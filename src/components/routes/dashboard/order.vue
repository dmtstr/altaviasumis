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
        <!--<form-order v-if="creating"></form-order>-->
        <view-address v-show="!creating" class="address" :data="dataActive"></view-address>
        <view-table v-show="!creating" class="l-flex" :data="table"></view-table>
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
                table: []
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
                    this.table = Util.jsonToTable(this.dataActive.content.LINES);
                }

            }

        }


    }

</script>
