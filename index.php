<?php

///////////////////////////////////////////////////////////////////////////////
/// Load classes
///////////////////////////////////////////////////////////////////////////////

use controls\CodesController;
use controls\QuestionsController;
use controls\SessionController;
use controls\SpartanController;
use controls\UsersController;
use controls\RouteController;
use view\View;

require_once "autoloader.php";

///////////////////////////////////////////////////////////////////////////////
/// Load GET and POST variables
///////////////////////////////////////////////////////////////////////////////

$url = $_GET['url'] ?? '';

///////////////////////////////////////////////////////////////////////////////
/// Load session
///////////////////////////////////////////////////////////////////////////////

ini_set('session.gc_lifetime', 5);
if (!isset($_SESSION))
    session_start();
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
    session_unset();
    session_destroy();
    session_start();
} else {
    $_SESSION['last_activity'] = time();
}

if(isset($_GET['reset']) && $_GET['reset'] === "oui"){
    session_destroy();
    session_unset();
}

$usersController = new UsersController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reset') {
    $usersController->handleResetPasswordForm();
}

///////////////////////////////////////////////////////////////////////////////
/// Initialize controllers
///////////////////////////////////////////////////////////////////////////////

$questionsController = new QuestionsController();
$spartanController = new SpartanController();
$routeController = new RouteController();

///////////////////////////////////////////////////////////////////////////////
/// Pages mapping
///////////////////////////////////////////////////////////////////////////////

$pages = [
    'game' => 'Jeu de hockey',
    'rules' => 'Règles',
];
$forms = [
    'sessionCode' => 'entrer le code',
    'username' => 'entrer un nom d\'utilisateur',
    'connect' => 'Connexion',
    'reset' => 'Réinitialiser le mot de passe',
];
$adminForms = [
    'newQuestion' => 'Nouvelle Question',
    'newSpartan' => 'Nouveau Spartiate',
];
$adminPages = [
    'questions' => ['Questions', $questionsController],
    'spartans' => ['Spartans', $spartanController],
];

///////////////////////////////////////////////////////////////////////////////
/// Router
///////////////////////////////////////////////////////////////////////////////


try {
    $routeController->addRoute(["", "/", "home"], "home");
    $routeController->addRoute("rules", "rules");

    $routeController->addRoute("game", "game", false , null, "game");

    $routeController->addRoute("sessionCode","sessionCode",false, null, "forms");
    $routeController->addRoute("username","username",false, null, "forms");
    $routeController->addRoute("connect","connect",false, null, "forms");
    $routeController->addRoute("reset","resetPwd", false, null, "resetPassword");

    $routeController->addRoute("error", "error");
    $routeController->addRoute("success", "success");

    // Admin Pages
    $routeController->addRoute("newQuestion","newQuestion", true);
    $routeController->addRoute("newSpartan","newSpartan", true);

    $routeController->addRoute("questions","questions", true, $questionsController, $method = "showQuestions");
    $routeController->addRoute("spartans","spartans", true, $spartanController, $method = "showSpartans");

    $routeController->addRoute("users", "users", true);

    $routeController->addRoute("updateQuestion", "updateQuestion", true,$questionsController,"showUpdateForm");
    $routeController->addRoute("updateSpartan", "updateSpartan", true,$spartanController,"showUpdateForm");

} catch (Exception $e) {
    echo $e->getMessage();
}


///////////////////////////////////////////////////////////////////////////////
/// Display
///////////////////////////////////////////////////////////////////////////////
///

$routeController->displayRoutes($url);