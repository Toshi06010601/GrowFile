import '@splidejs/splide/css';
import Splide from '@splidejs/splide';

// Set default splide options
Splide.defaults = {
    type: 'slide',
    perPage: 1,
    perMove: 1,
    autoplay: false,
    arrows: true,
    pagination: true,
    focus: 'center',
    speed: 800,
    easing: 'cubic-bezier(0.25, 1, 0.5, 1)',
    drag: true,
    flickPower: 600,
    rewind: false,
    rewindSpeed: 800,
    waitForTransition: true, 
    updateOnMove: true
}

// Mount new Splide instance and also destroy it when HTML gets regenerated  
document.addEventListener('alpine:init', () => {
    Alpine.data('splideCarousel', () => ({ // Alpine.data allows you to use the x-data context
        splide: null,

        // Alpine will automatically execute it before it renders the component.
        init() {
            this.splide = new Splide(this.$el);
            this.splide.mount();
            // console.log('🧹 Creating Splide');
        },

        // Alpine will automatically execute it before cleaning up the component
        destroy() {
            if (this.splide) {
                // console.log('🧹 Destroying Splide');
                this.splide.destroy(true);
                this.splide = null;
            }
        }
    }));
});

