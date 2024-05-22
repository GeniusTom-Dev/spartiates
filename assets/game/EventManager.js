export class EventManager {
    constructor(palet, canvas) {
        this.palet = palet;
        this.canvas = canvas;
        this.mouseIsDown = false;
        this.gameActive = true;
    }

    getNewPos() {
        return {x: this.newX, y: this.newY};
    }

    setNewPos(x, y) {
        this.newX = x;
        this.newY = y;
    }

    getMouseIsDown() {
        return this.mouseIsDown;
    }

    handleMouseDown(e) {
        if (this.gameActive) {
            document.getElementById("tutorial-hand").style.display = "none";
            let pos = this.getMouseOrTouchPos(e);
            if (pos.x < this.palet.x + this.palet.radius && pos.x > this.palet.x - this.palet.radius &&
                pos.y < this.palet.y + this.palet.radius && pos.y > this.palet.y - this.palet.radius) {
                this.mouseIsDown = true;
            }
        }
    }

    handleMouseUp(e) {
        if (this.mouseIsDown) {
            let pos = this.getMouseOrTouchPos(e);
            this.palet.newX = this.palet.x + ((this.palet.x - pos.x) * 5);
            this.palet.newY = this.palet.y - ((pos.y - this.palet.y) * 5);
        }
        this.mouseIsDown = false;
    }

    handleTouchEnd(e) {
        if (this.mouseIsDown) {
            let pos = this.getMouseOrTouchPos(e.changedTouches[0]);
            this.palet.newX = this.palet.x + ((this.palet.x - pos.x) * 5);
            this.palet.newY = this.palet.y - ((pos.y - this.palet.y) * 5);
        }
        this.mouseIsDown = false;
    }

    handleMouseMove(e) {
        if (this.mouseIsDown) {
            let pos = this.getMouseOrTouchPos(e);
            this.palet.newX = (this.palet.x + (this.palet.x - pos.x));
            this.palet.newY = (this.palet.y - (pos.y - this.palet.y));
            this.palet.resetStartPos();
        }
    }


    // Fonction pour détecter l'orientation
    handleOrientation() {
        // Récupérer l'angle d'orientation
        const orientationAngle = window.screen.orientation.angle;

        // Déterminer le mode paysage ou portrait en fonction de l'angle
        const isLandscape = Math.abs(orientationAngle) === 90;

        // Faire quelque chose en fonction de l'orientation
        if (isLandscape) {
            // Le site est en mode paysage
            console.log('Le site est en mode paysage.');
            document.getElementById("blockLandscape").style.display = "flex";
        } else {
            // Le site est en mode portrait
            if(document.getElementById("blockLandscape").style.display === "flex"){
                console.log('Le site est en mode portrait.');
                document.getElementById("blockLandscape").style.display = "none";
                location.reload();
            }
        }
    }

    getMouseOrTouchPos(event) {
        let rect = this.canvas.getBoundingClientRect();
        if (event.touches && event.touches.length > 0) {
            return {
                x: event.touches[0].clientX - rect.left,
                y: event.touches[0].clientY - rect.top
            };
        } else {
            return {
                x: event.clientX - rect.left,
                y: event.clientY - rect.top
            };
        }
    }


}