import '@splidejs/splide/css';
import Splide from '@splidejs/splide';

// Set default splide options
Splide.defaults = {
    type   : 'loop',
    perPage    : 3,
    breakpoints: {
        640: {
            perPage: 1,
        },
    },
}

// Once DOM loaded, mount splide to all elements with splide class name
document.addEventListener( 'DOMContentLoaded', function() {
    var elms = document.querySelectorAll('.splide');
    elms.forEach(function(elm){
        new Splide( elm ).mount();
    });
  } );