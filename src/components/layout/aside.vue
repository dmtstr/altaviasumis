<!--
    Styles
-->

<style>


    /* main */

    #aside {
        position: fixed;
        top: 208px;
        bottom: 30px;
        overflow: auto;
    }


    /* link */

    #aside a {
        background-color: #fafafa;
        margin-bottom: 4px;
        padding: 24px 30px;
        border: 1px solid transparent;
    }

    #aside a p.large {
        font-size: 18px;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    #aside a p.small {
        font-size: 12px;
    }


    /* hover state */

    #aside a:hover p.large {
        color: #d6001c
    }
    #aside a:hover p.small {
        color: #959595
    }


    /* active state */

    #aside a.active {
        position: relative;
        background: #eee;
    }
    #aside a.active p.large {
        color: #d6001c;
    }
    #aside a.active p.small {
        color: #959595;
    }


    /* scrollbar */

    #aside::-webkit-scrollbar {
        -webkit-appearance: none;
    }
    #aside::-webkit-scrollbar:vertical {
        width: 12px;
    }
    #aside::-webkit-scrollbar-thumb {
        border-radius: 8px;
        border: 4px solid #FFF;
        background-color: #eeeeee;
    }


</style>



<!--
    Template
-->

<template>
    <div id="aside" class="l-aside">

        <a v-for="(item, index) in data"
           :class="{active: index === active}"
           :key="item.id"
           @click="click(index)">

            <p class="large t-bold">{{item.shop_id.name}}</p>

            <p class="small t-grey">
                <span class="t-bold">{{item.modified_by.first_name}}</span>
                <span>-</span>
                <span>{{item.modified_on}}</span>
            </p>

        </a>

    </div>
</template>



<!--
    Scripts
-->

<script>
    
    export default {

        props: [
            'data',
            'active',
            'click'
        ]

    }

</script>
