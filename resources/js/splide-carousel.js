import '@splidejs/splide/css';
import Splide from '@splidejs/splide';

// Set default splide options
Splide.defaults = {
    type    : 'loop',      // 'slide' (default), 'loop', or 'fade'
    perPage : 1,           // Number of slides to show at once
    perMove : 1,           // Number of slides to move per transition
    gap     : '0.5rem',      // Space between slides
    autoplay: true,        // Auto-scroll
    interval: 5000,        // Time between autoplay transitions (ms)
    pauseOnHover: true,    // Pause autoplay when hovering
    arrows  : true,        // Show/hide arrows
    pagination: true,
    focus: 'center',
    padding: '6rem',
    trimSpace: false,
    easing: 'ease-out',
    speed : 1000,
    updateOnMove: true,
    
    breakpoints: {
        1024: { 
            padding: '5rem' 
        },
        768: {
            padding: '4rem' 
        },
        480: {
            padding: '3rem' 
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