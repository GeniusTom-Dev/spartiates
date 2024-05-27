export default class Game {

    constructor(spartiate, puck, container) {
        this.spartiate = spartiate;
        this.puck = puck;
        this.container = container;

        this.multiplicator = []
        this.multiplicator["A"] = 1;
        this.multiplicator["B"] = 2;
        this.multiplicator["C"] = 3;
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