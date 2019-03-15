<!--
    Styles
-->

<style>


    /* heading */

    .ui-address .heading {
        font-size: 24px;
        text-transform: uppercase;
        font-weight: 800;
        margin-bottom: 12px;
    }
    .ui-address .heading:after {
        content: '';
        display: block;
        height: 2px;
        width: 70px;
        margin-top: 12px;
        background: #d6001c;
    }


    /* address */

    .ui-address .address {
        font-size: 13px;
        line-height: 18px;
        color: #959595;
        margin-bottom: 30px;
    }


    /* contact */

    .ui-address .contact {
        margin-right: 30px;
    }
    .ui-address .contact .icon {
        width: 36px;
        height: 36px;
        background: #363636;
        margin-right: 12px;
        border-radius: 18px;
    }
    .ui-address .contact .icon svg {
        fill: #fff;
        width: 16px;
        height: 16px;
        margin: 10px;
    }
    .ui-address .contact .text {
        font-size: 13px;
        line-height: 18px;
    }
    .ui-address .contact .text a {
        color: #d6001c;
    }
    .ui-address .contact .text a:hover {
        text-decoration: underline;
    }


</style>



<!--
    Template
-->

<template>
    <div class="ui-address l-clear">


        <!-- heading -->

        <p class="heading">{{data.name}}</p>


        <!-- address -->

        <div class="address">
            <p>{{data.street}} {{data.house_number}} {{data.house_add}}</p>
            <p>{{data.zip}} {{data.city}}, {{data.country_code}}</p>
        </div>


        <!-- email -->

        <div class="contact l-fl l-clear">
            <div class="l-fl icon">
                <svg-email></svg-email>
            </div>
            <div class="l-fl text">
                <p>{{data.contact.email.name}}</p>
                <a :href="`mailto:${data.contact.email.value}`">{{data.contact.email.value}}</a>
            </div>
        </div>


        <!-- phone -->

        <div class="l-fl contact l-clear">
            <div class="l-fl icon">
                <svg-phone></svg-phone>
            </div>
            <div class="l-fl text">
                <p>{{data.contact.telephone.name}}</p>
                <a :href="`tel:${data.contact.telephone.value}`">{{data.contact.telephone.value}}</a>
            </div>
        </div>


    </div>
</template>



<!--
    Scripts
-->

<script>


    import svgPhone from '@/assets/icons/phone.svg'
    import svgEmail from '@/assets/icons/email.svg'

    
    export default {

        components: {
            svgPhone,
            svgEmail
        },

        props: [
            'data'
        ]
    }

</script>
