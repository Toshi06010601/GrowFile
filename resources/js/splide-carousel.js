import '@splidejs/splide/css';
import Splide from '@splidejs/splide';

// Set default splide options
Splide.defaults = {
    type: 'loop',
    perPage: 1,
    perMove: 1,
    autoplay: false,
    arrows: true,
    pagination: true,
    focus: 'center',
    padding: { left: '10rem', right: '10rem' },
    speed: 800,
    easing: 'cubic-bezier(0.25, 1, 0.5, 1)',
    drag: true,
    flickPower: 600,
    rewind: false,
    rewindSpeed: 800,
    waitForTransition: true, 
    updateOnMove: true,
    
    breakpoints: {
        1024: { 
            padding: { left: '6rem', right: '6rem' },
        },
        768: {
            padding: { left: '3rem', right: '3rem' },
        },
        640: {
            padding: { left: '3rem', right: '3rem' },
        },
    }
}

// Once DOM loaded, mount splide to all elements with splide class name
document.addEventListener( 'DOMContentLoaded', function() {
    var elms = document.querySelectorAll('.splide');
    elms.forEach(function(elm){
        new Splide( elm ).mount();
    });
  } );