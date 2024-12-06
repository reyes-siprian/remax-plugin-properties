var swiper_movil = new Swiper(".swiper", {
    speed: 1000,
    loop: true,
    spaceBetween: 30,
    slidesPerView: "auto",
    freeMode: true,
    lazy: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: true,
        reverseDirection: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});