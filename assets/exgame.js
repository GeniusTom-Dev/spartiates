// /**
//  * Projet : Projet Serious game - Hockey sur glace
//  * Par : Groupe 5
//  * @author: LKS
//  * @version: 1.0
//  */
//
// // boolean qui est vrai si la souris est clicker non si elle ne l'ai pas
// let mouseIsDown = false;
//
// // pourcentage de la taille du canvas par rapport à la taille de la fenêtre
// let widthPercentage = 100;
// let heightPercentage = 80;
// // cage de la bonne réponse
// let randCage;
//
// let cage = new Image();
// cage.src = "/assets/images/hockeyCage.png";
//
// //setup du canvas
// let canvas = document.getElementById("myCanvas"); // récupération du canvas
// // Calculer la nouvelle largeur en fonction de la largeur de la fenêtre
// canvas.width = (widthPercentage / 100) * window.innerWidth;
// // Calculer la nouvelle hauteur en fonction de la hauteur de la fenêtre
// canvas.height = (heightPercentage / 100) * window.innerHeight;
// let ctx = canvas.getContext("2d"); // récupération du contexte du canvas
// canvas.style.backgroundImage = "url('/assets/images/ice.webp')";// ajout d'un background au canvas
// canvas.style.backgroundSize = "cover"; // ajustement du background au canvas
//
// // Créer un canvas hors écran pour dessiner les éléments statiques une fois
// let staticCanvas = document.createElement('canvas');
// staticCanvas.width = canvas.width;
// staticCanvas.height = canvas.height;
// var staticContext = staticCanvas.getContext('2d');
// let gameActive = false;
//
// /**
//  * Classe qui représente un rectangle
//  * @param {Number} x : position x du rectangle
//  * @param {Number} y : position y du rectangle
//  * @param {Number} width : largeur du rectangle
//  * @param {Number} height : hauteur du rectangle
//  * @param {String} color : couleur du rectangle
//  */
// class Rectangle {
//     constructor(x, y, width, height, color) {
//         this.x = x;
//         this.y = y;
//         this.width = width;
//         this.height = height;
//         this.color = color;
//     }
// }
//
// /**
//  * Classe qui représente une cage
//  * @param {Rectangle} fond : rectangle qui représente le fond de la cage
//  * @param {Rectangle} poteauGauche : rectangle qui représente le poteau gauche de la cage
//  * @param {Rectangle} poteauDroite : rectangle qui représente le poteau droit de la cage
//  * @param {Rectangle} interieurCage : rectangle qui représente l'intérieur de la cage
//  */
// class Cage {
//     constructor(fond) {
//         this.fond = fond;
//         this.poteauGauche = new Rectangle(fond.x, fond.y, fond.height, Math.trunc(fond.width / 2), "black");
//         this.poteauDroite = new Rectangle(fond.x + fond.width - fond.height, fond.y, fond.height, Math.trunc(fond.width / 2), "black");
//         this.interieurCage = new Rectangle(fond.x + fond.height, fond.y + fond.height, fond.width - fond.height * 2, Math.trunc(fond.width / 8), "red");
//     }
// }
//
// // les objets qui représente la cage
// tailleCage = Math.trunc(canvas.width * (2.5 / 10));
// let cageLeft = new Cage(new Rectangle(Math.trunc(canvas.width * (2 / 10)) - tailleCage / 2, Math.trunc(canvas.height * (1 / 10)), tailleCage, Math.trunc(tailleCage / 15), "grey"));
// let cageMid = new Cage(new Rectangle(Math.trunc(canvas.width / 2) - tailleCage / 2, Math.trunc(canvas.height * (1 / 10)), tailleCage, Math.trunc(tailleCage / 15), "grey"));
// let cageRight = new Cage(new Rectangle(Math.trunc(canvas.width * (8 / 10)) - tailleCage / 2, Math.trunc(canvas.height * (1 / 10)), tailleCage, Math.trunc(tailleCage / 15), "grey"));
//
// // objet qui représente la balle
// let ball = {
//     x: Math.trunc(canvas.width / 2), // position x de la balle
//     y: Math.trunc(canvas.height * (5 / 10)), // position y de la balle
//     r: Math.trunc(cageMid.fond.width / 8), // rayon de la balle
//     v: 10 // vitesse de la balle en pixel
// };
// let newX = ball.x; // nouvelle position x de la balle après interaction (drag & drop)
// let newY = ball.y; // nouvelle position y de la balle après interaction (drag & drop)
//
// /**
//  * Permets de détecter le redimensionnement de la page
//  * et d'adapter la taille du canvas
//  * ainsi que de reset la position du ballon au millieu
//  */
// function resizeCanvas() {
//     // Calculer la nouvelle largeur en fonction de la largeur de la fenêtre
//     canvas.width = (widthPercentage / 100) * window.innerWidth;
//     // Calculer la nouvelle hauteur en fonction de la hauteur de la fenêtre
//     canvas.height = (heightPercentage / 100) * window.innerHeight;
//     staticCanvas.width = canvas.width;
//     staticCanvas.height = canvas.height;
//     tailleCage = Math.trunc(canvas.width * (2.5 / 10));
//     cageLeft = new Cage(new Rectangle(Math.trunc(canvas.width * (2 / 10)) - tailleCage / 2, Math.trunc(canvas.height * (1 / 10)), tailleCage, Math.trunc(tailleCage / 15), "grey"));
//     cageMid = new Cage(new Rectangle(Math.trunc(canvas.width / 2) - tailleCage / 2, Math.trunc(canvas.height * (1 / 10)), tailleCage, Math.trunc(tailleCage / 15), "grey"));
//     cageRight = new Cage(new Rectangle(Math.trunc(canvas.width * (8 / 10)) - tailleCage / 2, Math.trunc(canvas.height * (1 / 10)), tailleCage, Math.trunc(tailleCage / 15), "grey"));
//
//     ball.r = Math.trunc(cageMid.fond.width / 8);
//
//     //reset du jeu sans changer de question
//     resetGame(false);
// }
//
// // Gestion du redimensionnement de la fenêtre
// window.addEventListener("resize", resizeCanvas);
//
// function getMouseOrTouchPos(canvas, event) {
//     let rect = canvas.getBoundingClientRect();
//     if (event.touches && event.touches.length > 0) {
//         return {
//             x: event.touches[0].clientX - rect.left,
//             y: event.touches[0].clientY - rect.top
//         };
//     } else {
//         return {
//             x: event.clientX - rect.left,
//             y: event.clientY - rect.top
//         };
//     }
// }
//
// /**
//  * Permets de détecter les mouvements de la souris
//  * et de faire que le ballon suit la souris si la souris est clicker
//  * @param {*} e
//  * @deprecated remplacer la balle qui suit la souris par une flèche qui indique la direction de la balle
//  */
// // Fonction pour gérer le mouvement de la souris
// window.addEventListener("mousemove", (e) => {
//     if (mouseIsDown) {
//         let pos = getMouseOrTouchPos(canvas, e);
//         newX = (ball.x + (ball.x - pos.x));
//         newY = (ball.y - (pos.y - ball.y));
//     }
// });
//
// // Fonction pour gérer le mouvement tactile
// window.addEventListener("touchmove", (e) => {
//     if (mouseIsDown) {
//         let pos = getMouseOrTouchPos(canvas, e);
//         newX = (ball.x + (ball.x - pos.x));
//         newY = (ball.y - (pos.y - ball.y));
//     }
// });
//
// /**
//  * Permets de détecter le click de la souris
//  * l'action n'est pris en compte que si la souris est sur le ballon
//  */
// // Fonction pour gérer le clic de la souris
// window.addEventListener("mousedown", (e) => {
//     if (gameActive) {
//         let pos = getMouseOrTouchPos(canvas, e);
//         if (pos.x < ball.x + 80 && pos.x > ball.x - 80 &&
//             pos.y < ball.y + 80 && pos.y > ball.y - 80) {
//             mouseIsDown = true;
//         }
//     }
// });
//
// // Fonction pour gérer le début du toucher
// window.addEventListener("touchstart", (e) => {
//     if (gameActive) {
//         let pos = getMouseOrTouchPos(canvas, e);
//         if (pos.x < ball.x + 80 && pos.x > ball.x - 80 &&
//             pos.y < ball.y + 80 && pos.y > ball.y - 80) {
//             mouseIsDown = true;
//         }
//     }
// });
//
//
// /**
//  * Permets de détecter le relâchement de la souris
//  * si la souris est clicker alors, on calcule la nouvelle position de la balle
//  */
// // Fonction pour gérer le relâchement de la souris
// window.addEventListener("mouseup", (e) => {
//     if (mouseIsDown) {
//         let pos = getMouseOrTouchPos(canvas, e);
//         newX = ball.x + ((ball.x - pos.x) * 5);
//         newY = ball.y - ((pos.y - ball.y) * 5);
//     }
//     mouseIsDown = false;
// });
//
// // Fonction pour gérer la fin du toucher
// window.addEventListener("touchend", (e) => {
//     if (mouseIsDown) {
//         let pos = getMouseOrTouchPos(canvas, e.changedTouches[0]);
//         newX = ball.x + ((ball.x - pos.x) * 5);
//         newY = ball.y - ((pos.y - ball.y) * 5);
//     }
//     mouseIsDown = false;
// });
//
// /**
//  * Permets de dessiner un cercle sur le canvas
//  * @param {*} circle prend en paramètre un objet de type : {x:Number, y:Number, r:Number}
//  * @param {*} color prend un string de la couleur
//  */
// function drawBall(circle, color) {
//     ctx.beginPath();
//     ctx.arc(circle.x, circle.y, circle.r, 0, Math.PI * 2);
//     ctx.fillStyle = color;
//     ctx.fill();
//     ctx.closePath();
// }
//
// /**
//  * Permet de dessiner un rectangle sur le canvas
//  * @param {object} rect prend en paramètre un objet de type : {x:Number, y:Number, width:Number, height:Number}
//  * @param {string} color prend un string de la couleur
//  */
// function drawRectangle(rect, color, context) {
//     context.beginPath();
//     context.rect(rect.x, rect.y, rect.width, rect.height);
//     context.fillStyle = color;
//     context.fill();
//     context.closePath();
// }
//
// /**
//  * Permet de dessiner la cage sur le canvas
//  */
// function drawCage(cage, context) {
//     // poteau gauche
//     drawRectangle(cage.poteauGauche, cage.poteauGauche.color, context);
//     //poteau droit
//     drawRectangle(cage.poteauDroite, cage.poteauDroite.color, context);
//     // fonde la cage
//     drawRectangle(cage.fond, cage.fond.color, context);
// }
//
// /**
//  * Permet de calculer la norme d'un vecteur
//  * @param xA
//  * @param yA
//  * @param xB
//  * @param yB
//  * @returns {number}
//  */
// function Norm(xA, yA, xB, yB) {
//     return Math.sqrt(Math.pow(xB - xA, 2) + Math.pow(yB - yA, 2));
// }
//
// /**
//  * Permet de dessiner une flèche sur le canvas
//  * @param xA
//  * @param yA
//  * @param xB
//  * @param yB
//  * @param ArrowLength
//  * @param ArrowWidth
//  */
// function drawArrow(xA, yA, xB, yB, ArrowLength, ArrowWidth) {
//     if (ArrowLength === undefined) {
//         ArrowLength = 10;
//     }
//     if (ArrowWidth === undefined) {
//         ArrowWidth = 8;
//     }
//     ctx.lineCap = "round";
//     // Calculs des coordonnées des points C, D et E
//     AB = Norm(xA, yA, xB, yB);
//     xC = xB + ArrowLength * (xA - xB) / AB;
//     yC = yB + ArrowLength * (yA - yB) / AB;
//     xD = xC + ArrowWidth * (-(yB - yA)) / AB;
//     yD = yC + ArrowWidth * ((xB - xA)) / AB;
//     xE = xC - ArrowWidth * (-(yB - yA)) / AB;
//     yE = yC - ArrowWidth * ((xB - xA)) / AB;
//     // et on trace le segment [AB], et sa flèche :
//     ctx.beginPath();
//     ctx.moveTo(xA, yA);
//     ctx.lineTo(xB, yB);
//     ctx.moveTo(xD, yD);
//     ctx.lineTo(xB, yB);
//     ctx.lineTo(xE, yE);
//     ctx.stroke();
// }
//
// /**
//  * Permet de dessiner le texte de la réponse sur le canvas
//  * @param {string} txt : texte à afficher
//  * @param {number} x : position x du texte
//  * @param {number} y : position y du texte
//  * @param {string} color : couleur du texte
//  */
// function drawText(txt, x, y, color, context) {
//     context.font = tailleCage / 5 + "px Arial";
//     context.fillStyle = color;
//     context.textAlign = "center";
//     context.fillText(txt, x, y);
// }
//
// /**
//  * Permet de détecter si un cercle et un rectangle donné en paramètre sont en collision
//  * @param {*} circle
//  * @param {*} rect
//  */
// function RectCircleColliding(circle, rect) {
//     let distX = Math.abs(circle.x - rect.x - rect.width / 2);
//     let distY = Math.abs(circle.y - rect.y - rect.height / 2);
//
//     if (distX > (rect.width / 2 + circle.r)) {
//         return false;
//     }
//     if (distY > (rect.height / 2 + circle.r)) {
//         return false;
//     }
//
//     if (distX <= (rect.width / 2)) {
//         return true;
//     }
//     if (distY <= (rect.height / 2)) {
//         return true;
//     }
//
//     let dx = distX - rect.width / 2;
//     let dy = distY - rect.height / 2;
//     return (dx * dx + dy * dy <= (circle.r * circle.r));
// }
//
// /**
//  * Permet de gérer les collisions du jeu
//  */
// function collisionManager() {
//     bounceManager(cageLeft);
//     bounceManager(cageMid);
//     bounceManager(cageRight);
//     if (RectCircleColliding(ball, cageLeft.interieurCage)) { // collision avec l'intérieur de la cage
//         if (randCage === 0) {
//             resetGame();
//             addScore();
//         }
//     } else if (RectCircleColliding(ball, cageMid.interieurCage)) { // collision avec l'intérieur de la cage
//         if (randCage === 1) {
//             resetGame();
//             addScore();
//         }
//     } else if (RectCircleColliding(ball, cageRight.interieurCage)) { // collision avec l'intérieur de la cage
//         if (randCage === 2) {
//             resetGame();
//             addScore();
//         }
//     }
// }
//
// /**
//  * Permet de gérer les rebonds de la balle
//  * vérifie si la balle est en collision avec un des éléments de la cage
//  * si oui alors, on inverse la direction de la balle
//  * en calculant la nouvelle position de la balle
//  */
// function bounceManager(cage) {
//     if (RectCircleColliding(ball, cage.fond)) { // collision avec le fond de la cage
//         newX = ball.x + (newX - ball.x);
//         newY = ball.y - (newY - ball.y);
//     }
//     if (RectCircleColliding(ball, cage.poteauGauche) || RectCircleColliding(ball, cage.poteauDroite)) { // collision avec un des poteaux de la cage
//         if (ball.y > cage.poteauGauche.y + cage.poteauGauche.height) {
//             newX = ball.x + (newX - ball.x);
//             newY = ball.y - (newY - ball.y);
//         } else {
//             newX = ball.x - (newX - ball.x);
//             newY = ball.y + (newY - ball.y);
//         }
//     }
//     if (Math.abs(ball.x - 0) < ball.r || Math.abs(ball.x - canvas.width) < ball.r) { // collision avec les bords gauche et droite du canvas
//         newX = ball.x - (newX - ball.x);
//         newY = ball.y + (newY - ball.y);
//     } else if (Math.abs(ball.y - 0) < ball.r || Math.abs(ball.y - canvas.height) < ball.r) { // collision avec les bords haut et bas du canvas
//         newX = ball.x + (newX - ball.x);
//         newY = ball.y - (newY - ball.y);
//     }
// }
//
// // a: actuel {x, y}; n: arrivé {x, y}; v vitesse pixel
// /**
//  * Permet de faire bouger un objet vers une position donnée
//  * @param {*} ac : actuel {x, y} représente la position actuelle de l'objet
//  * @param {*} ne : arrivé {x, y} représente la position où l'objet doit aller
//  * @param {*} v : vitesse en pixel
//  */
// function moveObject(ac, ne, v) {
//     let s = {x: 1, y: 1}        // sens
//         , move = {x: 1, y: 1} // pixel de déplacement
//         , delta// delta -> pythagore
//         , dist = {}     // distance entre start et end
//     ;
//
//     // distance x/y
//     dist.x = Math.abs(ac.x - ne.x);
//     dist.y = Math.abs(ac.y - ne.y);
//
//     // racine carrée de A² + B² (pythagore) → donne l'hypoténuse
//     delta = Math.sqrt((dist.x * dist.x) + (dist.y * dist.y));
//
//     // ralentissement en fonction de la distance restante
//     let tempV = v
//     v *= delta / 1000;
//
//     // règle des tiers afin d'avoir le déplacement par rapport à V et Delta
//     move.x = (dist.x * v) / delta;
//     move.y = (dist.y * v) / delta;
//
//     v = tempV;
//
//     // déplacement vers la gauche -1, droite 1, haut -1, bas 1
//     s.x = (ac.x > ne.x) ? -1 : 1;
//     s.y = (ac.y > ne.y) ? -1 : 1;
//
//     // rajoute à nos coordonnées actuelles le déplacement dans le bon sens
//     ac.x += move.x * s.x;
//     ac.y += move.y * s.y;
//
//     // retourne si l'objet est arrivé à son objectif -Vpx=marge d'erreur-
//     return (dist.x <= v && dist.y <= v);
// }
//
// function drawImage(x, y, w, h) {
//     let image = new Image();
//     image.src = "/assets/images/hockeyCage.png";
//     image.onload = function () {
//         // Vérifie que l'image est dans la zone de dessin du canvas
//         if (image.width > canvas.width || image.height > canvas.height) {
//             // Déplace l'image à l'intérieur de la zone de dessin
//             image.x = (canvas.width - image.width) / 2;
//             image.y = (canvas.height - image.height) / 2;
//         }
//
//         // Dessine l'image
//         staticContext.drawImage(image, x, y, w, h);
//     };
// }
//
// function resetStaticCanvas(changeQuestion = true) {
//     staticContext.clearRect(0, 0, canvas.width, canvas.height);
//
//     drawImage(cageLeft.fond.x, cageLeft.fond.y, cageLeft.fond.width, cageLeft.poteauGauche.height);
//     drawImage(cageMid.fond.x, cageMid.fond.y, cageMid.fond.width, cageMid.poteauGauche.height);
//     drawImage(cageRight.fond.x, cageRight.fond.y, cageRight.fond.width, cageRight.poteauGauche.height);
//
//
//     if (changeQuestion) {
//         randCage = Math.floor(Math.random() * 3);
//         getQuestion();
//     }
// }
//
// function resetGame(changeQuestion = true) {
//     isInActiveSession();
//     //reset ball
//     ball.x = Math.trunc(canvas.width / 2);
//     ball.y = Math.trunc(canvas.height * (5 / 10));
//     newX = ball.x;
//     newY = ball.y;
//     resetStaticCanvas(changeQuestion);
// }
//
// function endGame() {
//     $.ajax({
//         type: "POST",
//         url: "/controls/actionController.php",
//         data: {
//             action: "showEndGame",
//         },
//         dataType: 'json',
//         success: function (response) {
//             $("#pseudo").text(response.pseudo);
//             $("#scoreEnd").text(response.score.toString());
//             $("#rank").text(response.rank.toString());
//         }
//     });
// }
//
// // //fonction appelée par le websocket pour changer le statut de la session
// // function sessionStatus(status) {
// //     switch (status) {
// //         case 'start':
// //             gameActive = true;
// //             $("#endGame").hide();
// //             break;
// //         case 'stop':
// //             gameActive = false;
// //             $("#endGame").show();
// //             endGame();
// //             break;
// //         case 'reset':
// //             gameActive = false;
// //             window.location.href = "/home";
// //             break;
// //         default :
// //             alert("Erreur de statuts de session");
// //             break
// //     }
// // }
//
// /**
//  * Fonction qui permet de verifier
//  * si le joueur est toujours dans la session
//  */
// function isInActiveSession() {
//
//     $.ajax({
//         type: "POST",
//         url: "/controls/actionController.php",
//         data: {
//             action: "isInActiveSession",
//         },
//         success: function (response) {
//             if (response === 'notActive') {
//                 gameActive = false;
//                 $("#endGame").show();
//                 endGame();
//             } else if (response === 'false') {
//                 gameActive = false;
//                 window.location.href = "/home";
//             } else if (response === 'true') {
//                 gameActive = true;
//                 $("#endGame").hide();
//             }
//         }
//     });
// }
//
// /**
//  * Fonction qui permet de récupérer une question aléatoire
//  * et de la dessiner sur le canvas hors écran
//  */
// function getQuestion() {
//     $.ajax({
//         type: "POST",
//         url: "/controls/actionController.php",
//         data: {
//             action: "getRandomQuestion",
//         },
//         dataType: 'json',
//         success: function (response) {
//             let repA = (randCage === 0) ? response.vrai : response.faux1;
//             let repB = (randCage === 1) ? response.vrai : (randCage === 2) ? response.faux2 : response.faux1;
//             let repC = (randCage === 2) ? response.vrai : response.faux2;
//             $("#question").text(response.text);
//             $("#rep1").text(repA);
//             $("#rep2").text(repB);
//             $("#rep3").text(repC);
//         }
//     });
// }
//
// function addScore(number = 100) {
//     if (gameActive) {
//         $.ajax({
//             type: "POST",
//             url: "/controls/actionController.php",
//             data: {
//                 action: "addScore",
//                 score: number,
//             },
//             dataType: 'json',
//             success: function (response) {
//                 score = response.toString();
//                 $("#score").text(score);
//             }
//         });
//     }
// }
//
// /**
//  * Fonction principale qui permet de dessiner le canvas
//  * et de faire fonctionner le jeu
//  */
// function draw() {
//     ctx.clearRect(0, 0, canvas.width, canvas.height);
//     ctx.drawImage(staticCanvas, 0, 0);
//     drawBall(ball, "#0095DD");
//     if (mouseIsDown) {
//         ctx.strokeStyle = "black";
//         ctx.lineWidth = 4;
//         drawArrow(ball.x, ball.y, newX, newY);
//     } else {
//         if ((newX !== ball.x || newY !== ball.y) && !mouseIsDown) {
//             if (moveObject(ball, {x: newX, y: newY}, ball.v)) {
//                 resetGame(false);
//                 newX = ball.x;
//                 newY = ball.y
//             }
//         }
//     }
//     collisionManager();
// }
//
// function showScore() {
//     $.ajax({
//         type: "POST",
//         url: "/controls/actionController.php",
//         data: {
//             action: "showScore",
//         },
//         dataType: 'json',
//         success: function (response) {
//             $("#score").text(response.toString());
//         }
//     });
// }
//
// /**
//  * resetStaticCanvas() initialise le canvas hors écran et
//  * setInterval va appeler la fonction draw() toutes les 10ms
//  */
// isInActiveSession();
// resetGame();
// showScore();
// setInterval(draw, 10);
