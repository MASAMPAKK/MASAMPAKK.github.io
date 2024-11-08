function confirmLogout() {
  if (confirm("Apakah Anda yakin ingin logout?")) {
      window.location.href = "logout.php"; 
  }
}

function liveSearch() {
  var input = document.getElementById("searchInput"); 
  var filter = input.value.toLowerCase();  
  var eventGrid = document.getElementById("eventGrid"); 
  var events = eventGrid.getElementsByClassName("event-card");  

  for (var i = 0; i < events.length; i++) {
      var event = events[i];

      var eventName = event.getElementsByClassName("event-name")[0]; 
      var eventStatus = event.getElementsByClassName("event-status")[0]; 

      if (eventName && eventStatus) {
          var txtValueName = eventName.textContent || eventName.innerText; 
          var txtValueStatus = eventStatus.textContent || eventStatus.innerText; 

          if (txtValueName.toLowerCase().indexOf(filter) > -1 || txtValueStatus.toLowerCase().indexOf(filter) > -1) {
              event.style.display = ""; 
          } else {
              event.style.display = "none";  
          }
      }
  }
}

function handleCardClick(card, eventId) {
    if (card.classList.contains('disabled')) {
      event.preventDefault();
      alert("Event ini sudah selesai atau kuotanya habis.");
    } else {
      window.location.href = 'detail_event.php?id_event=' + eventId;
    }
  }

let currentIndex = 0;
const images = document.querySelectorAll('.carousel-images img');
const totalImages = images.length;

function autoSlide() {
    currentIndex++;

    if (currentIndex >= totalImages) {
        currentIndex = 0; 
    }

    updateCarousel();
}

function updateCarousel() {
    const carousel = document.querySelector('.carousel-images');
    carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
}

setInterval(autoSlide, 3000);

