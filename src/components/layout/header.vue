<!--
    Styles
-->

<style>
    #header {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 110px;
        box-shadow: 0 2px 1px -1px #e1e1e1;
        background: #ffffff;
    }
    #header .logo {
        width: 220px;
    }
    #header .logo img {
        width: 100%;
    }

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

    #header nav a:hover,
    #header nav a.router-link-exact-active {
        color: #d6001c;
        fill: #d6001c;
    }

</style>



<!--
    Template
-->

<template>
    <header id="header">
        <div class="l-container l-container-large">
            <a class="logo l-fl l-vertical">
                <img src="/assets/images/logo.png"/>
            </a>
            <nav class="l-fr l-vertical">
                <router-link class="l-fl t-small t-bold" to="/">Orders</router-link>
                <router-link class="l-fl t-small t-bold" to="/stocks">Stocks</router-link>
                <router-link class="l-fl icon" to="/login"><icon-logout></icon-logout></router-link>
            </nav>

        </div>

    </header>
</template>



<!--
    Scripts
-->

<script>

    import iconLogout from '@/components/icons/logout.vue'
    
    export default {
        components: {
            iconLogout
        }
    }

</script>
