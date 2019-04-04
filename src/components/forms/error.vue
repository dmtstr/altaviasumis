<!--
    Styles
-->

<style>

    .c-error {
        text-align: center;
        padding: 48px 0;
    }
    .c-error .code {
        font-size: 128px;
        font-weight: 500;
    }
    .c-error .message {
        margin: 0 0 24px 0;
        font-size: 14px;
    }
    .c-error a {
        display: inline-block;
        vertical-align: top;
    }

</style>



<!--
    Template
-->

<template>
    <section class="c-error">
        <p class="code">{{error.code}}</p>
        <p class="message">{{error.message}}</p>
        <a class="f-button primary wide" @click="$emit('repeat')">
            <span>Try again</span>
        </a>
    </section>
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
