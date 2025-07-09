function addLi(array) {
	results.innerHTML = ''
	array.forEach(element => {
		let li = document.createElement('li')
		li.textContent = element['properties']['label']
		results.appendChild(li)
	})
	if (array.length < 1) {
		let li = document.createElement('li')
		li.textContent = 'Aucun résultat'
		results.appendChild(li)
	}
}

const input = document.getElementById('address')
const results = document.getElementById('list-adresse')

input.addEventListener('input', () => {
	console.log('test')
	let query = input.value.trim()

	if (query.length < 3) {
		return ''
	}

	fetch('https://api-adresse.data.gouv.fr/search/?q=' + encodeURIComponent(query) + '&limit=5')
		.then(response => response.json())
		.then(data => console.log(data))

})