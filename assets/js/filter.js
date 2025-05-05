document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.querySelector('.all-villas__filters-toggle');
    const filterForm = document.querySelector('.all-villas__form-filters');

    if (!toggleBtn || !filterForm) return;

    toggleBtn.addEventListener('click', () => {
        const isOpen = filterForm.classList.toggle('all-villas__form-filters--open');
        // toggleBtn.textContent = isOpen ? 'Close filters ✕' : 'Filters ☰';
    });
});
