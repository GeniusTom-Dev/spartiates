import {Rectangle} from "./Rectangle.js"

/**
 * Classe qui représente une cage
 * @param {Rectangle} back : rectangle qui représente le fond de la cage
 * @param {Rectangle} poteauGauche : rectangle qui représente le poteau gauche de la cage
 * @param {Rectangle} poteauDroite : rectangle qui représente le poteau droit de la cage
 * @param {Rectangle} interieurCage : rectangle qui représente l'intérieur de la cage
 */
export class Cage {
    constructor(back) {
        this.back = back;
        this.leftPole = new Rectangle(back.x, back.y, back.height, Math.trunc(back.width / 2), "black");
        this.rightPole = new Rectangle(back.x + back.width - back.height, back.y, back.height, Math.trunc(back.width / 2), "black");
        this.inside = new Rectangle(back.x + back.height, back.y + back.height, back.width - back.height * 2, Math.trunc(back.width / 8), "red");
    }

    draw(context) {
        // poteau gauche
        this.leftPole.draw(context);
        //poteau droit
        this.rightPole.draw(context);
        // fond de la cage
        this.back.draw(context);
    }

    getInside() {
        return this.inside;
    }

    getBack() {
        return this.back;
    }

    getRects() {
        return [this.back, this.leftPole, this.rightPole];
    }
}

