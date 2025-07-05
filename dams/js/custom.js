(function ($) {
  
"use strict";

  // NAVBAR
  $('.navbar-nav .nav-link').click(function(){
      $(".navbar-collapse").collapse('hide');
  });

  // REVIEWS CAROUSEL
  $('.reviews-carousel').owlCarousel({
      center: true,
      loop: true,
      nav: true,
      dots: false,
      autoplay: true,
      autoplaySpeed: 300,
      smartSpeed: 500,
      responsive:{
        0:{
          items:1,
        },
        768:{
          items:2,
          margin: 100,
        },
        1280:{
          items:2,
          margin: 100,
        }
      }
  });

  // Banner Carousel
  var myCarousel = document.querySelector('#myCarousel')
  var carousel = new bootstrap.Carousel(myCarousel, {
    interval: 1500,
  })

  // REVIEWS NAVIGATION
  function ReviewsNavResize(){
    $(".navbar").scrollspy({ offset: -94 });

    var ReviewsOwlItem = $('.reviews-carousel .owl-item').width();

    $('.reviews-carousel .owl-nav').css({'width' : (ReviewsOwlItem) + 'px'});
  }

  $(window).on("resize", ReviewsNavResize);
  $(document).on("ready", ReviewsNavResize);

  // HREF LINKS
  $('a[href*="#"]').click(function (event) {
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top - 74
        }, 1000);
      }
    }
  });
  
  // Enhanced Navbar Functionality
  document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.user-navbar');
    const navLinks = document.querySelectorAll('.user-navbar .nav-link');
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
    
    // Active link management
    function setActiveLink() {
      const currentPage = window.location.pathname.split('/').pop() || 'index.php';
      
      navLinks.forEach(link => {
        link.classList.remove('active');
        
        // Check if link matches current page
        if (link.getAttribute('href') === currentPage) {
          link.classList.add('active');
        }
        
        // Special case for home page
        if (currentPage === 'index.php' && link.getAttribute('href') === 'index.php') {
          link.classList.add('active');
        }
      });
    }
    
    // Set active link on page load
    setActiveLink();
    
    // Smooth scrolling for anchor links
    navLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        
        // If it's an anchor link (starts with #)
        if (href.startsWith('#') && href !== '#') {
          e.preventDefault();
          const target = document.querySelector(href);
          
          if (target) {
            const navbarHeight = navbar.offsetHeight;
            const targetPosition = target.offsetTop - navbarHeight - 20;
            
            window.scrollTo({
              top: targetPosition,
              behavior: 'smooth'
            });
          }
        }
      });
    });
    
    // Mobile menu improvements
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navbarToggler && navbarCollapse) {
      // Close mobile menu when clicking on a link
      navLinks.forEach(link => {
        link.addEventListener('click', function() {
          if (window.innerWidth < 992) {
            navbarCollapse.classList.remove('show');
          }
        });
      });
      
      // Close mobile menu when clicking outside
      document.addEventListener('click', function(e) {
        if (!navbar.contains(e.target) && navbarCollapse.classList.contains('show')) {
          navbarCollapse.classList.remove('show');
        }
      });
    }
    
    // Add hover effects for better touch devices
    if ('ontouchstart' in window) {
      navLinks.forEach(link => {
        link.addEventListener('touchstart', function() {
          this.style.transform = 'scale(0.95)';
        });
        
        link.addEventListener('touchend', function() {
          this.style.transform = '';
        });
      });
    }
  });

})(window.jQuery);
