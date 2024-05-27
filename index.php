<?php

///////////////////////////////////////////////////////////////////////////////
/// Load classes
///////////////////////////////////////////////////////////////////////////////

use controls\CodesController;
use controls\QuestionsController;
use controls\SessionController;
use controls\SpartanController;
use controls\UsersController;
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
$codesController = new CodesController();

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

switch ($url) {

    // HOME PAGE
    case '' :
    case '/':
    case 'home':
        $title = 'Home';
        break;

    // GAME
    case 'game' :
        // Ask for session code
        if (!isset($_SESSION['code']) || !$codesController->checkSessionCode($_SESSION['code'])) {
            $_SESSION['username'] = null;
            $_SESSION['spartanId'] = null;
            $refresh = 'sessionCode';
        // Ask for username
        } elseif (empty($_SESSION['username'])) {
            $_SESSION['spartanId'] = null;
            $refresh = 'login';
        // Ask for a spartan
        } elseif (empty($_SESSION['spartanId'])) {
            $spartanController->showChooseSpartan();
        // Start the game
        } else {
            $title = 'Jeu de hockey';
        }
        break;

    // RULES
    case 'rules' :
        $title = 'Regles';
        break;

    // FORMS
    case 'sessionCode' :
    case 'username' :
    case 'connect' :
        $title = $forms[$url];
        if ($url != "username" || (!empty($_SESSION['code']) && $codesController->checkSessionCode($_SESSION['code']))) {
            $_SESSION['spartanId'] = null;
        } elseif ($url == 'username')
            $refresh = 'sessionCode';
        break;

    // ADMIN PAGES
    case 'newQuestion' :
    case 'newSpartan' :
        if (empty($_SESSION['admin'])) {
            $refresh = 'connect';
        }
        $title = $adminForms[$url];
        break;
    case 'questions' :
    case 'spartans' :
        if (empty($_SESSION['admin'])) {
            $refresh = 'connect';
        }
        $method = "show" . ucfirst($url);
        if (method_exists($adminPages[$url][1], $method)) {
            $adminPages[$url][1]->$method();
        } else {
            $refresh = 'connect';
        }
        break;
    case 'users' :
        if (empty($_SESSION['admin'])) {
            $refresh = 'connect';
        }
        $title = 'Admin';
        break;
    case 'updateQuestion' :
        if (empty($_GET['id'])) {
            $title = 'Erreur';
            break;
        }
        if (empty($_SESSION['admin'])) {
            $refresh = 'connect';
        }
        $questionsController->showUpdateForm($url, htmlspecialchars($_GET['id']));
        break;
    case 'updateSpartan' :
        if (empty($_GET['id'])) {
            $title = 'Erreur';
            break;
        }
        if (empty($_SESSION['admin'])) {
            $refresh = 'connect';
        }
        $spartanController->showUpdateForm($url, htmlspecialchars($_GET['id']));
        break;

    // ERROR 404
    default :
        $title = 'Erreur';
        break;
}

///////////////////////////////////////////////////////////////////////////////
/// Display
///////////////////////////////////////////////////////////////////////////////

if (isset($refresh)) {
    header("refresh:0;url=/$refresh");
}

View::display($title ?? 'none', $path ?? null);

