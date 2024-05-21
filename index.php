<?php

use View\View;

require 'vendor/autoload.php';

// chemin de l'URL demandée au navigateur
$url = $_GET['url'] ?? '';
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

$questionsController = new \Controls\QuestionsController();
$spartiatesController = new \Controls\SpartiatesController();
$usersController = new \Controls\UsersController();
$codesController = new \Controls\CodesController();
$sessionController = new \Controls\SessionController();

// Gestion des actions
require 'controls/actionController.php';

//listes des mots dans l'url permettant d'accéder à une page
$pages = [
    'play' => 'Jeu de hockey',
    'rules' => 'Regles',
];
$forms = [
    'sessionCode' => 'entrer le code',
    'pseudo' => 'entrer le pseudo',
    'admin' => 'Connexion',
];
$adminForms = [
    'newQuestion' => 'Nouvelle Question',
    'newSpartiate' => 'Nouveau Spartiate',
];
$adminPages = [
    'questions' => ['Questions', $questionsController],
    'spartiates' => ['Spartiates', $spartiatesController],
];

if ('' == $url || '/' == $url || 'home' == $url) {

    $path = 'view/home.php';
    View::display('Home', $path);

} elseif (isset($pages[$url])) {

    $path = 'view/' . $url . '.php';
    if ($url != "play" || (!empty($_SESSION['code']) && $codesController->checkSessionCode($_SESSION['code']) && !empty($_SESSION['pseudo']) && !empty($_SESSION['spartiateId']))) {
        View::display($pages[$url], $path);
    } elseif ($url == 'play' && (!isset($_SESSION['code']) || !$codesController->checkSessionCode($_SESSION['code']))) {
        $_SESSION['pseudo'] = null;
        $_SESSION['spartiateId'] = null;
        header('refresh:0;url=/sessionCode');
    } elseif ($url == 'play' && empty($_SESSION['pseudo'])) {
        $_SESSION['spartiateId'] = null;
        header('refresh:0;url=/pseudo');
    } elseif ($url == 'play' && empty($_SESSION['spartiateId'])) {
        $spartiatesController->showChooseSpartiate();
    }

} elseif (isset($forms[$url])) {
    $path = 'view/forms/' . $url . '.php';
    if ($url != "pseudo" || (!empty($_SESSION['code']) && $codesController->checkSessionCode($_SESSION['code']))) {
        $_SESSION['spartiateId'] = null;
        View::display($forms[$url], $path);
    } elseif ($url == 'pseudo')
        header('refresh:0;url=/sessionCode');

} elseif (empty($_SESSION['admin'])) {
    header('refresh:0;url=/admin');

} elseif (isset($adminForms[$url])) {
    $path = 'view/forms/' . $url . '.php';
    View::display($adminForms[$url], $path);

} elseif (isset($adminPages[$url])) {
    $method = "show" . ucfirst($url);
    if (method_exists($adminPages[$url][1], $method)) {
        $adminPages[$url][1]->$method();
    } else {
        header('refresh:0;url=/404');
    }
} elseif ('users' == $url) {
    $path = 'view/adminPages/users.php';
    View::display('Admin', $path);

} elseif ('updateQuestion' == $url || 'updateSpartiate' == $url && !empty($_GET['id'])) {
    if ('updateQuestion' == $url)
        $questionsController->showUpdateForm($url, htmlspecialchars($_GET['id']));
    else
        $spartiatesController->showUpdateForm($url, htmlspecialchars($_GET['id']));
} else {
    View::display('Erreur', 'view/error.php');
}