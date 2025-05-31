// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
  // Mobile navigation toggle functionality
  const createMobileNav = () => {
    const nav = document.querySelector('nav');
    const navList = document.querySelector('nav ul');
    
    // Create hamburger menu button
    const hamburger = document.createElement('div');
    hamburger.className = 'hamburger';
    hamburger.innerHTML = '<span></span><span></span><span></span>';
    
    // Insert hamburger button before the nav list
    nav.insertBefore(hamburger, navList);
    
    // Add toggle functionality
    hamburger.addEventListener('click', () => {
      navList.classList.toggle('show');
      hamburger.classList.toggle('active');
    });
  };
  
  // Form submission handling 
  const handleFormSubmission = () => {
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
      contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;
        
        // Simple validation
        if (!name || !email || !message) {
          alert('Please fill in all fields');
          return;
        }
        
        // Here you would normally send the data to a server
        // For now, we'll just show a success message
        alert('Thank you for your message! I will get back to you soon.');
        contactForm.reset();
      });
    }
  };
  
  // Add smooth scrolling to all links
  const addSmoothScrolling = () => {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
      link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        
        if (href !== '#') {
          e.preventDefault();
          const targetElement = document.querySelector(href);
          
          if (targetElement) {
            window.scrollTo({
              top: targetElement.offsetTop - 80,
              behavior: 'smooth'
            });
          }
        }
      });
    });
  };
  
  // Add animation on scroll
  const addScrollAnimations = () => {
    const elements = document.querySelectorAll('.section, .hero-content, .project-card, .about-text, .about-image');
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('fade-in');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 });
    
    elements.forEach(element => {
      observer.observe(element);
    });
  };
  
  // Initialize all functions
  if (window.innerWidth <= 768) {
    createMobileNav();
  }
  
  handleFormSubmission();
  addSmoothScrolling();
  addScrollAnimations();
  
  // Update some styles for the mobile nav when window is resized
  window.addEventListener('resize', function() {
    if (window.innerWidth <= 768) {
      if (!document.querySelector('.hamburger')) {
        createMobileNav();
      }
    }
  });
});