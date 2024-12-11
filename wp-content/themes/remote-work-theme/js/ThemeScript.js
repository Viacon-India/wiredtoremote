// When the user scrolls the page, execute myFunction 
if (window.location.hash) {
  var hash = window.location.hash;
  if ($(hash).length) {
      if(hash.includes('#comment')){
          $('html, body').animate({
              scrollTop: $(hash).offset().top -300
          }, 2000, 'swing');
      }
      if(hash.includes('#respond')){
          $('html, body').animate({
              scrollTop: $(hash).offset().top -300
          }, 2000, 'swing');
      }
  }
}


//  nav bar button toggle
let icon = document.querySelector(".menu_icon");
icon.addEventListener("click", () => {
  icon.classList.toggle("clicked");
});


// hum burger menu toggle
document.querySelectorAll(".ham-accordion").forEach((menu) => {
  menu.addEventListener("click", () => {
    menu.classList.toggle("ham-active");
    const newPanel = menu.nextElementSibling;
    newPanel.style.maxHeight = newPanel.style.maxHeight
      ? null
      : newPanel.scrollHeight + "px";
  });
});


//  home page  banner auto type
var TxtRotate = function (el, toRotate, period) {
  this.toRotate = toRotate;
  this.el = el;
  this.loopNum = 0;
  this.period = parseInt(period, 10) || 2000;
  this.txt = "";
  this.tick();
  this.isDeleting = false;
};

TxtRotate.prototype.tick = function () {
  var i = this.loopNum % this.toRotate.length;
  var fullTxt = this.toRotate[i];

  if (this.isDeleting) {
    this.txt = fullTxt.substring(0, this.txt.length - 1);
  } else {
    this.txt = fullTxt.substring(0, this.txt.length + 1);
  }

  this.el.innerHTML = '<span class="wrap">' + this.txt + "</span>";

  var that = this;
  var delta = 300 - Math.random() * 100;

  if (this.isDeleting) {
    delta /= 2;
  }

  if (!this.isDeleting && this.txt === fullTxt) {
    delta = this.period;
    this.isDeleting = true;
  } else if (this.isDeleting && this.txt === "") {
    this.isDeleting = false;
    this.loopNum++;
    delta = 500;
  }

  setTimeout(function () {
    that.tick();
  }, delta);
};

window.onload = function () {
  var elements = document.getElementsByClassName("txt-rotate");
  for (var i = 0; i < elements.length; i++) {
    var toRotate = elements[i].getAttribute("data-rotate");
    var period = elements[i].getAttribute("data-period");
    if (toRotate) {
      new TxtRotate(elements[i], JSON.parse(toRotate), period);
    }
  }
  // INJECT CSS
  var css = document.createElement("style");
  css.type = "text/css";
  css.innerHTML = ".txt-rotate > .wrap { border-right: 0.05em solid #666 }";
  document.body.appendChild(css);
};



