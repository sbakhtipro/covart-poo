////////////////////////////// NAV //////////////////////////////

const navBurgerButton = document.querySelector('.nav__burger');
const navMenu = document.querySelector('.nav__links-list');

navBurgerButton.addEventListener('click', () => {
    navBurgerButton.classList.toggle('is-open' );
    navBurgerButton.classList.toggle('is-closed');
    let isOpen = navBurgerButton.classList.contains('is-open'); // true si contient is-open, false autrement
    navBurgerButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    navMenu.classList.toggle('is-open');
})
