<!--
    Styles
-->

<style>
    #error {
        text-align: center;
        padding: 48px 0;
    }
    #error .code {
        font-size: 128px;
        font-weight: 500;
    }
    #error .message {
        margin: 0 0 24px 0;
        font-size: 14px;
    }
    #error .button {
        display: inline-block;
        vertical-align: top;
    }
</style>



<!--
    Template
-->

<template>
    <div id="error">
        <p class="code">{{error.code}}</p>
        <p class="message">{{error.message}}</p>
        <a class="button primary" @click="back">
            <span>Try again</span>
        </a>
    </div>
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
