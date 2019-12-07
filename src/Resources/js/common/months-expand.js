document.querySelectorAll('.months-expander').forEach(expander => {
  expander.addEventListener('click', (e) => {
    e.target.closest('.year-content-wrapper').querySelector('.months-list').classList.toggle('d-none');
  });
});
