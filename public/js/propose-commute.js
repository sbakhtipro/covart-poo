////////////////////////////// PROPOSER UN TRAJET //////////////////////////////

const aller = document.querySelector('#aller');
const retour = document.querySelector("#retour");
const departurePlace = document.querySelector(".choose-address__departure");
const arrivalPlace = document.querySelector(".choose-address__arrival");

// récupérer liste adresses entreprise
let data = null;

async function fetchAddresses() {
  try {
    const response = await fetch(
      "index.php?controller=proposed-commute&method=fetch-addresses"
    );
    if (!response.ok) {
      throw new Error("Données non récupérées");
    }
    console.log(response);
    data = await response.json();
    console.log(data);
    displayAddresses();
  } catch (error) {
    console.error("Données non récupérées : ", error);
  }
}

function getResults() {
  const input = document.getElementById("address-input");
  const hiddenInput = document.getElementById("coordonnees-input");
  const results = document.getElementById("results");
  input.addEventListener("input", () => {
    console.log("test");
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
        results.innerHTML = "";
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
              document.getElementById('submit').style.display = "block"
            }
          });
        });
      });
  });
}

function setSelectCoordinates() {
  let hiddenList = document.getElementById("coordonnees-list");
  let list = document.getElementById("list-address");
  let selected = list.selectedOptions[0]
  hiddenList.value = selected.dataset.coordonnees;
  list.addEventListener("change", () => {
    hiddenList.value = selected.dataset.coordonnees;
    console.log("test");
  });
}

function displayAddresses() {
  if (data) {
    let adressInput = `<input type="text" id="address-input" class="choose-address__input" name="input-address" placeholder="Rechercher une adresse" required>
            <ul id="results" class="choose-address__suggestions"></ul>`;
    let adressList = `<select class="choose-address__input" name="list-address" id="list-address">`;
    data.forEach((element) => {
      adressList += `<option data-coordonnees="${element["agence_lat"]}, ${element["agence_lon"]}" required>${element["agence_numero_voie"]} ${element["agence_voie"]}, ${element["agence_code_postal"]} ${element["agence_ville"]}</option>
            `;
    });
    adressList += `</select>`;

    aller.addEventListener("click", () => {
      if (aller.checked) {
        aller.parentElement.classList.add(
          "choose-address__type-radio--checked"
        );
        retour.parentElement.classList.remove(
          "choose-address__type-radio--checked"
        );
        departurePlace.style.display = "block";
        arrivalPlace.style.display = "block";
        departurePlace.innerHTML =
          `<label class="choose-address__label" for="address-input">Départ :</label>` +
          adressInput;
        arrivalPlace.innerHTML =
          `<p class="choose-address__label">Arrivée :</p>` + adressList;
        getResults();
        setSelectCoordinates();
      }
    });
    retour.addEventListener("click", () => {
      if (retour.checked) {
        retour.parentElement.classList.add(
          "choose-address__type-radio--checked"
        );
        aller.parentElement.classList.remove(
          "choose-address__type-radio--checked"
        );
        departurePlace.style.display = "block";
        arrivalPlace.style.display = "block";
        departurePlace.innerHTML =
          `<p class="choose-address__label">Départ :</p>` + adressList;
        arrivalPlace.innerHTML =
          `<label class="choose-address__label" for="address-input">Arrivée :</label>` +
          adressInput;
        getResults();
        setSelectCoordinates();
      }
    })
  }
}

fetchAddresses();