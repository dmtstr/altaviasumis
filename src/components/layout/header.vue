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
        height: 110px;
        box-shadow: 0 2px 1px -1px #e1e1e1;
        background: #ffffff;
    }


    /* logo */

    #header .logo {
        width: 220px;
    }

    #header .logo img {
        width: 100%;
    }


    /* nav */

    #header nav {
        font-family: 'Raleway', sans-serif;
    }

    #header nav a {
        text-transform: uppercase;
        margin-left: 28px;
        line-height: 20px;
        color: #363636;
    }

    #header nav a.icon {
        margin-left: 56px;
    }

    #header nav a.icon svg {
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


    /* loader */

    #header:after,
    #header:before {
        display: none;
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        background-color: #d6001c;
    }
    #header:after {
        animation: loader-after 2.1s 1.15s cubic-bezier(0.165, 0.840, 0.440, 1.000) infinite;
    }
    #header:before {
        animation: loader-before 2.1s cubic-bezier(0.650, 0.815, 0.735, 0.395) infinite;
    }
    #header.loading:after,
    #header.loading:before {
        display: block;
    }


    /* keyframes */

    @keyframes loader-after {
        0% {
            left: -200%;
            right: 100%;
        }
        60% {
            left: 107%;
            right: -8%;
        }
        100% {
            left: 107%;
            right: -8%;
        }
    }

    @keyframes loader-before {
        0% {
            left: -35%;
            right:100%;
        }
        60% {
            left: 100%;
            right: -90%;
        }
        100% {
            left: 100%;
            right: -90%;
        }
    }


</style>


<!--
    Template
-->

<template>
    <header id="header" :class="{loading: loading}">
        <div class="l-container l-container-large">
            <a class="logo l-fl l-vertical">
                <img src="/assets/images/logo.png"/>
            </a>
            <nav class="l-fr l-vertical">
                <router-link class="l-fl t-small t-bold" to="/">Orders</router-link>
                <router-link class="l-fl t-small t-bold" to="/stocks">Stocks</router-link>
                <router-link class="l-fl icon" to="/login">
                    <icon-logout></icon-logout>
                </router-link>
            </nav>

        </div>

    </header>
</template>


<!--
    Scripts
-->

<script>

    import iconLogout from '@/components/icons/logout.vue'
    import Event from '@/common/event';

    export default {
        data() {
            return {
                loading: false
            }
        },
        components: {
            iconLogout
        },
        mounted() {
            Event.$on('loading', value => this.loading = value);
        }
    }

</script>
