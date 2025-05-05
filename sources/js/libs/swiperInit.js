// swiperInit.js
import Swiper from 'swiper/bundle';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css/bundle';

export const initHomeSlider = () => {
    return new Swiper('.home-slider', {
        modules: [Navigation, Pagination],
        loop: true,
        navigation: {
            nextEl: '.home-next',
            prevEl: '.home-prev',
        },
        pagination: {
            el: '.home-pagination',
            clickable: true,
        },
    });
};

export const initTestimonialSlider = () => {
    return new Swiper('.testimonial-slider', {
        modules: [Navigation, Pagination],
        loop: true,
        slidesPerView: 2,
        spaceBetween: 30,
        pagination: {
            el: '.testimonial-pagination',
            clickable: true,
        },
        breakpoints: {
            768: {
                slidesPerView: 1,
            },
        },
    });
};
