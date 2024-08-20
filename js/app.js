document.addEventListener('DOMContentLoaded', function() {
  const cards = document.querySelectorAll('.section__card');
  const prevButton = document.querySelector('.carousel__control.prev');
  const nextButton = document.querySelector('.carousel__control.next');
  let currentCardIndex = 0;

  // Función para mostrar una tarjeta con transición
  const showCard = (index, direction) => {
    // Desactivar transiciones inicialmente
    cards.forEach(card => card.style.transition = 'none');

    // Aplicar estilos para ocultar todas las tarjetas
    cards.forEach(card => {
      card.style.opacity = '0';
      card.style.transform = `translateX(${direction === 'next' ? '-' : ''}100%)`;
      card.classList.remove('show');
    });

    // Mostrar la tarjeta actual
    cards[index].classList.add('show');

    // Activar transiciones después de un pequeño retraso
    setTimeout(() => {
      cards.forEach(card => card.style.transition = 'opacity 0.5s, transform 0.5s');
      cards[index].style.opacity = '1';
      cards[index].style.transform = 'translateX(0)';
    }, 50);
  };

  // Función para cambiar de tarjeta
  const changeCard = (increment, direction) => {
    currentCardIndex = (currentCardIndex + increment + cards.length) % cards.length;
    showCard(currentCardIndex, direction);
  };

  // Función para desplazamiento automático
  const autoScroll = () => {
    changeCard(-1, 'next');
  };

  // Evento para el botón "anterior"
  prevButton.addEventListener('click', (event) => {
    event.preventDefault();
    changeCard(-1, 'prev');
  });

  // Evento para el botón "siguiente"
  nextButton.addEventListener('click', (event) => {
    event.preventDefault();
    changeCard(1, 'next');
  });

  // Desplazamiento automático cada 5 segundos (ajusta el tiempo según sea necesario)
  let autoScrollInterval = setInterval(autoScroll, 3500);

  // Detener el desplazamiento automático al pasar el ratón sobre el carrusel
  document.querySelector('.carousel-section').addEventListener('mouseenter', () => {
    clearInterval(autoScrollInterval);
  });

  // Reanudar el desplazamiento automático al retirar el ratón del carrusel
  document.querySelector('.carousel-section').addEventListener('mouseleave', () => {
    autoScrollInterval = setInterval(autoScroll, 3500);
  });

  // Mostrar la primera tarjeta sin transiciones al cargar la página
  showCard(currentCardIndex, 'next');
});
