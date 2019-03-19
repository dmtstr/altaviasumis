<!--
    Styles
-->

<style>


    /* main */

    #header {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 72px;
        background: #ffffff;
        box-shadow: 0 2px 1px -1px #e1e1e1;
    }
    #header .container {
        height: inherit;
    }


    /* logo */

    #header .logo img {
        height: 14px;
    }


    /* nav */

    #header nav {
        font-family: 'Raleway', sans-serif;
    }
    #header nav .link {
        margin-left: 28px;
        padding: 4px 0 2px 0;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
    }
    #header nav .icon {
        margin-left: 56px;
    }
    #header nav .icon svg {
        height: 20px;
    }


    /* link states */

    #header nav a:hover,
    #header nav a.router-link-exact-active {
        color: #d6001c;
        fill: #d6001c;
    }
    #header nav a.router-link-exact-active {
        cursor: default;
    }


</style>



<!--
    Template
-->

<template>
    <header id="header" :class="{loading: loading}">
        <div class="container l-container">

            <router-link class="logo l-fl l-vertical" to="/">
                <img src="images/logo.png"/>
            </router-link>

            <nav class="l-fr l-vertical">
                <router-link class="link l-fl t-black" to="/">Orders</router-link>
                <router-link class="link l-fl t-black" to="/stocks">Stocks</router-link>
                <router-link class="icon l-fl t-black" to="/login">
                    <icon-logout></icon-logout>
                </router-link>
            </nav>

        </div>
        <ui-loader v-show="loading"></ui-loader>
    </header>
</template>



<!--
    Scripts
-->

<script>

    import Event from '@/common/event';
    import iconLogout from '@/assets/icons/logout.svg'
    import uiLoader from '@/components/ui/loader.vue'

    export default {

        components: {
            iconLogout,
            uiLoader
        },

        data() {
            return {
                loading: false
            }
        },

        mounted() {
            Event.$on('loading', value => this.loading = value);
        }
    }

</script>
