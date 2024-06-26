<?php

///////////////////////////////////////////////////////////////////////////////
/// Load classes
///////////////////////////////////////////////////////////////////////////////

use class\ActionRouter;
use class\controls\QuestionsController;
use class\controls\SpartanController;
use class\controls\UsersController;
use class\Router;

require_once "autoloader.php";

///////////////////////////////////////////////////////////////////////////////
/// Load GET and POST variables
///////////////////////////////////////////////////////////////////////////////

$url = $_GET['url'] ?? '';
///////////////////////////////////////////////////////////////////////////////
/// Load session
///////////////////////////////////////////////////////////////////////////////

// Configuration des paramètres de session
ini_set('session.gc_lifetime', 5);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

// Configuration des paramètres des cookies de session
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Initiation/Arrêt de session
if (!isset($_SESSION))
    session_start();
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
    session_unset();
    session_destroy();
    session_start();
} else {
    $_SESSION['last_activity'] = time();
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
$routeController = new Router();
$actionController = new ActionRouter();


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
    $routeController->addRoute("qrcode", "qrcode", true);

    $routeController->addRoute("download", "download", true);

    $routeController->addRoute("updateQuestion", "updateQuestion", true,$questionsController,"showUpdateForm");
    $routeController->addRoute("updateSpartan", "updateSpartan", true,$spartanController,"showUpdateForm");

} catch (Exception $e) {
    echo $e->getMessage();
}


///////////////////////////////////////////////////////////////////////////////
/// Register Actions
///////////////////////////////////////////////////////////////////////////////


$actionController->registerAction("createSpartan", ['fields' => ['lastName', 'name']], "SpartanController", '/spartans', true);
$actionController->registerAction("updateSpartan", ['idField' => 'id', 'fields' => ['lastName', 'name']], "SpartanController", '/spartans', true);
$actionController->registerAction("deleteSpartan", ['idField' => 'id'], "SpartanController", '/spartans', true);
$actionController->registerAction("setSessionSpart", ['fields' => ['spartanId']], "SessionController", null);
$actionController->registerAction("searchSpartan", ['fields' => ['searchTerm']], "SpartanController", null, true);

$actionController->registerAction("createQuestion", ['fields' => ['text', 'true', 'false1', 'false2']], "QuestionsController", '/questions', true);
$actionController->registerAction("updateQuestion", ['idField' => 'id', 'fields' => ['text', 'true', 'false1', 'false2']], "QuestionsController", '/questions', true);
$actionController->registerAction("deleteQuestion", ['idField' => 'id'], "QuestionsController", '/questions', true);
$actionController->registerAction("getQuestion", ['fields' => ['index']], "QuestionsController", null);
$actionController->registerAction("getQuestionsNumber", [], "QuestionsController", null);
$actionController->registerAction("getAnswer", ['fields' => ['index']], "QuestionsController", null);
$actionController->registerAction("searchQuestion", ['fields' => ['searchTerm']], "QuestionsController", null, true);

$actionController->registerAction("checkSessionCode", ['fields' => ['code']], "CodesController", null, false,
    ['success' => ['success' => true, 'url' => '/username']],
    ['error' => ['success' => false, 'error' => 'Code expiré ou incorrect']],
    ['sessionHasEnded' => ['success' => false, 'error' => 'La session est finis']],
    ['needResponse' => true]);
$actionController->registerAction("getSessionCode", [], "CodesController", null, true);

$actionController->registerAction("start", [], "CodesController", null, true);
$actionController->registerAction("stop", [], "CodesController", null, true);
$actionController->registerAction("isInActiveSession", [], "SessionController", null);
$actionController->registerAction("addSessionPlayer", ['fields' => ['name', 'email', 'phone']], "SessionController", '/game');

$actionController->registerAction("addScore", ['fields' => ['score']], "SessionController", null);

$actionController->registerAction("dlData", [], "DownloadController", "/download", true);

$actionController->registerAction("startWS", [], "WSController", null, true);
$actionController->registerAction("stopWS", [], "WSController", null, true);
$actionController->registerAction("saveScore", ['fields' => ['score']], "WSController", null, true);
$actionController->registerAction("connexionWS", [], "WSController", null);

$actionController->registerAction("logIn", ['fields' => ['login', 'password']], "UsersController", null,false, ['success' => ['success' => true, 'url' => '/users']], ['error' => ['success' => false, 'error' => 'Identifiant ou mot de passe incorrect']], ['needResponse' => true]);
$actionController->registerAction("disconnect", [], "UsersController", null,false, ['success' => ['success' => true, 'url' => '/']], ['needResponse' => true]);
$actionController->registerAction("deleteUser", ['idField' => 'id'], "SessionController", '', true);
$actionController->registerAction("sendResetEmail", [], "UsersController", '', false);

$actionController->registerAction("showRanking", [], "SessionController", null, true);
$actionController->registerAction("showEndGame", ['fields' => ['score']], "SessionController", null);

///////////////////////////////////////////////////////////////////////////////
/// Check Action or Display
///////////////////////////////////////////////////////////////////////////////

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && !empty($_POST['action'])) {
    $actionController->handleAction();
}else{
    $routeController->displayRoutes($url);
}