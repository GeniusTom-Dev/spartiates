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
