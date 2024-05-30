export default class Game {

     constructor(spartiate, puck, container) {
        this.spartiate = spartiate;
        this.puck = puck;
        this.container = container;

        this.multiplicator = []
        this.multiplicator["A"] = 1;
        this.multiplicator["B"] = 2;
        this.multiplicator["C"] = 3;

        this.numberOfQuestions = 3;
        this.questionIndexes = this.shuffleArray(Array(this.numberOfQuestions).fill().map((_, i) => i));
    }

    shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    /**
     * Récupère une question aléatoire et l'affiche dans le canvas
     */
    getQuestion() {
        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        // Refill the index list if it's empty
        if (this.questionIndexes.length === 0) {
            this.questionIndexes = this.shuffleArray(Array(this.numberOfQuestions).fill().map((_, i) => i));
        }

        // Send Ajax request in order to get the question's information
        $.ajax({
            type: "POST",
            url: "/controls/actionController.php",
            data: {
                action: "getQuestion",
                index: this.questionIndexes[0]
            },
            dataType: 'json',
            success: (question) => {
                $("#answerA").css({
                    "--tw-bg-opacity": 0.5, // Par exemple, définir l'opacité
                    "background-color": "rgb(171, 211, 230)"
                });
                $("#answerB").css({
                    "--tw-bg-opacity": 0.5, // Par exemple, définir l'opacité
                    "background-color": "rgb(171, 211, 230)"
                });
                $("#answerC").css({
                    "--tw-bg-opacity": 0.5, // Par exemple, définir l'opacité
                    "background-color": "rgb(171, 211, 230)"
                });

                let answerShuffle = shuffleArray([question.answer, question.false1, question.false2]);
                $("#question").text(question.text);
                $("#answerA").text("A. " + answerShuffle[0]);
                $("#answerB").text("B. " + answerShuffle[1]);
                $("#answerC").text("C. " + answerShuffle[2]);
            }
        });
    }


    /**
     * Check la réponse du joueur
     **/
    checkedAnswer() {
            $.ajax({
                type: "POST",
                url: "/controls/actionController.php",
                data: {
                    action: "getAnswer",
                    index: this.questionIndexes[0]
                },
                dataType: 'json',
                success: async (answer) =>  {
                    $("#answerA").css("background-color", "#DC3545");
                    $("#answerB").css("background-color", "#DC3545");
                    $("#answerC").css("background-color", "#DC3545");
                    if (document.getElementById('answerA').textContent.slice(3) === answer) {
                        $("#answerA").css("background-color", "#28A745");
                    } else if (document.getElementById('answerB').textContent.slice(3) === answer) {
                        $("#answerB").css("background-color", "#28A745");
                    } else {
                        $("#answerC").css("background-color", "#28A745");
                    }

                    // remove the current question index of the list
                    if (this.questionIndexes.length !== 0) {
                        this.questionIndexes = this.questionIndexes.slice(1)
                    }

                }
            });
    }

    sleep = (delay) => new Promise((resolve) => setTimeout(resolve, delay))

    startSpartiateAnnimation = async (direction) => {
        this.spartiate.src = "./assets/images/annimation_spartiates.gif"
        await this.sleep(1700)
        this.movePuck(direction)
        await this.sleep(300)
        this.spartiate.src = "./assets/images/default_spartiates.png"
    }

    movePuck = (direction) => {
        //suppresion des anciennes classes
        this.puck.classList.remove("bottom-[10%]", "left-1/2")
        //repositionnement

        let caseWidth = (this.container.clientWidth / 3)
        let posX = (caseWidth * this.multiplicator[direction]) - (caseWidth / 2)
        posX = (this.container.clientWidth / 2) - posX

        let posY = this.container.clientHeight * 0.9
        this.puck.classList.add("-translate-y-["+ posY +"px]", "-translate-x-["+ posX +"px]", "transition-transform")
    }

}