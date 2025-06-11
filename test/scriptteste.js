const track = document.getElementById('carouselTrack');
const cards = document.querySelectorAll('.book-card');
const cardWidth = 270; // largura total do card (incluindo margens)
const visibleArea = document.querySelector('.carousel-container').offsetWidth;

let index = 0;
const maxIndex = Math.ceil((cardWidth * cards.length - visibleArea) / cardWidth);

function slideCarousel() {
  index++;

  if (index > maxIndex) {
    index = 0; // reinicia do começo
  }

  track.style.transform = `translateX(-${index * cardWidth}px)`;
}

// Troca a cada 3 segundos
setInterval(slideCarousel, 3000);
