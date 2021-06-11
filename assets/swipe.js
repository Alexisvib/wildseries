// import Swiper JS
import Swiper from 'swiper';
// import Swiper styles
import 'swiper/swiper-bundle.css';

const swiper = new Swiper('.mySwiper', {
    // Optional parameters
    slidesPerView: 3,
    spaceBetween: 30,
    direction: 'horizontal',
    loop: true,

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});