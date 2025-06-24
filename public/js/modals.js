/** traitement général des fenêtres modales : dans le html le bouton d'ouverture
est toujours placé juste au dessus de la fenêtre qu'il ouvre et le bouton de 
fermeture est toujours son enfant direct.
setTimeout dans le cas ou la modale contient une map */

const openModalButtons = document.querySelectorAll('.u-open-modal-button')
const closeModalButtons = document.querySelectorAll('.u-close-modal-button')
const blackOverlay = document.querySelector('.u-overlay')
const allElements = document.querySelectorAll('.u-modal')

openModalButtons.forEach(element => {
    element.addEventListener('click', () => {
        element.nextElementSibling.classList.add('u-visible')
        document.body.classList.add('u-no-scroll')
        blackOverlay.classList.add('u-visible')
        element.setAttribute('aria-expanded', 'true')
        setTimeout(() => {
            map.invalidateSize();
        }, 10)
    })
})

closeModalButtons.forEach(element => {
    element.addEventListener('click', () => {
        element.parentElement.classList.remove('u-visible')
        document.body.classList.remove('u-no-scroll')
        blackOverlay.classList.remove('u-visible')
        openModalButtons.forEach(element => {
            element.setAttribute('aria-expanded', 'false')
        })
    })
})

blackOverlay.addEventListener('click', () => {
    allElements.forEach(element => {
        element.classList.remove('u-visible')
        blackOverlay.classList.remove('u-visible')
        document.body.classList.remove('u-no-scroll')
    });
})