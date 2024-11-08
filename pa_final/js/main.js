document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.getElementById("hamburger");
  const navLinks = document.getElementById("navLinks");
  const closeButton = document.getElementById("closeButton");

  hamburger.addEventListener("click", () => {
    navLinks.classList.add("active");
  });

  closeButton.addEventListener("click", () => {
    navLinks.classList.remove("active");
  });
});

const toggleButton = document.getElementById('darkModeToggle');
  const body = document.body;
  const aboutSection = document.querySelector('.about');
  const eventSection = document.querySelector('.event');
  const modeIcon = document.getElementById('modeIcon');

  toggleButton.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    aboutSection.classList.toggle('dark-mode');
    eventSection.classList.toggle('dark-mode');

    if (body.classList.contains('dark-mode')) {
      modeIcon.classList.remove('ri-moon-line'); 
      modeIcon.classList.add('ri-sun-line'); 
    } else {
      modeIcon.classList.remove('ri-sun-line'); 
      modeIcon.classList.add('ri-moon-line');
    }
  });

  document.addEventListener("DOMContentLoaded", () => {
    const eventItems = document.querySelectorAll(".event__item");
  
    const isElementInView = (el) => {
      const rect = el.getBoundingClientRect();
      return rect.top <= window.innerHeight && rect.bottom >= 0;
    };
  
    const checkScroll = () => {
      eventItems.forEach((item) => {
        if (isElementInView(item)) {
          item.classList.add("visible");
        }
      });
    };
  
    window.addEventListener("scroll", checkScroll);
  
    checkScroll();
  });
  