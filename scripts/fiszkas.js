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

function getRandomInt(min, max) {
  const minCeiled = Math.ceil(min);
  const maxFloored = Math.floor(max);
  return Math.floor(Math.random() * (maxFloored - minCeiled) + minCeiled); // The maximum is exclusive and the minimum is inclusive
}

function displayFiszka() {
  let targetId = "#zestaw" + currentFiszka.toString();

  document.querySelectorAll(".zestaw").forEach((z) => {
    z.style.display = "none";
    z.querySelector(".zestaw-inner").classList.remove("flipped");
  });

  document.querySelector(targetId).style.display = "flex";
  const target = document.querySelector(targetId);
  let hintsArr = [];

  if (target) {
    const hints = target.querySelector(".hints");
    if (hints) {
      hintsArr = hints.querySelectorAll(".hints-inner");
    }
  }

  hintsCount = hintsArr.length;

  if (hintsCount > 0) {
    setInterval(() => {
      let rand = getRandomInt(0, hintsCount);
      hintsArr.forEach((div) => {
        div.style.display = "none";
      });
      hintsArr[rand].style.display = "flex";
      console.log(rand);
    }, getRandomInt(4000, 7000));
  }

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
