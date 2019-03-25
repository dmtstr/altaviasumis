<!--
    Styles
-->

<style>
    #error {
        text-align: center;
        color: var(--color-red);
    }
</style>



<!--
    Template
-->

<template>
    <div id="error">An error occurred: {{error}}</div>
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
