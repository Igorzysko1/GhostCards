let currentFiszka = 1;

const fiszkasList = document.querySelector("main").querySelectorAll(".zestaw");
const fiszkasListLen = fiszkasList.length;

document.querySelectorAll(".zestaw").forEach((card) => {
  const inner = card.querySelector(".zestaw-inner");
  const pytanie = card.querySelector(".pytanie");
  const odpowiedz = card.querySelector(".odpowiedz");

  inner.addEventListener("click", () => {
    inner.classList.toggle("flipped");

    if (inner.classList.contains("flipped")) {
      setTimeout(() => {
        pytanie.style.display = "none";
        odpowiedz.style.display = "flex";
      }, 300); // Dopasuj do czasu transition
    } else {
      setTimeout(() => {
        pytanie.style.display = "flex";
        odpowiedz.style.display = "none";
      }, 300);
    }
  });
});

function displayFiszka() {
  let targetId = "#zestaw" + currentFiszka.toString();

  document.querySelectorAll(".zestaw").forEach((z) => {
    z.style.display = "none";
    z.querySelector(".zestaw-inner").classList.remove("flipped");
  });

  document.querySelector(targetId).style.display = "flex";

  console.log(currentFiszka);

  if (currentFiszka == 1) {
    document.querySelector(".fiszka-prev").setAttribute("disabled", "1");
  } else {
    document.querySelector(".fiszka-prev").removeAttribute("disabled");
  }

  if (currentFiszka == fiszkasListLen) {
    document.querySelector(".fiszka-next").setAttribute("disabled", "1");
  } else {
    document.querySelector(".fiszka-next").removeAttribute("disabled");
  }
}

function nextFiszka() {
  currentFiszka++;
  displayFiszka();
}

function previousFiszka() {
  currentFiszka--;
  displayFiszka();
}

displayFiszka();
