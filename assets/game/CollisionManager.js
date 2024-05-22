export class CollisionManager {
    constructor(canvas, palet, cages, game) {
        this.canvas = canvas;
        this.palet = palet;
        this.cages = cages;
        this.game = game;
    }

    /**
     * Vérifie si un cercle est en collision avec un rectangle
     * Vérifie également la trajectoire de la balle
     * @param circle
     * @param rect
     * @param prevCircle
     * @returns {boolean}
     * @constructor
     */
    RectCircleColliding(circle, rect, prevCircle) {
        // Vérifie si le palet est en collision avec le rectangle
        let collision = this.RectCircleCollidingBasic(circle, rect);
        if (collision) {
            return true;
        }

        // Si aucune collision n'est détectée, vérifie la trajectoire de la balle
        let distX = Math.abs(prevCircle.x - circle.x);
        let distY = Math.abs(prevCircle.y - circle.y);
        let steps = Math.max(distX, distY);

        let stepX = (circle.x - prevCircle.x) / steps;
        let stepY = (circle.y - prevCircle.y) / steps;

        let testCircle = {x: prevCircle.x, y: prevCircle.y, radius: circle.radius};

        for (let i = 0; i < steps; i++) {
            testCircle.x += stepX;
            testCircle.y += stepY;

            collision = this.RectCircleCollidingBasic(testCircle, rect);
            if (collision) {
                return true;
            }
        }

        return false;
    }

    /**
     * Vérifie si un cercle est en collision avec un rectangle
     * @param circle
     * @param rect
     * @returns {boolean}
     * @constructor
     */
    RectCircleCollidingBasic(circle, rect) {
        let distX = Math.abs(circle.x - rect.x - rect.width / 2);
        let distY = Math.abs(circle.y - rect.y - rect.height / 2);

        if (distX > (rect.width / 2 + circle.radius)) {
            return false;
        }
        if (distY > (rect.height / 2 + circle.radius)) {
            return false;
        }

        if (distX <= (rect.width / 2)) {
            return true;
        }
        if (distY <= (rect.height / 2)) {
            return true;
        }

        let dx = distX - rect.width / 2;
        let dy = distY - rect.height / 2;
        return (dx * dx + dy * dy <= (circle.radius * circle.radius));
    }

    handleCollisions() {
        let i = 0;
        for (let cage of this.cages) {
            for (let rect of cage.getRects()) {
                if (this.RectCircleColliding(this.palet, rect, this.palet.prevPos)) {
                    this.bounceManager(rect);
                    this.palet.resetStartPos();
                }
            }
            if (this.RectCircleColliding(this.palet, cage.getInside(), this.palet.prevPos) && this.game.responseCage === i) {
                this.game.addScore();
                this.game.getQuestion();
            }
            ++i;
        }
        if (Math.abs(this.palet.x - 0) < this.palet.radius) { // collision avec le bord gauche du canvas
            this.palet.bounce("vertical");
            this.palet.x = this.palet.radius; // assure que la balle reste à l'intérieur du canvas
            this.palet.resetStartPos();
        } else if (Math.abs(this.palet.x - this.canvas.width) < this.palet.radius) { // collision avec le bord droit du canvas
            this.palet.bounce("vertical");
            this.palet.x = this.canvas.width - this.palet.radius; // assure que la balle reste à l'intérieur du canvas
            this.palet.resetStartPos();
        } else if (Math.abs(this.palet.y - 0) < this.palet.radius) { // collision avec le bord haut du canvas
            this.palet.bounce("horizontal");
            this.palet.y = this.palet.radius; // assure que la balle reste à l'intérieur du canvas
            this.palet.resetStartPos();
        } else if (Math.abs(this.palet.y - this.canvas.height) < this.palet.radius) { // collision avec le bord bas du canvas
            this.palet.bounce("horizontal");
            this.palet.y = this.canvas.height - this.palet.radius; // assure que la balle reste à l'intérieur du canvas
            this.palet.resetStartPos();
        }
    }

    bounceManager(rect) {
        let distX, distY;
        if (this.palet.x < rect.x) { // à gauche du rectangle
            distX = rect.x - this.palet.x;
        } else if (this.palet.x > rect.x + rect.width) { // à droite du rectangle
            distX = this.palet.x - (rect.x + rect.width);
        } else { // au-dessus ou en-dessous du rectangle
            distX = 0;
        }

        if (this.palet.y < rect.y) { // au-dessus du rectangle
            distY = rect.y - this.palet.y;
        } else if (this.palet.y > rect.y + rect.height) { // en-dessous du rectangle
            distY = this.palet.y - (rect.y + rect.height);
        } else { // à gauche ou à droite du rectangle
            distY = 0;
        }

        if (distX > distY) {
            // Collision avec le côté gauche ou droit de la cage
            this.palet.bounce("vertical");
            // Ajout d'un décalage pour éviter que la balle ne reste coincée
            this.palet.x += (this.palet.x > rect.x) ? this.palet.radius - distX : -(this.palet.radius - distX);
        } else {
            // Collision avec le haut ou le bas de la cage
            this.palet.bounce("horizontal");
            // Ajout d'un décalage pour éviter que la balle ne reste coincée
            this.palet.y += (this.palet.y > rect.y) ? this.palet.radius - distY : -(this.palet.radius - distY);
        }
    }
}