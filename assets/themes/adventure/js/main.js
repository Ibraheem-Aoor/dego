

// add bg to nav
window.addEventListener("scroll", function () {
    let scrollpos = window.scrollY;
    const header = document.querySelector("header");
    const headerHeight = header.offsetHeight;

    if (scrollpos >= headerHeight) {
        header.classList.add("active");
    } else {
        header.classList.remove("active");
    }
});



$(document).ready(function () {
    // owl carousel1
    $('.carousel-area1').owlCarousel({
        loop: true,
        autoplay: false,
        margin: 20,
        nav: false,
        dots: true,
        // rtl:true,
        responsive: {
            0: {
                items: 1,
                dotsEach: 3,
            },
            550: {
                items: 2
            },
            991: {
                items: 3
            },
            1200: {
                items: 4
            },
            1400: {
                items: 5
            }
        }
    });
    // owl carousel2
    $('.carousel-area2').owlCarousel({
        loop: true,
        autoplay: false,
        margin: 10,
        nav: false,
        dots: true,
        // rtl:true,
        responsive: {
            0: {
                items: 1,
                dotsEach: 3,
            },
            570: {
                items: 2
            },
            991: {
                items: 3
            },
            1200: {
                items: 4
            },
            1600: {
                items: 5
            }
        }
    });


    // Testimonial section start
    // Owl carousel
    $(function (e) {
        "use strict";
        $('.testimonial-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 10,
            nav: false,
            dots: true,
            // rtl: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
        $('.testimonial-carousel2').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 10,
            nav: false,
            dots: true,
            // rtl: true,
            dotsEach: 3,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });
        $('.hero-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            nav: false,
            dots: false,
            rtl: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    });










    // cmn select2 start
    $('.cmn-select2').select2({

    });
    // cmn select2 end

    // cmn-select2 with image start
    $(document).ready(function () {
        $('.cmn-select2-image').select2({
            templateResult: formatState,
            templateSelection: formatState
        });
    });
    // select2 function
    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var baseUrl = "assets/img/mini-flag";
        var $state = $(
            '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.svg" class="img-flag" /> ' + state.text + '</span>'
        );
        return $state;
    };
    function formatState(state) {
        if (!state.id) {
            return state.text;
        }

        var baseUrl = "assets/img/mini-flag";
        var $state = $(
            '<span><img class="img-flag" /> <span></span></span>'
        );

        // Use .text() instead of HTML string concatenation to avoid script injection issues
        $state.find("span").text(state.text);
        $state.find("img").attr("src", baseUrl + "/" + state.element.value.toLowerCase() + ".svg");

        return $state;
    };
    // cmn-select2 with image end

    // cmn select2 modal start
    $(".modal-select").select2({
        dropdownParent: $("#formModal"),
    });



});

// Bootstrap datepicker start
$('.date-picker').datepicker({
    format: 'dd/mm/yyyy',
});
// Bootstrap datepicker end

// input file preview
const previewImage = (id) => {
    document.getElementById(id).src = URL.createObjectURL(event.target.files[0]);
};

// Tooltip
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));



