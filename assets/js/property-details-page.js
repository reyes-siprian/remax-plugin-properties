// function copyToClipboard() {
//     var copyText = document.getElementById("realestateCodeValue").value;
//     navigator.clipboard.writeText(copyText).then(() => {
//         // Alert the user that the action took place.
//         // Nobody likes hidden stuff being done under the hood!
//         alert("Copied to clipboard");
//     });
// }

var swiper_movil = new Swiper(".swiper", {
    speed: 1000,
    loop: true,
    spaceBetween: 30,
    lazy: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
