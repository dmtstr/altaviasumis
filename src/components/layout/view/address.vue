<!--
    Styles
-->

<style>


    /* contact */

    .c-address .contact {
        margin-right: 30px;
        margin-bottom: 30px;
    }
    .c-address .contact .icon {
        width: 36px;
        height: 36px;
        background: var(--bg-black-light);
        margin-right: 12px;
        border-radius: 18px;
    }
    .c-address .contact .icon svg {
        fill: var(--bg-white);
        width: 16px;
        height: 16px;
        margin: 10px;
    }
    .c-address .contact .text {
        font-size: 13px;
        line-height: 18px;
    }
    .c-address .contact .text a {
        color: var(--color-red);
    }
    .c-address .contact .text a:hover {
        text-decoration: underline;
    }


    /* heading */

    .c-address .heading {
        font-size: 24px;
        line-height: 32px;
        text-transform: uppercase;
        font-weight: 800;
        margin-bottom: 8px;
    }


    /* line */

    .c-address .line {
        height: 2px;
        width: 70px;
        margin: 16px 0;
        background: var(--bg-red);
    }


    /* address */

    .c-address .address {
        font-size: 13px;
        line-height: 18px;
        color: var(--color-grey);
    }



</style>



<!--
    Template
-->

<template>
    <div class="c-address l-clear">

        <div class="contact l-fl l-clear">
            <div class="l-fl icon">
                <svg-email></svg-email>
            </div>
            <div class="l-fl text">
                <p>{{'???' || '&mdash;'}}</p>
                <a>{{data.email}}</a>
            </div>
        </div>

        <div class="l-fl contact l-clear">
            <div class="l-fl icon">
                <svg-phone></svg-phone>
            </div>
            <div class="l-fl text">
                <p>{{'???' || '&mdash;'}}</p>
                <a>{{data.telephone}}</a>
            </div>
        </div>

        <div class="l-clear"></div>
        <p class="heading">{{data.t_a_v}}</p>
        <div class="line"></div>

        <div class="address">
            <p>{{data.street}} {{data.house_no}} {{data.house_ext}}</p>
            <p>{{data.zip_code}} {{data.city}}, {{data.country_code}}</p>
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
