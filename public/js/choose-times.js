const day = document.querySelectorAll('.choose-times__day-container')
const submit = document.querySelector('#choose-times__submit')

day.forEach(element => {
    const input = element.querySelector('.choose-times__day-input')
    const inputTime = element.querySelector('.choose-times__time-input')
    const checkbox = element.querySelector('.choose-times__checkbox-svg')
    input.addEventListener('change', () => {
        if (input.checked) {
            checkbox.classList.add('u-visible')
            inputTime.setAttribute('required','')
        } else {
            checkbox.classList.remove('u-visible')
            inputTime.removeAttribute('required')
        }
    })
})

const form = document.getElementById('choose-times__form')
const checkboxes = document.querySelectorAll('.choose-times__day-input')

form.addEventListener('submit', (e) => {
    const oneChecked = Array.from(checkboxes).some(checkbox => checkbox.checked)
    if (!oneChecked) {
        e.preventDefault()
        alert('Veuillez sélectionner au moins un jour.')
    }
})        