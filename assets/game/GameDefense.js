import {DefenseCollisionManager} from "./DefenseCollisionManager.js";
import {EventManager} from "./EventManager.js";
import {Cage} from "./Cage.js";
import {Rectangle} from "./Rectangle.js";
import {Palet} from "./Palet.js";
import {CanvasManager} from "./CanvasManager.js";

export class GameDefense {
    constructor(canvas, staticCanvas) {
        this.canvasManager = new CanvasManager(canvas, staticCanvas);

        this.canvas = canvas;
        let goalSize = Math.trunc(canvas.width * (2.5 / 10)); // taille de la cage en fonction de la taille du Canva.

        let goalBackX = Math.trunc(canvas.width / 2) - goalSize / 2
        let goalBackY = Math.trunc(canvas.height * (9 / 10)) - goalSize / 8
        let goalBackWidth = goalSize
        let goalBackHeight = Math.trunc(goalSize / 15)

        this.goal = new Cage(
            new Rectangle(goalBackX, goalBackY, goalBackWidth, goalBackHeight, "grey")
        );

        this.defender = new Palet(
            Math.trunc(this.canvas.width / 2),
            Math.trunc(this.canvas.height * (7 / 10)),
            Math.trunc(this.goal.getBack().width / 8),
            10,
            this.canvas
        );
        this.leftStriker = new Palet(
            Math.trunc(this.canvas.width / 5),
            Math.trunc(this.canvas.height * (2 / 10)),
            Math.trunc(this.goal.getBack().width / 8),
            0.25,
            this.canvas
        );
        this.midleStriker = new Palet(
            Math.trunc(this.canvas.width / 2),
            Math.trunc(this.canvas.height * (2 / 10)),
            Math.trunc(this.goal.getBack().width / 8),
            0.25,
            this.canvas
        );
        this.rightStriker = new Palet(
            Math.trunc(this.canvas.width / 5) * 4,
            Math.trunc(this.canvas.height * (2 / 10)),
            Math.trunc(this.goal.getBack().width / 8),
            0.25,
            this.canvas
        );
        this.eventManager = new EventManager(this.defender, this.canvas);
        this.collisionManager = new DefenseCollisionManager(this, this.canvas);
        this.score = 0;
        this.responseStriker = 0;
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

    drawArrow(fromX, fromY, toX, toY) {
        let headlen = 10;   // length of head in pixels
        let angle = Math.atan2(toY - fromY, toX - fromX);
        const ctx = this.canvas.getContext("2d");
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

    start() {
        this.isInActiveSession();
        if (sessionStorage.getItem("question") !== null) {
            this.responseStriker = parseInt(sessionStorage.getItem("randStriker"));
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


        // Les listener pour écouter chaque mouvement de la souris associé à leur méthodes
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

        this.drawImage(this.goal.back.x, this.goal.back.y, this.goal.back.width, this.goal.leftPole.height);

        // Boucle de jeu
        setInterval(() => {
            this.canvasManager.clear(); // ctx.clearRect(0, 0, canvas.width, canvas.height);
            this.canvasManager.drawStatic(); // ctx.drawImage(staticCanvas, 0, 0);

            //this.goal.draw(this.canvasManager.getCtx());
            this.defender.draw(this.canvasManager.getCtx());
            this.leftStriker.draw(this.canvasManager.getCtx(), "#FA5456");
            this.midleStriker.draw(this.canvasManager.getCtx(), "#FA5456");
            this.rightStriker.draw(this.canvasManager.getCtx(), "#FA5456");

            if (this.eventManager.getMouseIsDown()) {
                this.drawArrow(this.defender.x, this.defender.y, this.defender.newX, this.defender.newY);// drawArrow(ball.x,ball.y,newX,newY);
            }

            if (this.defender.checkNewPos() && !this.eventManager.getMouseIsDown()) {//getMouseIsDown?
                this.defender.resetPrevPos();
                if (this.defender.move()) {
                    this.defender.resetNewPos();
                }
            }

            // Déplacer les attaquants vers le bas
            this.leftStriker.moveDown();
            this.midleStriker.moveDown();
            this.rightStriker.moveDown();

            this.collisionManager.handleCollisionsDefense(this.defender, this.goal, [this.leftStriker, this.midleStriker, this.rightStriker])

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
        this.defender.resetPos();
        this.responseStriker = Math.floor(Math.random() * 3);
        let randStriker = this.responseStriker
        $.ajax({
            type: "POST",
            url: "/controls/actionController.php",
            data: {
                action: "getRandomQuestion",
            },
            dataType: 'json',
            success: function (response) {
                let repA = (randStriker === 0) ? response.vrai : response.faux1;
                let repB = (randStriker === 1) ? response.vrai : (randStriker === 2) ? response.faux2 : response.faux1;
                let repC = (randStriker === 2) ? response.vrai : response.faux2;
                sessionStorage.setItem("randStriker", randStriker);
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
        this.defender.resetPos();
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
                    GameDefense.endGame("reload");
                } else if (response === 'false') {
                    window.location.href = "/home";
                } else if (response === 'true') {
                    $("#endGame").hide();
                }
            }
        });
    }
}