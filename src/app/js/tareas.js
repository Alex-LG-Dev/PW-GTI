document.addEventListener('DOMContentLoaded', () => {
    const headers = document.querySelectorAll('.task-header');
  
    headers.forEach(header => {
      header.addEventListener('click', () => {
        const card = header.parentElement;
        const details = card.querySelector('.task-details');
        const icon = header.querySelector('.toggle-icon');
        const isVisible = details.style.display === 'block';
  
        details.style.display = isVisible ? 'none' : 'block';
        icon.textContent = isVisible ? '▼' : '▲';
      });
    });
  });