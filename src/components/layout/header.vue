<!--
    Styles
-->

<style>


    /* main */

    #header {
        height: 72px;
        background: var(--bg-white);
        box-shadow: var(--shadow);
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
        font-family: var(--font-secondary);
    }
    #header nav .link {
        position: relative;
        margin-left: 28px;
        padding: 4px 0 2px 0;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;;
        color: var(--color-black)
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
        color: var(--color-red);
        fill: var(--color-red);
    }
    #header nav a.router-link-exact-active {
        cursor: default;
    }


</style>



<!--
    Template
-->

<template>
    <header id="header">
        <div class="container l-container">


            <!-- logo -->

            <router-link class="logo l-fl l-vertical" to="/">
                <img src="images/logo.png"/>
            </router-link>


            <!-- navigation -->

            <nav class="l-fr l-vertical">
                <router-link class="link l-fl" to="/">Orders</router-link>
                <router-link class="link l-fl" to="/stocks">Stocks</router-link>
                <router-link class="icon l-fl" to="/login">
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

    import iconLogout from '@/assets/icons/logout.svg'

    export default {

        components: {
            iconLogout
        }

    }

</script>
