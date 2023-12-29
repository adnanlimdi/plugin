$(document).ready(function () {
    $('.navbar-toggler').click(function () {
        $('body').toggleClass('fixbody');
    })
    


});

var $radioButtons = $('input[type="radio"]');
$radioButtons.click(function() {
    $radioButtons.each(function() {
        $(this).parent().toggleClass('checked', this.checked);
    });
});

var swiper = new Swiper(".mySwiper", {
    slidesPerView: 2.7,
    spaceBetween: 35,
    loop: true,
    speed:2000,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    autoplay: {
      enabled: true,
    },
    breakpoints: {
      320: {
        slidesPerView: 1.2,
        spaceBetween: 20,
      },
      621: {
        slidesPerView: 1.5,
      },
      768: {
        slidesPerView: 1.5,
        spaceBetween: 40,
      },
      992: {
        slidesPerView: 2.7,
      },
    }
  });