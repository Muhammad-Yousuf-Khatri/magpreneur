document.addEventListener('DOMContentLoaded', function(){
  const cardCarousel = document.querySelector('#cardCarousel .carousel-inner .row');
  const cards = cardCarousel.children;
  let position = 0;
  const maxPosition = cards.length - 1;
  var visibleCards = maxPosition - 1;

  const nextButton = document.querySelector('#cardCarousel .carousel-control-next');
  const prevButton = document.querySelector('#cardCarousel .carousel-control-prev');

  let cardWidth = calculateCardWidth();
  let isMobile = window.innerWidth < 576;

  function calculateCardWidth() {
    var getCard = document.querySelector('.card-width');
    return getCard.getBoundingClientRect().width;
  }

  function updateTranslateX() {
    cardCarousel.style.transform = `translateX(-${position * cardWidth}px)`;
  }


  nextButton.addEventListener('click', () => {
    if (position < maxPosition) {
      position++;
      updateTranslateX();
    }
    if (position == visibleCards) {
      position = 0;
      updateTranslateX();
    }
  });

  prevButton.addEventListener('click', () => {
    if (position == 0) {
      position = visibleCards;
      updateTranslateX();
    }
    if (position > 0) {
      position--;
      updateTranslateX();
    }
  });

  window.addEventListener('resize', () => {
    const isCurrentlyMobile = window.innerWidth < 576;
    cardWidth = calculateCardWidth();
    updateTranslateX();
    if (isCurrentlyMobile && !isMobile) {
      // Reset position if switching to mobile layout
      position = 0;
      updateTranslateX();
    }

    isMobile = isCurrentlyMobile;
  });

});