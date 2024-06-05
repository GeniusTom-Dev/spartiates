export default class Game {

    constructor(spartiate, puck, container) {
        this.spartiate = spartiate;
        this.puck = puck;
        this.container = container;

        this.multiplicator = []
        this.multiplicator["A"] = 1;
        this.multiplicator["B"] = 2;
        this.multiplicator["C"] = 3;

        this.savePuckClass = Array.from(this.puck.classList);

    }

    async initialize() {
        this.numberOfQuestions = await this.getQuestionsNumber();
        this.questionIndexes = this.shuffleArray(Array(this.numberOfQuestions).fill().map((_, i) => i));
    }

    shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    async getQuestionsNumber() {
        return await $.ajax({
            type: "POST",
            url: "/class/controls/actionController.php",
            data: {
                action: "getQuestionsNumber",
            },
            dataType: 'json',
        });
    }

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
            url: "/class/controls/actionController.php",
            data: {
                action: "getQuestion",
                index: this.questionIndexes[0]
            },
            dataType: 'json',
            success: async (question) => {

                // Reset of the background color of answers
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

                // Shuffle and display the possible answer of the question
                let answerShuffle = shuffleArray([question.answer, question.false1, question.false2]);
                $("#question").text(question.text);
                $("#answerA").text("A. " + answerShuffle[0]);
                $("#answerB").text("B. " + answerShuffle[1]);
                $("#answerC").text("C. " + answerShuffle[2]);
            }
        });
    }


    /**
     * Check the player's answer
     **/
    checkedAnswer(playerAnswer) {
            $.ajax({
                type: "POST",
                url: "/class/controls/actionController.php",
                data: {
                    action: "getAnswer",
                    index: this.questionIndexes[0]
                },
                dataType: 'json',
                success: async (answer) =>  {

                    const answers = {
                        "A": document.getElementById('answerA'),
                        "B": document.getElementById('answerB'),
                        "C": document.getElementById('answerC')
                    };

                    // Function to update the background colors
                    const updateBackgroundColors = () => {
                        Object.keys(answers).forEach(key => {
                            // If the answer is the right one, the background color of the button become green
                            // Otherwise, the background color will be red
                            answers[key].style.backgroundColor = (answers[key].innerHTML.slice(3) === answer) ? "#28A745" : "#DC3545";
                        });
                    };

                    updateBackgroundColors();

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
        await this.sleep(1650)
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

    resetPuck = () => {
        this.puck.classList.remove(...this.puck.classList);
        this.puck.classList.add(...this.savePuckClass);
    }
}