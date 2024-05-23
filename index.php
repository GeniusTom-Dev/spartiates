<?php

///////////////////////////////////////////////////////////////////////////////
/// Load classes
///////////////////////////////////////////////////////////////////////////////

use controls\CodesController;
use controls\QuestionsController;
use controls\SessionController;
use controls\SpartiatesController;
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

///////////////////////////////////////////////////////////////////////////////
/// Initialize controlers
///////////////////////////////////////////////////////////////////////////////

$questionsController = new QuestionsController();
$spartiatesController = new SpartiatesController();
$usersController = new UsersController();
$codesController = new CodesController();
$sessionController = new SessionController();

///////////////////////////////////////////////////////////////////////////////
/// Pages mapping
///////////////////////////////////////////////////////////////////////////////

$pages = [
    'play' => 'Jeu de hockey',
    'rules' => 'Regles',
];
$forms = [
    'sessionCode' => 'entrer le code',
    'pseudo' => 'entrer le pseudo',
    'connect' => 'Connexion',
];
$adminForms = [
    'newQuestion' => 'Nouvelle Question',
    'newSpartiate' => 'Nouveau Spartiate',
];
$adminPages = [
    'questions' => ['Questions', $questionsController],
    'spartiates' => ['Spartiates', $spartiatesController],
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
    case 'play' :
        $path = 'view/' . $url . '.php';
        $title = 'Jeu de hockey';
        if (!isset($_SESSION['code']) || !$codesController->checkSessionCode($_SESSION['code'])) {
            $_SESSION['pseudo'] = null;
            $_SESSION['spartiateId'] = null;
            $_SESSION['gameMode'] = null;
            $refresh = 'sessionCode';
        } elseif (empty($_SESSION['pseudo'])) {
            $_SESSION['spartiateId'] = null;
            $_SESSION['gameMode'] = null;
            $refresh = 'pseudo';
        } elseif (empty($_SESSION['spartiateId'])) {
            $_SESSION['gameMode'] = null;
            $spartiatesController->showChooseSpartiate();
        } elseif (empty($_SESSION['gameMode'])) {
            $title = 'Choissisez un spartiates';
            $path = 'view/chooseGameMode.php';
        }
        break;
    // RULES
    case 'rules' :
        $path = 'view/' . $url . '.php';
        $title = 'Regles';

        if (!empty($_SESSION['code'])
            && $codesController->checkSessionCode($_SESSION['code'])
            && !empty($_SESSION['pseudo'])
            && !empty($_SESSION['spartiateId'])
            && !empty($_SESSION['gameMode'])) {
            $title = $pages[$url];
        }
        break;
    // FORMS
    case 'sessionCode' :
    case 'pseudo' :
    case 'connect' :
        $path = 'view/forms/' . $url . '.php';
        $title = $forms[$url];
        if ($url != "pseudo" || (!empty($_SESSION['code']) && $codesController->checkSessionCode($_SESSION['code']))) {
            $_SESSION['spartiateId'] = null;
        } elseif ($url == 'pseudo')
            $refresh = 'sessionCode';
        break;
    // ADMIN PAGES
    case 'newQuestion' :
    case 'newSpartiate' :
        if (empty($_SESSION['admin'])) {
            $refresh = 'connect';
        }
        $path = 'view/forms/' . $url . '.php';
        $title = $adminForms[$url];
        break;
    case 'questions' :
    case 'spartiates' :
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
    case 'updateSpartiate' :
        if (empty($_GET['id'])) {
            $title = 'Erreur';
            break;
        }
        if (empty($_SESSION['admin'])) {
            $refresh = 'connect';
        }
        $spartiatesController->showUpdateForm($url, htmlspecialchars($_GET['id']));
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

