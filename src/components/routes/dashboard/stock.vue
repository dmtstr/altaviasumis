<!--
    Styles
-->

<style>

</style>



<!--
    Template
-->

<template>
    <div class="l-col">
        <form-stock v-if="creating"></form-stock>
        <view-table v-show="!creating" :data="item"></view-table>
    </div>
</template>



<!--
    Scripts
-->

<script>

    import {mapGetters} from 'vuex'
    import Util from '@/common/util'
    import viewTable from '@/components/layout/view/table.vue'
    import formStock from '@/components/forms/stock.vue'


    export default {

        components: {
            viewTable,
            formStock
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
                    this.item = Util.jsonToTable(this.dataActive.content);
                }

            }

        }

    }

</script>
