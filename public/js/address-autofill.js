function autofill() {
  const input = document.getElementById("address-input")
  const hiddenInputLat = document.getElementById("coordonnees-lat")
  const hiddenInputLon = document.getElementById("coordonnees-lon")
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
            hiddenInputLat.value = element["geometry"]["coordinates"][1]
            hiddenInputLon.value = element["geometry"]["coordinates"][0]
            if (hiddenInputLat.value.length > 0 || hiddenInputLon.value.length > 0) {
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

autofill()