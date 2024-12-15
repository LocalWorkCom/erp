$(window).scroll(function () {
  if ($(document).scrollTop() > 50) {
    $('header').addClass('scroll')
  } else {
    $('header').removeClass('scroll')
  }
})
/* Open the sidenav */
function openNav() {
  document.getElementById("sidenav").style.width = "100%";
}
/* Close/hide the sidenav */
function closeNav() {
  document.getElementById("sidenav").style.width = "0";
}
function openCart() {
  document.getElementById("sideCart").style.width = "450px"; 
  document.getElementById("blur-overlay").classList.add("active");
  document.body.classList.add("no-scroll"); 
}

function closeCart() {
  document.getElementById("sideCart").style.width = "0"; 
  document.getElementById("blur-overlay").classList.remove("active"); 
  document.body.classList.remove("no-scroll"); 
}

$(document).ready(function () {
  $('.owl-slider').owlCarousel({
    items: 1,
    loop: true,
    dots: true,
    nav: true,
    autoplay: true,
    smartSpeed: 450,
    rtl: true,
  });

  $('.categories-slider').owlCarousel({
    items: 3,
    loop: false,
    dots: true,
    nav: true,
    margin: 25,
    pagination: false,
    autoplay: false,
    autoplaySpeed: 1000,
    autoplayTimeout: 3000,
    rtl: true,
    responsive: {
      0: {
        items: 1,
        nav: true,
        dots: false
      },

      600: {
        items: 2,
        nav: true
      },

      900: {
        items: 3,
        nav: true
      },

      // 1200: {
      //   items: 5,
      //   nav: true
      // }
    }
  });
  $('.plates-slider').owlCarousel({
    items: 4,
    loop: false,
    dots: true,
    nav: true,
    margin: 15,
    pagination: false,
    autoplay: false,
    autoplaySpeed: 1000,
    autoplayTimeout: 3000,
    rtl: true,
    responsive: {
      0: {
        items: 1,
        nav: true,
        dots: false
      },

      600: {
        items: 2,
        nav: true
      },

      900: {
        items: 3,
        nav: true
      },

      1200: {
        items: 4,
        nav: true
      }
    }
  });
  $(".owl-prev > span").html('<i class="fas fa-arrow-right"></i>');
  $(".owl-next > span").html('<i class="fas fa-arrow-left"></i>');
  $("#modal").modal("show");


});

$(document).on('show.bs.modal', function (e) {
  var modal = $(e.target).find('.modal-dialog');
  modal.css({
    transform: 'translateY(-50px)',
    opacity: 0
  });
  setTimeout(() => {
    modal.css({
      transform: 'translateY(0)',
      opacity: 1,
      transition: 'all 0.5s ease-out'
    });
  }, 10);
});

$(document).on('hide.bs.modal', function (e) {
  var modal = $(e.target).find('.modal-dialog');
  modal.css({
    transform: 'translateY(-50px)',
    opacity: 0,
    transition: 'all 0.5s ease-in'
  });
});


// Close the cart when clicking outside (on the blur overlay)
document.getElementById("blur-overlay").addEventListener("click", closeCart);


