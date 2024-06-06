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
    if($("#sessionCode").val() !== sessionStorage.getItem("sessionCode") || sessionStorage.getItem("sessionCode") === null){
        sessionStorage.setItem("score", "0");
        sessionStorage.setItem("sessionCode", $("#sessionCode").val());
    }


    let game = new Game(spartiate, puck, container)
    await game.initialize()
    await game.getQuestion()


    $("#score").text(game.score);

    // Link a clickListener and a button
    // This function disables the buttons until all the actions are done in order to prevent the user from spam-clicking the answers
    function attachClickListener(element, answer) {
        element.addEventListener("click", async () => {

            disableButtons();

            await game.startSpartiateAnnimation(answer);
            await game.checkedAnswer(answer);
            await game.sleep(2000)
            game.resetPuck();
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

    function initScore(message) {
        game.score = message;


    }

    function endGame(message) {

        switch (message) {
            case "stop":
                $("#endGame").show();

                $.ajax({
                    type: "POST",
                    url: "/index.php",
                    data: {
                        action: "showEndGame",
                        score: game.score,
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log(response)
                        $("#pseudo").text(response.pseudo);
                        $("#scoreEnd").text(response.score.toString());
                        $("#rank").text(response.rank.toString());
                        sessionStorage.setItem("score", "0");
                    }
                });
                break;
            default:
                break;
        }


    }

    window.endGame = endGame;
}