<!--
    Styles
-->

<style>

    .sidebar {
        position: absolute;
        /*position: sticky; bottom: 0;*/
    }


</style>


<!--
    Template
-->

<template>
    <div class="sidebar">
        <slot></slot>
    </div>
</template>


<!--
    Scripts
-->

<script>

    export default {

        data() {
            return {
                fixed: false,
                saved: window.scrollY,
                top: 0,
                bottom: 0,
                max: 0,
                initial: 0
            }
        },

        methods: {

            resize() {
                this.$el.style.width = this.$el.parentNode.offsetWidth + 'px'
            },

            scroll() {



//                if (this.saved === window.scrollY) return;

                const top = window.scrollY;
                const delta = top > this.saved ? 1 : -1;
                const rect = this.$el.getBoundingClientRect();
                const visible = rect.height + this.top + this.bottom < window.innerHeight;
                this.saved = top;


                if (visible && delta > 0 && !this.fixed) {

                    if (rect.top < this.top) {
                        this.fixed = true;
                        this.$el.style.position = 'fixed';
                        this.$el.style.top = this.top + 'px';
                        return;
                    }

                }


                if (visible && delta < 0 && this.fixed) {

                    if (this.initial - top > this.top) {
                        this.fixed = false;
                        this.$el.style.position = 'absolute';
                        this.$el.style.top = this.initial + 'px';
                        return
                    }

                }



                if (!visible && delta > 0 && !this.fixed) {

                    if (rect.top + rect.height + this.bottom < window.innerHeight) {

                        console.log(1);

                        this.fixed = true;
                        this.$el.style.position = 'fixed';
                        this.$el.style.top = window.innerHeight - rect.height - this.bottom  + 'px';
                        return;
                    }

                }


                if (!visible && delta < 0 && this.fixed) {

                    if (rect.top ===  window.innerHeight - rect.height - this.bottom) {

                        console.log(2);

                        this.fixed = false;
                        this.$el.style.position = 'absolute';
                        this.$el.style.top = top - (this.$el.offsetHeight - window.innerHeight + this.bottom) + 'px';
                        return
                    }


                    if (this.initial - top > this.top) {

                        console.log(3);

                        this.fixed = false;
                        this.$el.style.position = 'absolute';
                        this.$el.style.top = this.initial + 'px';
                        return
                    }

                }


                if (!visible && delta < 0 && !this.fixed) {

                    console.log(4);

                    if (rect.top > this.top && this.initial - top < this.top) {
                        this.fixed = true;
                        this.$el.style.position = 'fixed';
                        this.$el.style.top = this.top + 'px';
                        return;
                    }

                }

                if (!visible && delta > 0 && this.fixed) {

                    if (rect.top === this.top) {

                        console.log(5);

                        this.fixed = false;
                        this.$el.style.position = 'absolute';
                        this.$el.style.top = top + this.top + 'px';

                    }


                }


            },

        },

        mounted() {

            const rect = this.$el.getBoundingClientRect();

            this.max = rect.top + rect.height + 48 - window.innerHeight;

            this.bottom = 48;
            this.top = 158;

            this.initial = this.$el.getBoundingClientRect().top;
            this.scroll();
            this.resize();
            window.addEventListener('scroll', this.scroll);
            window.addEventListener('resize', this.resize);
        },

        destroyed() {
            window.removeEventListener('scroll', this.scroll);
        }


    }

</script>
