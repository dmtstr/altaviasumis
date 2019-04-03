<!--
    Styles
-->

<style>


    /* main */

    .c-header {
        height: 72px;
        background: var(--bg-white);
        box-shadow: var(--shadow);
    }
    .c-header .container {
        height: inherit;
    }


    /* logo */

    .c-header .logo img {
        height: 14px;
    }


    /* links */

    .c-header nav a {
        color: var(--color-black);
        fill: var(--color-black);
    }
    .c-header nav a.link {
        margin-left: 28px;
        line-height: 20px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        font-family: var(--font-secondary);
    }
    .c-header nav a.icon {
        margin-left: 56px;
    }
    .c-header nav a.icon svg {
        height: 20px;
    }


    /* link states */

    .c-header nav a:hover,
    .c-header nav a.active {
        color: var(--color-red);
        fill: var(--color-red);
    }
    .c-header nav a.active {
        cursor: default;
    }


</style>



<!--
    Template
-->

<template>
    <header class="c-header">
        <header-loader v-show="loading"></header-loader>
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

    import {mapState} from 'vuex';
    import iconLogout from '@/assets/icons/logout.svg'
    import headerLoader from './loader.vue'

    export default {

        components: {
            iconLogout,
            headerLoader
        },

        computed: mapState([
            'loading'
        ])

    }

</script>
