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
    await game.getQuestion()

    // Link a clickListener and a button
    // This function disables the buttons until all the actions are done in order to prevent the user from spam-clicking the answers
    function attachClickListener(element, answer) {
        element.addEventListener("click", async () => {

            disableButtons();

            await game.checkedAnswer(answer);
            await game.startSpartiateAnnimation(answer);
            await game.getQuestion();

            enableButtons();
        });
    }

    attachClickListener(answerA, "A");
    attachClickListener(answerB, "B");
    attachClickListener(answerC, "C");

    function disableButtons() {
        answerA.disabled = true;
        answerB.disabled = true;
        answerC.disabled = true;
    }

    function enableButtons() {
        answerA.disabled = false;
        answerB.disabled = false;
        answerC.disabled = false;
    }

    /*answerA.addEventListener("click", async () => {
        await game.checkedAnswer("A")
        await game.startSpartiateAnnimation("A")
        await game.getQuestion()
    })

    answerB.addEventListener("click", async () => {
        await game.checkedAnswer("B")
        await game.startSpartiateAnnimation("B")
        await game.getQuestion()
    })

    answerC.addEventListener("click", async () => {
        await game.checkedAnswer("C")
        await game.startSpartiateAnnimation("C")
        await game.getQuestion()
    })*/
}