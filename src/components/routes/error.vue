<!--
    Styles
-->

<style>

    .r-error {
        text-align: center;
        padding: 48px 0;
    }
    .r-error .code {
        font-size: 128px;
        font-weight: 500;
    }
    .r-error .message {
        margin: 0 0 24px 0;
        font-size: 14px;
    }
    .r-error a {
        display: inline-block;
        vertical-align: top;
    }

</style>



<!--
    Template
-->

<template>
    <section class="r-error">
        <p class="code">{{error.code}}</p>
        <p class="message">{{error.message}}</p>
        <a class="f-button primary wide" @click="back">
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
        ],

        beforeRouteEnter (to, from, next) {
            if (to.params.error) next(vm => {
                vm.previous = from.path;
            });
            else next({
                path: from.path,
                replace: true
            });
        },

        methods: {

            back () {
                this.$router.replace(this.previous);
            }

        }

    }

</script>
