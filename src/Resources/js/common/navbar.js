document.querySelector('.categories-menu-button').addEventListener('click', (e) => {
  e.target.closest('.navbar-wrapper').querySelector('.categories-menu').classList.toggle('d-none');
});
