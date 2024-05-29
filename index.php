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

///////////////////////////////////////////////////////////////////////////////
/// Initialize controllers
///////////////////////////////////////////////////////////////////////////////

$questionsController = new QuestionsController();
$spartanController = new SpartanController();
$routeController = new RouteController();



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

    $routeController->addRoute("error", "error");

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


$routeController->displayRoutes($url);