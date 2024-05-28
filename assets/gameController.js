import Game from "./Game.js"

let spartiate = document.getElementById("spartiates")
let puck = document.getElementById("puck")
let container = document.getElementById("container")

let answerA = document.getElementById("answerA")
let answerB = document.getElementById("answerB")
let answerC = document.getElementById("answerC")

let elements = [spartiate, puck, container, answerA, answerB, answerC];

let allElementsLoaded = elements.every(element => element);

if (allElementsLoaded){
    let game = new Game(spartiate, puck, container)

    // TODO : A implémenté
    getQuestion()

    answerA.addEventListener("click", async () => {
        await game.startSpartiateAnnimation("A")
    })

    answerB.addEventListener("click", async () => {
        await game.startSpartiateAnnimation("B")
    })

    answerC.addEventListener("click", async () => {
        await game.startSpartiateAnnimation("C")
    })
}

function shuffleArray(array) {
     for (let i = array.length - 1; i > 0; i--) {
          const j = Math.floor(Math.random() * (i + 1));
          [array[i], array[j]] = [array[j], array[i]];
     }
     return array;
}

/**
 * Récupère une question aléatoire et l'affiche dans le canvas
 */
function getQuestion() {
     $.ajax({
          type: "POST",
          url: "/controls/actionController.php",
          data: {
               action: "getRandomQuestion",
          },
          dataType: 'json',
          success: function (question) {
               let answerShuffle = shuffleArray([question.answer, question.false1, question.false2]);
               $("#question").text(question.text);
               $("#answerA").text(answerShuffle[0]);
               $("#answerB").text(answerShuffle[1]);
               $("#answerC").text(answerShuffle[2]);
          }
     });
}