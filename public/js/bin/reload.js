document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".choose-times__day-input").forEach((element) => {
    if (element.checked) {
      element.checked = false;
    }
  });
});
// --------------
window.addEventListener("pageshow", function (event) {
  if (event.persisted) {
    // La page vient du cache : on la recharge complètement
    window.location.reload();
  }
});
// --------------
if (performance.navigation.type === 2) {
  // L'utilisateur a navigué avec le bouton "retour"
  location.reload(true); // recharge forcée
}
