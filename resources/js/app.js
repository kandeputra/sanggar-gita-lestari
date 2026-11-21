// Menu mobile
document.querySelectorAll('[data-menu-toggle]').forEach((button) => {
    const menu = document.getElementById(button.getAttribute('aria-controls'));

    button.addEventListener('click', () => {
        const open = button.getAttribute('aria-expanded') === 'true';
        button.setAttribute('aria-expanded', String(!open));
        menu?.classList.toggle('hidden', open);
    });
});

// Lightbox galeri sederhana memakai <dialog> bawaan browser
const lightbox = document.getElementById('lightbox');

if (lightbox) {
    const image = lightbox.querySelector('img');
    const caption = lightbox.querySelector('[data-lightbox-caption]');

    document.querySelectorAll('[data-lightbox]').forEach((link) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            image.src = link.getAttribute('href');
            image.alt = link.dataset.title ?? '';
            caption.textContent = link.dataset.title ?? '';
            lightbox.showModal();
        });
    });

    lightbox.addEventListener('click', (event) => {
        if (event.target === lightbox || event.target.closest('[data-lightbox-close]')) {
            lightbox.close();
        }
    });
}
