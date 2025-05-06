import { initHomeSlider } from '@js/libs/swiperInit.js';
import deviceMenu from '@js/libs/deviceMenu.js';
import { initFancybox } from '@js/libs/fancybox.js';

deviceMenu();
// initHomeSlider();
// initFancybox();

/* Script on ready
------------------------------------------------------------------------------*/
document.addEventListener('DOMContentLoaded', () => {
    /* Process buttons */
    // document.querySelectorAll('.btn-link, .btn-play').forEach(function (element) {
    //     if (element.classList.contains('btn-link')) {
    //         appendSVGBtn(element, '#icon-btn-arrow', '24', '15');
    //     } else if (element.classList.contains('btn-play')) {
    //         appendSVGBtn(element, '#icon-play-btn', '10', '13');
    //     }
    // });
    /* Process buttons End */

    /* Use jQuery code Start */
    (function ($) {
    // Write code here
    })(jQuery);
    /* Use jQuery code End */
});

/* Script all functions
------------------------------------------------------------------------------*/
// Function to create and append SVG to an element
// function appendSVGBtn(element, iconId, width, height) {
//     var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
//     svg.setAttribute('aria-hidden', 'true');
//     svg.setAttribute('width', width);
//     svg.setAttribute('height', height);

//     var use = document.createElementNS('http://www.w3.org/2000/svg', 'use');
//     use.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', iconId);

//     svg.appendChild(use);
//     element.appendChild(svg);
// }