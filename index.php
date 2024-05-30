<?php

///////////////////////////////////////////////////////////////////////////////
/// Load classes
///////////////////////////////////////////////////////////////////////////////

use controls\{QuestionsController, SpartanController, RouteController, ActionController};


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
$actionController = new ActionController();


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
/// Register Actions
///////////////////////////////////////////////////////////////////////////////


$actionController->registerAction("createSpartan", ['fields' => ['lastName', 'name']], "spartanController", '/spartans', true);
$actionController->registerAction("updateSpartan", ['idField' => 'id', 'fields' => ['lastName', 'name']], "spartanController", '/spartans', true);
$actionController->registerAction("deleteSpartan", ['idField' => 'id'], "spartanController", '/spartans', true);
$actionController->registerAction("setSessionSpart", ['fields' => ['spartanId']], "sessionController", null);
$actionController->registerAction("searchSpartan", ['fields' => ['searchTerm']], "spartanController", null, true);
$actionController->registerAction("changeStar", ['fields' => ['spartanId']], "spartanController", null, true);

$actionController->registerAction("createQuestion", ['fields' => ['text', 'true', 'false1', 'false2']], "questionsController", '/questions', true);
$actionController->registerAction("updateQuestion", ['idField' => 'id', 'fields' => ['text', 'true', 'false1', 'false2']], "questionsController", '/questions', true);
$actionController->registerAction("deleteQuestion", ['idField' => 'id'], "questionsController", '/questions', true);
$actionController->registerAction("getRandomQuestion", [], "questionsController", null);
$actionController->registerAction("searchQuestion", ['fields' => ['searchTerm']], "questionsController", null, true);

$actionController->registerAction("checkSessionCode", ['fields' => ['code']], "codesController", null,false,  ['error' => ['success' => false, 'error' => 'code incorrect']], ['sessionHasEnded' => ['success' => false, 'error' => 'La session est finis']], ['needResponse' => true]);
$actionController->registerAction("getSessionCode", [], "codesController", null, true);

$actionController->registerAction("start", [], "codesController", null, true);
$actionController->registerAction("stop", [], "codesController", null, true);
$actionController->registerAction("isInActiveSession", [], "sessionController", null);
$actionController->registerAction("addSessionPlayer", ['fields' => ['username', 'email']], "sessionController", '/game');

$actionController->registerAction("addScore", ['fields' => ['score']], "sessionController", null);

$actionController->registerAction("startWS", [], "wscontroller", null, true);
$actionController->registerAction("stopWS", [], "wscontroller", null, true);
$actionController->registerAction("connexionWS", [], "wscontroller", null);

$actionController->registerAction("logIn", ['fields' => ['login', 'password']], "usersController", '/users');
$actionController->registerAction("deleteUser", ['idField' => 'id'], "sessionController", '', true);

$actionController->registerAction("showRanking", [], "sessionController", null, true);
$actionController->registerAction("showEndGame", ['fields' => ['score']], "sessionController", null);



///////////////////////////////////////////////////////////////////////////////
/// Check Action
///////////////////////////////////////////////////////////////////////////////

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && !empty($_POST['action'])) {
    $actionController->handleAction();
    exit;
}

///////////////////////////////////////////////////////////////////////////////
/// Display
///////////////////////////////////////////////////////////////////////////////

$routeController->displayRoutes($url);