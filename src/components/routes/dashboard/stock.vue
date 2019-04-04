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

        data () {
            return {
                item: {}
            }
        },

        computed: mapGetters('dashboard', [
            'route',
            'dataActive'
        ]),

        watch: {

            dataActive: {
                immediate: true,
                handler (value) {
                    if (this.route !== this.$route.name) return;
                    this.item = Util.csvToTable(this.dataActive.content);
                }

            }

        }

    }

</script>
