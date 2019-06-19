<!--
    Styles
-->

<style>

    .r-order > .details {
        margin-bottom: 30px;
    }

</style>



<!--
    Template
-->

<template>
    <div class="r-order l-col">
        <!--<form-order v-if="creating"></form-order>-->
        <view-details v-show="!creating" class="details" :data="dataActive"></view-details>
        <view-table v-show="!creating" class="l-flex" :data="table"></view-table>
    </div>
</template>



<!--
    Scripts
-->

<script>

    import {mapGetters} from 'vuex'
    import Util from '@/common/util'
    import viewDetails from '@/components/layout/view/details.vue'
    import viewTable from '@/components/layout/view/table.vue'
    import formOrder from '@/components/forms/order.vue'

    export default {

        components: {
            viewDetails,
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
                    this.table = Util.jsonToTable(this.dataActive.lines);
                }

            }

        }


    }

</script>
