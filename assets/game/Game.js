import {Cage} from "./Cage.js";
import {Palet} from "./Palet.js";
import {CanvasManager} from "./CanvasManager.js";
import {CollisionManager} from "./CollisionManager.js";
import {EventManager} from "./EventManager.js";
import {Rectangle} from "./Rectangle.js";

export class Game {
    constructor(canvas, staticCanvas) {
        this.canvasManager = new CanvasManager(canvas, staticCanvas);
        let tailleCage = Math.trunc(this.canvasManager.getCanvas().width * (2.5 / 10));
        var tmpCanvas = this.canvasManager.getCanvas();
        this.leftCage = new Cage(new Rectangle(Math.trunc(tmpCanvas.width * (2 / 10)) - tailleCage / 2, Math.trunc(tmpCanvas.height * (1 / 10)), tailleCage, Math.trunc(tailleCage / 15), "grey"));
        this.midCage = new Cage(new Rectangle(Math.trunc(tmpCanvas.width / 2) - tailleCage / 2, Math.trunc(tmpCanvas.height * (1 / 10)), tailleCage, Math.trunc(tailleCage / 15), "grey"));
        this.rightCage = new Cage(new Rectangle(Math.trunc(tmpCanvas.width * (8 / 10)) - tailleCage / 2, Math.trunc(tmpCanvas.height * (1 / 10)), tailleCage, Math.trunc(tailleCage / 15), "grey"));
        this.palet = new Palet(Math.trunc(tmpCanvas.width / 2),
            Math.trunc(tmpCanvas.height * (7 / 10)),
            Math.trunc(this.midCage.getBack().width / 8), 10, tmpCanvas);
        this.collisionManager = new CollisionManager(this.canvasManager.getCanvas(), this.palet, [this.leftCage, this.midCage, this.rightCage], this);
        this.eventManager = new EventManager(this.palet, this.canvasManager.getCanvas(), this);
        this.score = 0;
        this.responseCage = 0;
        this.gameActive = true
    }

    static endGame() {
        $.ajax({
            type: "POST",
            url: "/controls/actionController.php",
            data: {
                action: "showEndGame",
                score: parseInt(sessionStorage.getItem("score")),
            },
            dataType: 'json',
            success: function (response) {
                $("#pseudo").text(response.pseudo);
                $("#scoreEnd").text(response.score.toString());
                $("#rank").text(response.rank.toString());
                sessionStorage.setItem("score", 0);
            }
        });
    }

    /**
     * Dessine une flèche entre deux points
     * @param fromX
     * @param fromY
     * @param toX
     * @param toY
     */
    drawArrow(fromX, fromY, toX, toY) {
        var headlen = 10;   // length of head in pixels
        var angle = Math.atan2(toY - fromY, toX - fromX);
        const ctx = this.canvasManager.getCtx();
        ctx.strokeStyle = "black";
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(fromX, fromY);
        ctx.lineTo(toX, toY);
        ctx.lineTo(toX - headlen * Math.cos(angle - Math.PI / 6), toY - headlen * Math.sin(angle - Math.PI / 6));
        ctx.moveTo(toX, toY);
        ctx.lineTo(toX - headlen * Math.cos(angle + Math.PI / 6), toY - headlen * Math.sin(angle + Math.PI / 6));
        ctx.stroke();
    }

