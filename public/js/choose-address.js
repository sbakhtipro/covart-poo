////////////////////////////// PROPOSER UN TRAJET //////////////////////////////

// récupérer liste adresses entreprise
let data = null

async function fetchAddresses() {
  try {
    const response = await fetch(
      "index.php?controller=propose-commute&method=fetch-addresses"
    )
    if (!response.ok) {
      throw new Error("Données non récupérées")
    }
    console.log(response)
    data = await response.json()
    displayAddresses()
  } catch (error) {
    console.error("Données non récupérées : ", error)
  }
}

function autofill() {
  const input = document.getElementById("address-input")
  const hiddenInput = document.getElementById("coordonnees-input")
  const results = document.getElementById("results")
  input.addEventListener("input", () => {
    let query = input.value.trim()
    if (query.length < 3) {
      return ""
    }
    fetch(
      "https://api-adresse.data.gouv.fr/search/?q=" +
        encodeURIComponent(query) +
        "&limit=5"
    )
      .then((response) => response.json())
      .then((data) => {
        results.innerHTML = ""
        data["features"].forEach((element) => {
          let li = document.createElement("li")
          li.textContent = element["properties"]["label"]
          results.appendChild(li)
          li.addEventListener("click", () => {
            input.value = li.textContent
            results.innerHTML = ""
            hiddenInput.value =
              element["geometry"]["coordinates"][1] +
              ", " +
              element["geometry"]["coordinates"][0]
            if (hiddenInput.value.length > 0) {
              document.getElementById("submit").style.display = "block"
            }
          })
        })
        if (results.innerHTML === "") {
            let noResult = document.createElement("li")
            noResult.textContent = 'Aucun résultat'
            results.appendChild(noResult)
          }
      })
  })
}

function setSelectCoordinates() {
  let hiddenList = document.getElementById("coordonnees-list")
  let list = document.getElementById("list-address")
  let selected = list.selectedOptions[0]
  hiddenList.value = selected.dataset.coordonnees
  list.addEventListener("change", () => {
    hiddenList.value = selected.dataset.coordonnees
  })
}

function createInputs(isC, isntC, hasI, hasS, adressList) {
  let adressInput = `<input type="text" id="address-input" class="choose-address__input" name="${isC == 'aller' ? 'trajet_lieu_depart' :'trajet_lieu_arrivee'}" placeholder="Rechercher une adresse" required>
      <ul id="results" class="choose-address__suggestions"></ul>`
  let adressListSelect = `<select class="choose-address__input" name="${isC == 'retour' ? 'trajet_lieu_depart' :'trajet_lieu_arrivee'}" id="list-address">`
  let hiddenInput = `<input type="hidden" id="coordonnees-input" name="${isC == 'aller' ? 'trajet_lieu_depart_coordonnees' : 'trajet_lieu_arrivee_coordonnees'}" />`
  let hiddenList = `<input type="hidden" id="coordonnees-list" name="${isC == 'retour' ? 'trajet_lieu_depart_coordonnees' : 'trajet_lieu_arrivee_coordonnees'}" />`
  let isChecked = document.getElementById(isC)
  let isntChecked = document.getElementById(isntC)
  let hasInput = document.querySelector(".choose-address__" + hasI.en)
  let hasSelect = document.querySelector(".choose-address__" + hasS.en)
  isChecked.addEventListener("change", () => {
    if (isChecked.checked) {
      isChecked.parentElement.classList.add(
        "choose-address__type-radio--checked"
      )
      isntChecked.parentElement.classList.remove(
        "choose-address__type-radio--checked"
      )
      hasInput.style.display = "block"
      hasSelect.style.display = "block"
      hasInput.innerHTML =
        `<label class="choose-address__label" for="address-input">${hasI.fr} :</label>` +
        adressInput + hiddenInput + hiddenList
      hasSelect.innerHTML =
        `<label class="choose-address__label">${hasS.fr} :</label>` + adressListSelect +
        adressList
      autofill()
      setSelectCoordinates()
      // document.querySelector('.choose-address_vehicle').style.display = 'block'
    }
  })
}

function displayAddresses() {
  if (data) {
    let adressList = ''
    data.forEach((element) => {
      adressList += `<option data-coordonnees="${element["agence_lat"]}, ${element["agence_lon"]}" required>${element["agence_numero_voie"]} ${element["agence_voie"]}, ${element["agence_code_postal"]} ${element["agence_ville"]}</option>
            `
    })
    adressList += `</select>`
    createInputs(
      "aller",
      "retour",
      { fr: "Départ", en: "departure" },
      { fr: "Arrivée", en: "arrival" },
      adressList
    )
    createInputs(
      "retour",
      "aller",
      { fr: "Arrivée", en: "arrival" },
      { fr: "Départ", en: "departure" },
      adressList
    )
  }
}

if (document.querySelector('.choose-address__disabled-type-button')) {
  document.querySelector('.choose-address__disabled-type-button').addEventListener('click', () => {
    document.querySelector('.choose-address__disabled-type-span').classList.toggle('visible')
  })
}

fetchAddresses()