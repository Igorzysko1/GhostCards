let currentFiszka = 1;

const fiszkasList = document.querySelector("main").querySelectorAll(".zestaw");
const fiszkasListLen = fiszkasList.length;

function displayFiszka(curr) {
  let targetId = "#zestaw" + curr.toString();
  document.querySelector(targetId).style.display = "block";
}

function nextFiszka() {
  let currentId = "#zestaw" + currentFiszka.toString();
  document.querySelector(currentId).style.display = "none";

  targetId = currentFiszka + 1;
  displayFiszka(targetId);

  currentFiszka = targetId;
}

function previousFiszka() {
  let currentId = "#zestaw" + currentFiszka.toString();
  document.querySelector(currentId).style.display = "none";

  targetId = currentFiszka - 1;
  displayFiszka(targetId);

  currentFiszka = targetId;
}

displayFiszka(currentFiszka);
