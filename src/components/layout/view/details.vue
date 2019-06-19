<!--
    Styles
-->

<style>


    /* heading */

    .c-details .heading {
        font-size: 24px;
        text-transform: uppercase;
        font-weight: 800;
    }


    /* company */

    .c-details .company {
        font-size: 9px;
        margin-bottom: 3px;
        text-transform: uppercase;
    }


    /* line */

    .c-details .line {
        height: 2px;
        width: 70px;
        margin: 16px 0;
        background: var(--bg-red);
    }


    /* contact */

    .c-details .contact {
        margin-top: 4px;
        margin-right: 24px;
        font-size: 12px;
        line-height: 18px;
    }
    .c-details .contact svg {
        fill: var(--bg-black-light);
        width: 18px;
        height: 16px;
        margin-right: 6px;
    }
    .c-details .contact p {
        color: var(--color-grey);
    }
    .c-details .contact a {
        color: var(--color-red);
    }
    .c-details .contact a:hover {
        text-decoration: underline;
    }


    /* detail */

    .c-details .detail {
        font-size: 12px;
        line-height: 18px;
    }






</style>



<!--
    Template
-->

<template>
    <div class="c-details">


        <!-- heading -->

        <div class="l-clear">

            <div class="l-fl">
                <p class="company">{{data.t_a_v}}</p>
                <p class="heading">{{data.order_no}}</p>
            </div>

            <div class="f-toggle l-fr l-clear">
                <a class="l-fl f-button primary" @click="toggle(true)" :class="{active: contacts}">Contacts</a>
                <a class="l-fl f-button primary" @click="toggle(false)" :class="{active: !contacts}">Details</a>
            </div>

        </div>


        <!-- line -->

        <div class="line"></div>


        <!-- contacts -->

        <div v-show="contacts">

            <div class="contact l-clear">
                <svg-phone class="l-fl"></svg-phone>
                <a class="l-fl" :href="`tel:${data.telephone}`">{{data.telephone}}</a>
            </div>


            <div class="contact l-clear">
                <svg-email class="l-fl"></svg-email>
                <a class="l-fl" :href="`mailto:${data.email}`">{{data.email}}</a>
            </div>

            <div class="contact l-clear">
                <svg-address class="l-fl"></svg-address>
                <p class="l-fl">{{data.street}} {{data.house_no}} {{data.house_ext}}, {{data.zip_code}} {{data.city}}, {{data.country_code}}</p>
            </div>

        </div>


        <!-- data -->

        <div v-show="!contacts">

            <p class="detail" v-for="(value, key) in data" v-if="typeof value !== 'object'">{{key}}: <b>{{value}}</b></p>

        </div>



    </div>
</template>



<!--
    Scripts
-->

<script>


    import svgPhone from '@/assets/icons/phone.svg'
    import svgEmail from '@/assets/icons/email.svg'
    import svgAddress from '@/assets/icons/address.svg'

    
    export default {

        components: {
            svgPhone,
            svgEmail,
            svgAddress
        },

        props: [
            'data'
        ],

        data () {
            return {
                contacts: true
            }
        },

        methods: {

            toggle (value) {
                this.contacts = value;
            }

        }
    }

</script>
