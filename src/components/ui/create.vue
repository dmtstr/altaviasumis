<!--
    Styles
-->

<style scoped>

    .create {
        height: 90px;
        width: 90px;
        border-radius: 50%;
        background: #fafafa;
        margin-bottom: 24px;
        position: relative;
        border: 2px solid transparent;
        transition: border-color 0.3s ease;
    }
    .create .l-center {
        width: 32px;
        height: 2px;
    }
    .create .line {
        background: #363636;
        border-radius: 2px;
        transition: background 0.3s ease;
    }
    .create .line.vertical {
        transform: rotate(90deg);
    }
    .create:hover {
        border-color: #d6001c;
    }
    .create:hover .line {
        background: #d6001c;
    }
    .create.active {
        background: #a30015;
        border-color: #a30015;
    }
    .create.active .line {
        background: #ffffff;
    }

</style>



<!--
    Template
-->

<template>

    <a class="create" :class="{active: active}">
        <div class="l-center">
            <div class="l-stretch line vertical "></div>
            <div class="l-stretch line horizontal"></div>
        </div>
    </a>

</template>



<!--
    Scripts
-->

<script>
    
    export default {
        props: [
            'active'
        ]
    }

</script>
