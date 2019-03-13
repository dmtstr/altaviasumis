<!--
    Styles
-->

<style scoped>
    .tab {
        background-color: #fafafa;
        margin-bottom: 4px;
        padding: 25px 30px;
    }

    .tab p.small {
        font-size: 12px;
        color: #d4d4d4;
    }
    .tab p.large {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .tab:hover {
        background: #d6001c;
    }
    .tab:hover p.small {
        color: rgba(255, 255, 255, 0.7);
    }
    .tab:hover p.large {
        color: #ffffff;
    }

    .tab.active {
        background: #a30015;
    }
    .tab.active p.small {
        color: rgba(255, 255, 255, 0.7);
    }
    .tab.active p.large {
        color: #ffffff;
    }
</style>



<!--
    Template
-->

<template>
    <a class="tab" :class="{active: active}">
        <p class="large t-black">{{data.shop_id.name}}</p>
        <p class="small">
            <span>{{data.modified_by.first_name}}</span>
            <span>&#9679;</span>
            <span>{{data.modified_on}}</span>
        </p>
    </a>
</template>



<!--
    Scripts
-->

<script>
    
    export default {
        props: [
            'data',
            'active'
        ]
    }

</script>
