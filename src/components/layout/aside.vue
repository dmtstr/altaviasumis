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
        background-color: var(--bg-white-dark);
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
        color: var(--color-grey-light);
        font-size: 12px;
    }


    /* hover state */

    #aside a:hover p.large {
        color: var(--color-red)
    }
    #aside a:hover p.small {
        color: var(--color-grey)
    }


    /* active state */

    #aside a.active {
        position: relative;
        background: var(--bg-grey-light);
    }
    #aside a.active p.large {
        color: var(--color-red);
    }
    #aside a.active p.small {
        color: var(--color-grey);
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
        border: 4px solid var(--bg-white);
        background-color: var(--bg-grey-light)
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

            <p class="small">
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
