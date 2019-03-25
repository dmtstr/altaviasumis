<!--
    Styles
-->

<style>


    /* main */

    .ui-loader {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 2px;
    }
    .ui-loader span {
        background-color: var(--bg-red);
    }


    /* animations */

    .ui-loader .line:nth-child(1) {
        animation: line1 2s linear infinite;
    }
    .ui-loader .line:nth-child(1) span {
        animation: span1 2s linear infinite;
    }
    .ui-loader .line:nth-child(2) {
        animation: line2 2s linear infinite;
    }
    .ui-loader .line:nth-child(2) span {
        animation: span2 2s linear infinite;
    }


    /* keyframes */

    @keyframes line1 {
        0% {
            transform: translateX(-145.166611%)
        }
        20% {
            animation-timing-function: cubic-bezier(.5, 0, .701732, .495819);
            transform: translateX(-145.166611%)
        }
        59.15% {
            animation-timing-function: cubic-bezier(.302435, .381352, .55, .956352);
            transform: translateX(-61.495191%)
        }
        to {
            transform: translateX(55.444446%)
        }
    }

    @keyframes span1 {
        0% {
            transform: scaleX(.08)
        }
        36.65% {
            animation-timing-function: cubic-bezier(.334731, .124820, .785844, 1);
            transform: scaleX(.08)
        }
        69.15% {
            animation-timing-function: cubic-bezier(.06, .11, .6, 1);
            transform: scaleX(.661479)
        }
        to {
            transform: scaleX(.08)
        }
    }

    @keyframes line2 {
        0% {
            animation-timing-function: cubic-bezier(.15, 0, .515058, .409685);
            transform: translateX(-54.888891%)
        }
        25% {
            animation-timing-function: cubic-bezier(.310330, .284058, .8, .733712);
            transform: translateX(-17.236978%)
        }
        48.35% {
            animation-timing-function: cubic-bezier(.4, .627035, .6, .902026);
            transform: translateX(29.497274%)
        }
        to {
            transform: translateX(105.388891%)
        }
    }

    @keyframes span2 {
        0% {
            animation-timing-function: cubic-bezier(.205028, .057051, .576610, .453971);
            transform: scaleX(.08)
        }
        19.15% {
            animation-timing-function: cubic-bezier(.152313, .196432, .648374, 1.004315);
            transform: scaleX(.457104)
        }
        44.15% {
            animation-timing-function: cubic-bezier(.257759, .003163, .211762, 1.381790);
            transform: scaleX(.727960)
        }
        to {
            transform: scaleX(.08)
        }
    }

</style>



<!--
    Template
-->

<template>
    <div class="ui-loader">
        <div class="line l-stretch">
            <span class="l-stretch"></span>
        </div>
        <div class="line l-stretch">
            <span class="l-stretch"></span>
        </div>
    </div>
</template>