    /**
     * Démarre le jeu
     */
    start() {
        document.getElementById("tutorial-hand").style.display = "none";

        this.isInActiveSession();
        if (sessionStorage.getItem("question") !== null) {
            this.responseCage = parseInt(sessionStorage.getItem("randCage"));
            $("#question").text(sessionStorage.getItem("question"));
            $("#rep1").text(sessionStorage.getItem("repA"));
            $("#rep2").text(sessionStorage.getItem("repB"));
            $("#rep3").text(sessionStorage.getItem("repC"));
        } else {
            this.getQuestion();
        }
        // Récupération du score du joueur
        if (!isNaN(parseInt(sessionStorage.getItem("score")))) {
            this.score = parseInt(sessionStorage.getItem("score"));
        }
        document.getElementById("score").innerText = this.score;

        // Gestion des événements
        window.addEventListener('mousedown', (e) => this.eventManager.handleMouseDown(e));
        window.addEventListener('mouseup', (e) => this.eventManager.handleMouseUp(e));
        window.addEventListener('mousemove', (e) => this.eventManager.handleMouseMove(e));
        window.addEventListener('touchstart', (e) => this.eventManager.handleMouseDown(e));
        window.addEventListener('touchend', (e) => this.eventManager.handleTouchEnd(e));
        window.addEventListener('touchmove', (e) => this.eventManager.handleMouseMove(e));
        this.eventManager.handleOrientation();
        // Gestion du changement de taille de la fenêtre
        window.addEventListener('orientationchange', (e) => this.eventManager.handleOrientation());
        window.addEventListener('resize',  (e) => this.eventManager.handleOrientation());

        this.drawImage(this.leftCage.back.x, this.leftCage.back.y, this.leftCage.back.width, this.leftCage.leftPole.height);
        this.drawImage(this.midCage.back.x, this.midCage.back.y, this.midCage.back.width, this.midCage.leftPole.height);
        this.drawImage(this.rightCage.back.x, this.rightCage.back.y, this.rightCage.back.width, this.rightCage.leftPole.height);

        // Boucle de jeu
        setInterval(() => {
            this.canvasManager.clear();
            this.canvasManager.drawStatic();
            this.palet.draw(this.canvasManager.getCtx());
            /*this.leftCage.draw(this.canvasManager.getCtx());
            this.midCage.draw(this.canvasManager.getCtx());
            this.rightCage.draw(this.canvasManager.getCtx());*/
            // Gestion du déplacement du palet
            if (this.eventManager.getMouseIsDown()) {
                this.drawArrow(this.palet.x, this.palet.y, this.palet.newX, this.palet.newY);
            }
            if (this.palet.checkNewPos() && !this.eventManager.getMouseIsDown()) {
                this.palet.resetPrevPos();
                if (this.palet.move()) {
                    this.palet.resetPos();
                }
            }
            this.collisionManager.handleCollisions();
        }, 10);
    }

    /**
     * Dessine une image dans le canvas statique
     * @param x
     * @param y
     * @param w
     * @param h
     */
    drawImage(x, y, w, h) {
        let image = new Image();
        image.src = "/assets/images/hockeyCage.png";
        let canvas = this.canvasManager.getStaticCanvas();
        let ctx = this.canvasManager.getStaticCtx();
        image.onload = function () {
            // Vérifie que l'image est dans la zone de dessin du canvas
            if (image.width > canvas.width || image.height > canvas.height) {
                // Déplace l'image à l'intérieur de la zone de dessin
                image.x = (canvas.width - image.width) / 2;
                image.y = (canvas.height - image.height) / 2;
            }
            // Dessine l'image
            ctx.drawImage(image, x, y, w, h);
        }
    }

    /**
     * Récupère une question aléatoire et l'affiche dans le canvas
     * @note Vérifier si modification nécessaire / Ou QuestionManager ?
     */
    getQuestion() {
        this.responseCage = Math.floor(Math.random() * 3);
        let randCage = this.responseCage
        $.ajax({
            type: "POST",
            url: "/controls/actionController.php",
            data: {
                action: "getRandomQuestion",
            },
            dataType: 'json',
            success: function (response) {
                let repA = (randCage === 0) ? response.vrai : response.faux1;
                let repB = (randCage === 1) ? response.vrai : (randCage === 2) ? response.faux2 : response.faux1;
                let repC = (randCage === 2) ? response.vrai : response.faux2;
                sessionStorage.setItem("randCage", randCage);
                sessionStorage.setItem("question", response.text);
                sessionStorage.setItem("repA", repA);
                sessionStorage.setItem("repB", repB);
                sessionStorage.setItem("repC", repC);
                $("#question").text(response.text);
                $("#rep1").text(repA);
                $("#rep2").text(repB);
                $("#rep3").text(repC);
            }
        });
    }

    addScore() {
        this.score += 100;
        sessionStorage.setItem("score", this.score);
        $("#score").text(this.score);
        this.palet.resetPos();
        sendScore(this.score);
    }

    /**
     * Fonction qui permet de verifier
     * si le joueur est toujours dans la session
     */
    isInActiveSession() {
        $.ajax({
            type: "POST",
            url: "/controls/actionController.php",
            data: {
                action: "isInActiveSession",
            },
            success: function (response) {
                if (response === 'notActive') {
                    $("#endGame").show();
                    Game.endGame("reload");
                } else if (response === 'false') {
                    window.location.href = "/home";
                } else if (response === 'true') {
                    $("#endGame").hide();
                }
            }
        });
    }

}


