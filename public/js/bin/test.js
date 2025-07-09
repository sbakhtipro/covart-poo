////////////////////////////// PROPOSER UN TRAJET //////////////////////////////

const divDeparture = document.querySelector('.choose-address__departure')
const divArrival = document.querySelector('.choose-address__arrival')
const allerCheckbox = document.getElementById('aller')
const retourCheckbox = document.getElementById('retour')

// récupérer liste adresses entreprise

let data = null;

async function fetchAddresses() {
    try {
        const response = await fetch(
            "index.php?controller=propose-commute&method=fetch-addresses"
        );
        if (!response.ok) {
            throw new Error("Données non récupérées");
        }
        console.log(response);
        data = await response.json();
        displayAddresses();
    } catch (error) {
        console.error("Données non récupérées : ", error);
    }
}

function fetchResultsForAutofill() {
    getFields()
    const input = document.getElementById("address-input");
    const results = document.getElementById("results");
    const hiddenInput = document.getElementById("coordonnees-input");
  
    input.addEventListener("input", () => {
        let query = input.value.trim();
        if (query.length < 3) {
            return "";
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
                    let li = document.createElement("li");
                    li.textContent = element["properties"]["label"];
                    results.appendChild(li);
                    li.addEventListener("click", () => {
                        input.value = li.textContent;
                        results.innerHTML = "";
                        hiddenInput.value =
                            element["geometry"]["coordinates"][1] +
                            ", " +
                            element["geometry"]["coordinates"][0];
                        if (hiddenInput.value.length > 0) {
                            document.getElementById("submit").style.display = "block";
                        }
                    });
                });
                if (results.innerHTML === "") {
                    let noResult = document.createElement("li")
                    noResult.textContent = 'Aucun résultat'
                    results.appendChild(noResult);
                }
            });
    });
}

function setSelectCoordinates() {
    let hiddenList = document.getElementById("coordonnees-list");
    let list = document.getElementById("list-address");
    let selected = list.selectedOptions[0];
    hiddenList.value = selected.dataset.coordonnees;
    list.addEventListener("change", () => {
        hiddenList.value = selected.dataset.coordonnees;
    });
}

function getFields() {
    const input =
    `<input type="text" id="address-input" class="choose-address__input" name="input-address" placeholder="Rechercher une adresse" required>
    <ul id="results" class="choose-address__suggestions"></ul>`;

    if (data) {
        const adressList = 
        `<select class="choose-address__input" name="list-address" id="list-address">`;
            data.forEach((element) => {
            adressList += `<option data-coordonnees="${element["agence_lat"]}, ${element["agence_lon"]}" required>${element["agence_numero_voie"]} ${element["agence_voie"]}, ${element["agence_code_postal"]} ${element["agence_ville"]}</option>`
            });
        adressList += `</select>`;
    }
}

function createFinalFields() {
    allerCheckbox.addEventListener('click', () => {
        divDeparture.innerHTML = '<p>Départ :</p>' . input
        divArrival.innerHTML = '<p>Arrivée :</p>' . adressList
        fetchResultsForAutofill();
        setSelectCoordinates();
    })
    retourCheckbox.addEventListener('click', () => {
        divDeparture.innerHTML = '<p>Départ :</p>' . adressList
        divArrival.innerHTML = '<p>Arrivée :</p>' . input
        fetchResultsForAutofill();
        setSelectCoordinates();
    })
}

function displayAddresses() {
    createFinalFields()
}

fetchAddresses()

