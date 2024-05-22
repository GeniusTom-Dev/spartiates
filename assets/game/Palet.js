/**
 * Classe qui représente un palet
 *
 *
 */
export class Palet {
    constructor(x, y, radius, velocity, canvas) {
        this.x = x;
        this.y = y;
        this.radius = radius;
        this.velocity = velocity;
        this.newX = x;
        this.newY = y;
        this.startX = x;
        this.startY = y;
        this.prevPos = {x: x, y: y};
        this.initialPos = {x: x, y: y};
        this.canvas = canvas;
    }

    resetPos() {
        this.x = this.initialPos.x;
        this.y = this.initialPos.y;
        this.resetStartPos();
        this.resetNewPos();
        this.resetPrevPos();
    }

    resetPrevPos() {
        this.prevPos = {x: this.x, y: this.y};
    }

    resetStartPos() {
        this.startX = this.x;
        this.startY = this.y;
    }

    checkNewPos() {
        return (this.newX !== this.x || this.newY !== this.y);
    }

    resetNewPos() {
        this.newX = this.x;
        this.newY = this.y;
    }

    draw(context, color = "#0095DD") {
        context.fillStyle = color;
        context.beginPath();
        context.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        context.fill();
        context.closePath();
    }

    move() {
        let s = {x: 1, y: 1}        // sens
            , move = {x: 1, y: 1} // pixel de déplacement
            , delta// delta -> pythagore
            , dist = {}     // distance entre start et end
        ;

        // distance x/y
        dist.x = Math.abs(this.x - this.newX);
        dist.y = Math.abs(this.y - this.newY);

        // racine carrée de A² + B² (pythagore) → donne l'hypoténuse
        delta = Math.sqrt((dist.x * dist.x) + (dist.y * dist.y));

        // ralentissement en fonction de la distance restante
        let tempV = this.velocity
        this.velocity *= delta / 1000;

        // règle des tiers afin d'avoir le déplacement par rapport à V et Delta
        move.x = (dist.x * this.velocity) / delta;
        move.y = (dist.y * this.velocity) / delta;

        this.velocity = tempV;

        // déplacement vers la gauche -1, droite 1, haut -1, bas 1
        s.x = (this.x > this.newX) ? -1 : 1;
        s.y = (this.y > this.newY) ? -1 : 1;

        // rajoute à nos coordonnées actuelles le déplacement dans le bon sens
        this.x += move.x * s.x;
        this.y += move.y * s.y;

        // retourne si l'objet est arrivé à son objectif -Vpx=marge d'erreur-
        return (dist.x <= this.velocity && dist.y <= this.velocity);
    }

    moveDown() {
        this.y += this.velocity;
    }

    bounce(status) {
        const startPoint = {x: this.startX, y: this.startY}
        const endPoint = {x: this.newX, y: this.newY}
        const collisionPoint = {x: this.x, y: this.y}

        // Calcul du vecteur de déplacement avant le rebond
        const displacementVector = {
            x: endPoint.x - startPoint.x,
            y: endPoint.y - startPoint.y
        };

        // Calcul de la normale au mur (vecteur normalisé)
        let wallNormal;
        if (status === "vertical") { // collision avec les bords gauche et droite du canvas
            wallNormal = {x: 1, y: 0};
        } else if (status === "horizontal") { // collision avec les bords haut et bas du canvas
            wallNormal = {x: 0, y: 1};
        }

        // Calcul du produit scalaire entre le vecteur de déplacement et la normale au mur
        const dotProduct = displacementVector.x * wallNormal.x + displacementVector.y * wallNormal.y;

        // Calcul du vecteur de déplacement après le rebond
        const reflectedVector = {
            x: displacementVector.x - 2 * dotProduct * wallNormal.x,
            y: displacementVector.y - 2 * dotProduct * wallNormal.y
        };

        // Calculer la distance restante avant le rebond
        const remainingDistance = Math.sqrt((endPoint.x - collisionPoint.x) ** 2 + (endPoint.y - collisionPoint.y) ** 2);

        // Normaliser le vecteur réfléchi
        const length = Math.sqrt(reflectedVector.x * reflectedVector.x + reflectedVector.y * reflectedVector.y);
        reflectedVector.x /= length;
        reflectedVector.y /= length;

        // Multiplier par la distance restante
        reflectedVector.x *= remainingDistance;
        reflectedVector.y *= remainingDistance;

        // Calcul du nouveau point d'arrivée
        this.newX = collisionPoint.x + reflectedVector.x
        this.newY = collisionPoint.y + reflectedVector.y
    }

    bounceVertical() {
        this.newX = this.x - (this.newX - this.x);
    }

    bounceHorizontal() {
        this.newY = this.y - (this.newY - this.y);
    }
}