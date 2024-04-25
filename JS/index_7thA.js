$(function () {
    $(".head_C").click(function () {
        $(".head_B").slideToggle();
      });
    });

    $(".sale_slick").slick({
        arrows: false,
        autoplay: true,
        centerMode: true,
        centerPadding: "5%",
        slidesToShow: 3,
        dots: true,
    });