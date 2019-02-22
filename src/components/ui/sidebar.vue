<!--
    Styles
-->

<style>

    .sidebar {
        position: absolute;
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
                bottom: 0
            }
        },

        methods: {

            resize() {
                this.$el.style.width = this.$el.parentNode.offsetWidth + 'px'
            },

            scroll() {


                // values

                const top = window.scrollY;
                const delta = top > this.saved ? 1 : -1;
                const rect = this.$el.getBoundingClientRect();
                this.saved = top;

                console.log(rect.height + this.top + this.bottom, window.innerHeight)

                // element fully visible

                if (rect.height + this.top + this.bottom < window.innerHeight) {
                    this.fixed = 'top';
                    this.$el.style.position = 'fixed';
                    this.$el.style.top = this.top + 'px';
                    this.$el.style.bottom = 'auto';
                    console.log('1')
                    return;
                }


                // scroll down & not fixed

                if (this.fixed === false && delta > 0) {
                    if (rect.top + rect.height < window.innerHeight - this.bottom) {
                        this.fixed = 'bottom';
                        this.$el.style.position = 'fixed';
                        this.$el.style.top = 'auto';
                        this.$el.style.bottom = this.bottom + 'px';
                        console.log('2')
                        return
                    }
                }


                // scroll up & fixed to bottom

                if (this.fixed === 'bottom' && delta < 0) {
                    this.fixed = false;
                    this.$el.style.position = 'absolute';
                    this.$el.style.top = top - (this.$el.offsetHeight - window.innerHeight + this.bottom) + 'px';
                    this.$el.style.bottom = 'auto';
                    console.log('3')
                    return;
                }


                // scroll up & not fixed

                if (this.fixed === false && delta < 0) {
                    if (rect.top > this.top) {
                        this.fixed = 'top';
                        this.$el.style.position = 'fixed';
                        this.$el.style.top = this.top + 'px';
                        this.$el.style.bottom = 'auto';
                        console.log('4')
                        return
                    }
                }


                // scroll down & fixed to top

                if (this.fixed === 'top' && delta > 0) {
                    this.fixed = false;
                    this.$el.style.position = 'absolute';
                    this.$el.style.top = top + this.top + 'px';
                    this.$el.style.bottom = 'auto';
                    console.log('5')
                }


            },

        },

        mounted() {
            this.bottom = 48;
            this.top = this.$el.getBoundingClientRect().top;
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
