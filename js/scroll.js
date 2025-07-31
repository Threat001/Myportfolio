// Scroll-triggered animations using anime.js

document.addEventListener('DOMContentLoaded', function() {
  // Hero section animations
  const heroTitle = document.querySelector('.hero-title');
  const heroSubtitle = document.querySelector('.hero-subtitle');
  const heroScroll = document.querySelector('.hero-scroll');
  
  if (heroTitle && heroSubtitle && heroScroll) {
      anime.timeline({
          easing: 'easeOutExpo',
          duration: 1000
      })
      .add({
          targets: '.title-line',
          opacity: [0, 1],
          translateY: [20, 0],
          delay: anime.stagger(200)
      })
      .add({
          targets: heroSubtitle,
          opacity: [0, 1],
          translateY: [20, 0],
          offset: '-=800'
      }, '-=600')
      .add({
          targets: heroScroll,
          opacity: [0, 1],
          offset: '-=600'
      });
  }
  
  // Feature card animations
  const featureCards = document.querySelectorAll('.feature-card');
  if (featureCards.length > 0) {
      anime({
          targets: featureCards,
          opacity: [0, 1],
          translateY: [50, 0],
          delay: anime.stagger(100),
          easing: 'easeOutExpo',
          duration: 800
      });
  }
  
  // Scroll-triggered animations
  const animateOnScroll = function() {
      const elements = document.querySelectorAll('.animate-on-scroll');
      
      elements.forEach(element => {
          const elementPosition = element.getBoundingClientRect().top;
          const windowHeight = window.innerHeight;
          
          if (elementPosition < windowHeight - 100) {
              element.classList.add('animated');
          }
      });
  };
  
  // Initialize scroll animations
  window.addEventListener('scroll', animateOnScroll);
  animateOnScroll(); // Run once on page load
  
  // Add animation classes to sections
  const sections = document.querySelectorAll('.section');
  sections.forEach((section, index) => {
      section.classList.add('animate-on-scroll');
      
      // Add staggered animation to children
      const children = section.querySelectorAll('.grid-item, .skill-category, .service-card, .process-step');
      children.forEach((child, childIndex) => {
          child.classList.add('animate-on-scroll');
          child.style.setProperty('--animation-order', childIndex);
      });
  });
  
  // Custom animation for about section image
  const aboutImage = document.querySelector('.about-image img');
  if (aboutImage) {
      aboutImage.classList.add('animate-on-scroll');
  }
  
  // Custom animation for contact form
  const contactForm = document.querySelector('.contact-form');
  if (contactForm) {
      contactForm.classList.add('animate-on-scroll');
  }
  
  // Initialize anime.js for scroll animations
  window.addEventListener('scroll', function() {
      const scrollPosition = window.scrollY;
      
      // Parallax effect for hero section
      if (heroTitle) {
          const heroSection = document.querySelector('.hero');
          if (heroSection) {
              const heroHeight = heroSection.offsetHeight;
              const parallaxValue = scrollPosition / heroHeight * 50;
              heroSection.style.backgroundPositionY = `${parallaxValue}%`;
          }
      }
      
      // Animate elements when they come into view
      document.querySelectorAll('.animate-on-scroll:not(.animated)').forEach(element => {
          const elementTop = element.getBoundingClientRect().top;
          const windowHeight = window.innerHeight;
          
          if (elementTop < windowHeight - 100) {
              element.classList.add('animated');
              
              anime({
                  targets: element,
                  opacity: [0, 1],
                  translateY: [30, 0],
                  easing: 'easeOutExpo',
                  duration: 800,
                  delay: element.style.getPropertyValue('--animation-order') * 100 || 0
              });
          }
      });
  });
});