$(document).ready(function(){

 // search modal script  

  $("input.desk-top-search-from").val("");
  $("input.desk-top-search-from").focusout(function () {
    var text_val = $(this).val();
    if (text_val === "") {
      $(this).removeClass("has-value");
    } else {
      $(this).addClass("has-value");
    }
  });



  // Swiper Slider Script
  $('.swiper').each(function(index, item) {
    new Swiper(item, {
      loop: true,
      keyboard: true,
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 0,
        },
        540: {
          slidesPerView: 2,
          spaceBetween: 15,
        },
        769: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        1025: {
          slidesPerView: 4,
          spaceBetween: 24,
        },
        1281: {
          slidesPerView: 4,
          spaceBetween: 28,
        },
        1537: {
          slidesPerView: 4,
          spaceBetween: 32,
        },
        1681: {
          slidesPerView: 4,
          spaceBetween: 36,
        },
      },
    });
  });

  $('.swiper2').each(function(index, item) {
    new Swiper(item, {
      loop: true,
      keyboard: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      breakpoints: {
        0: {
          slidesPerView: 1.02,
          spaceBetween: 10,
        },
        540: {
          slidesPerView: 2.02,
          spaceBetween: 15,
        },
        769: {
          slidesPerView: 2.02,
          spaceBetween: 20,
        },
        1025: {
          slidesPerView: 3.02,
          spaceBetween: 24,
        },
        1281: {
          slidesPerView: 3.02,
          spaceBetween: 28,
        },
        1537: {
          slidesPerView: 3.02,
          spaceBetween: 32,
        },
        1681: {
          slidesPerView: 3.02,
          spaceBetween: 36,
        },
      },
    });
  });

  $(".owl-carousel.cat-slid").owlCarousel({
    loop: true,
    nav: false,
    responsive: {
      0: {
        items: 1,
        margin: 0,
      },
      540: {
        items: 2,
        margin: 15,
      },
      769: {
        items: 3,
        margin: 20,
      },
      1025: {
        items: 4,
        margin: 24,
      },
      1281: {
        items: 4,
        margin: 28,
      },
      1537: {
        items: 4,
        margin: 32,
      },
      1681: {
        items: 4,
        margin: 36,
      },
    },
  });


  // Footer Subscribe Button Script
  $('.footer-get-in-touch-card .emaillist form input[type="email"]').after('<button class="subscribe-btn" aria-label="subscribe-button"><span class="icon-send"></span></button>');
  
  
  // Contact Form Button Script
  $('.contact-us-page-dsc-wrapper .wpcf7 form input[type="submit"]').hide().after('<button type="submit" class="contact-from-contact-button">Submit <span class="icon-arrow"></span></button>');
  $('.contact-us-page-dsc-wrapper .wpcf7 form input[type="text"], .contact-us-page-dsc-wrapper .wpcf7 form input[type="email"], .contact-us-page-dsc-wrapper .wpcf7 form textarea').after('<span class="focus-border"></span>');

  
  //  nav bar toggle  left  to right
  $(".ham-dropdown").click(function () {
    // $(".ham-content").toggleClass("open");
    $("#hamMenu").toggleClass("open");
  });


  // Table of Content
  let $content_title = $('.single-post-content h2, .single-post-content h3, .single-post-content h4');
  $(window).scroll(function() {
      let $toc_title = $content_title.filter((i, el) => $(el).offset().top > $(window).scrollTop()).first();
      $("#toc a").not(this).removeClass('box-item-active box-line-active');
      $('#toc-'+$toc_title.prop('id')).addClass('box-item-active box-line-active');
  }).scroll();

  $('#toc a[href*="#"]').click(function(event) {
      var post_url = $(this).attr('href').split('#')[0];
      if(window.location == post_url){
          event.preventDefault();
      }
      var target = $(this.hash);
      $('html,body').stop().animate({
          scrollTop: target.offset().top - 100
      }, 2000 ,'swing'); 
  });

  // Single Page Quote
  $('.single-post-content blockquote').wrapInner('<div class="text" />').prepend('<div class="icon quote" style="max-width: 50px"><svg version="1.1" x="0px" y="0px" width="30" height="30" viewBox="0 0 191.029 191.029"><path style="fill:#1B8EE4;" d="M44.33,88.474v15.377h38.417v82.745H0v-82.745h0.002V88.474c0-31.225,8.984-54.411,26.704-68.918 	C38.964,9.521,54.48,4.433,72.824,4.433v44.326C62.866,48.759,44.33,48.759,44.33,88.474z M181.107,48.759V4.433 	c-18.343,0-33.859,5.088-46.117,15.123c-17.72,14.507-26.705,37.694-26.705,68.918v15.377h0v82.745h82.744v-82.745h-38.417V88.474 	C152.613,48.759,171.149,48.759,181.107,48.759z"></path></svg></div>');


  // Share Button Function
  $("button.share-social").click(function (e) {
    e.preventDefault();
    window.open(
      jQuery(this).data("link"),
      "_blank",
      "rel=noopener noreferrer nofollow"
    );
  });


  // Share More Function
  $("button.share-more").click(function () {
    shareData = {
      title: jQuery(this).data("post_title"),
      text: jQuery(this).data("post_text"),
      url: jQuery(this).data("post_url"),
    };
    navigator.share(shareData);
  });


  // Add Alt Tag To Img Script
  let images = document.getElementsByTagName("img");
  for (var i = 0; i < images.length; i++) addAlt(images[i]);
  function addAlt(el) {
    if (el.getAttribute("alt")) return;
    url = el.src;
    let filename = url.substring(url.lastIndexOf("/") + 1);
    if (!filename) {
      filename = "insightsofamerica-img";
    }
    filename = filename.split(".").slice(0, -1).join(".");
    el.setAttribute("alt", filename);
  }
});