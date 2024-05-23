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

// TODO placer ce code où il doit aller
//elseif (empty($_SESSION['admin'])) {
//    header('refresh:0;url=/connect');
//}

switch ($url) {
    case '' :
    case '/':
    case 'home':
        $path = 'view/home.php';
        $title = 'Home';
        break;
    case 'play' :
    case 'rules' :
        $path = 'view/' . $url . '.php';

        if ($url != "play" || (!empty($_SESSION['code']) && $codesController->checkSessionCode($_SESSION['code']) && !empty($_SESSION['pseudo']) && !empty($_SESSION['spartiateId']) && !empty($_SESSION['gameMode']))) {
            $title = $pages[$url];
        } elseif ($url == 'play' && (!isset($_SESSION['code']) || !$codesController->checkSessionCode($_SESSION['code']))) {
            $_SESSION['pseudo'] = null;
            $_SESSION['spartiateId'] = null;
            $_SESSION['gameMode'] = null;
            header('refresh:0;url=/sessionCode');
        } elseif ($url == 'play' && empty($_SESSION['pseudo'])) {
            $_SESSION['spartiateId'] = null;
            $_SESSION['gameMode'] = null;
            header('refresh:0;url=/pseudo');
        } elseif ($url == 'play' && empty($_SESSION['spartiateId'])) {
            $_SESSION['gameMode'] = null;
            $spartiatesController->showChooseSpartiate();
        } elseif ($url == 'play' && empty($_SESSION['gameMode'])) {
            $title = 'Choissisez un spartiates';
            $path = 'view/chooseGameMode.php';
        }
        break;
    case 'sessionCode' :
    case 'pseudo' :
    case 'connect' :
        $path = 'view/forms/' . $url . '.php';
        if ($url != "pseudo" || (!empty($_SESSION['code']) && $codesController->checkSessionCode($_SESSION['code']))) {
            $_SESSION['spartiateId'] = null;
            $title = $forms[$url];
        } elseif ($url == 'pseudo')
            header('refresh:0;url=/sessionCode');
        break;
    case 'newQuestion' :
    case 'newSpartiate' :
        $path = 'view/forms/' . $url . '.php';
        $title = $adminForms[$url];
        break;
    case 'questions' :
    case 'spartiates' :
        $method = "show" . ucfirst($url);
        if (method_exists($adminPages[$url][1], $method)) {
            $adminPages[$url][1]->$method();
        } else {
            header('refresh:0;url=/404');
        }
        break;
    case 'users' :
        $path = 'view/adminPages/users.php';
        $title = 'Admin';
        break;
    case 'updateQuestion' : // TODO gérer lorsque $_GET['id'] n'existe pas
        $questionsController->showUpdateForm($url, htmlspecialchars($_GET['id']));
        break;
    case 'updateSpartiate' : // TODO gérer lorsque $_GET['id'] n'existe pas
        $spartiatesController->showUpdateForm($url, htmlspecialchars($_GET['id']));
        break;
    default :
        $title = 'Erreur';
        $path = 'view/error.php';
        break;
}

///////////////////////////////////////////////////////////////////////////////
/// Display
///////////////////////////////////////////////////////////////////////////////

View::display($title, $path);