<!--
    Styles
-->

<style>
    #error {
        padding-top: 208px;
        text-align: center;
    }
</style>



<!--
    Template
-->

<template>
    <div id="error">
        <p class="t-red">An error occurred: {{error}}</p>
    </div>
</template>



<!--
    Scripts
-->

<script>
    
    export default {
        props: [
            'error'
        ]
    }

</script>
