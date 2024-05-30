<?php

namespace controls;
if (isset($_POST['action'])) {
    include_once "../autoloader.php";
}


// Utiliser un tableau pour stocker les instances des contrôleurs
$questionsController = new QuestionsController();
$spartanController = new SpartanController();
$usersController = new UsersController();
$codesController = new CodesController();
$sessionController = new SessionController();
$wscontroller = new WSController();

if (!isset($_SESSION)) {
    session_start();
}
$actionsMapping = [

    // Spartan
    'createSpartan' => ['fields' => ['lastName', 'name'], 'controller' => $spartanController, 'redirect' => '/spartans', 'adminOnly' => true],
    'updateSpartan' => ['idField' => 'id', 'fields' => ['lastName', 'name'], 'controller' => $spartanController, 'redirect' => '/spartans', 'adminOnly' => true],
    'deleteSpartan' => ['idField' => 'id', 'controller' => $spartanController, 'redirect' => '/spartans', 'adminOnly' => true],
    'setSessionSpart' => ['fields' => ['spartanId'], 'controller' => $sessionController, 'adminOnly' => false],
    'searchSpartan' => ['fields' => ['searchTerm'], 'controller' => $spartanController, 'adminOnly' => true],
    'changeStar' => ['fields' => ['spartanId'], 'controller' => $spartanController, 'adminOnly' => true],

    // Question
    'createQuestion' => ['fields' => ['text', 'true', 'false1', 'false2'], 'controller' => $questionsController, 'redirect' => '/questions', 'adminOnly' => true],
    'updateQuestion' => ['idField' => 'id', 'fields' => ['text', 'true', 'false1', 'false2'], 'controller' => $questionsController, 'redirect' => '/questions', 'adminOnly' => true],
    'deleteQuestion' => ['idField' => 'id', 'controller' => $questionsController, 'redirect' => '/questions', 'adminOnly' => true],
    'getQuestion' => ['fields' => ['index'], 'controller' => $questionsController, 'adminOnly' => false],
    'getAnswer' => ['fields' => ['index'], 'controller' => $questionsController, 'adminOnly' => false],
    'searchQuestion' => ['fields' => ['searchTerm'], 'controller' => $questionsController, 'adminOnly' => true],

    // Session Code
    'checkSessionCode' => ['fields' => ['code'], 'controller' => $codesController, 'success' => ['success' => true, 'url' => '/username'], 'error' => ['success' => false, 'error' => 'code incorrect'], 'sessionHasEnded' => ['success' => false, 'error' => 'La session est finis'], 'adminOnly' => false, 'needResponse' => true],
    'getSessionCode' => ['controller' => $codesController, 'adminOnly' => true],

    // Manage Session
    'start' => ['controller' => $codesController, 'adminOnly' => true],
    'stop' => ['controller' => $codesController, 'adminOnly' => true],
    'isInActiveSession' => ['controller' => $sessionController, 'adminOnly' => false],
    'addSessionPlayer' => ['fields' => ['username', 'email'], 'controller' => $sessionController, 'redirect' => '/game', 'adminOnly' => false],

    // Score
    'addScore' => ['fields' => ['score'], 'controller' => $sessionController, 'adminOnly' => false],

    // Web Socket
    'startWS' => ['webSocketMessage' => 'start', 'adminOnly' => true],
    'stopWS' => ['webSocketMessage' => 'stop', 'adminOnly' => true],
    'connexionWS' => ['controller' => $wscontroller, 'adminOnly' => false],

    // User
    'logIn' => ['fields' => ['login', 'password'], 'controller' => $usersController, 'success' => ['success' => true, 'url' => '/users'], 'error' => ['success' => false, 'error' => 'Identifiant ou mot de passe incorrect'], 'adminOnly' => false, 'needResponse' => true],
    'deleteUser' => ['idField' => 'id', 'controller' => $sessionController, 'redirect' => '', 'adminOnly' => true],

    // Other
    'showRanking' => ['controller' => $sessionController, 'adminOnly' => true],
    'showEndGame' => ['fields' => ['score'], 'controller' => $sessionController, 'adminOnly' => false],
];

// Fonction pour traiter les actions
function handleAction($actionsMapping): void
{
    $postData = $_POST;
    $files = $_FILES;
    $action = $_POST['action'];
    if (isset($actionsMapping[$action])) {
        $mapping = $actionsMapping[$action];

        // Vérifier si l'action nécessite des privilèges administratifs
        if ($mapping['adminOnly'] && empty($_SESSION['admin'])) {
            echo 'Vous n\'avez pas les droits administratifs nécessaires.';
            return;
        }

        // Vérifier si tous les champs requis pour les actions de type POST sont présents
        if (isset($mapping['fields'])) {
            foreach ($mapping['fields'] as $field) {
                if (empty(trim($postData[$field])) && $postData[$field] !== "0" && $field != 'mail') {
                    echo "Champ $field manquant";
                    return;
                }
            }
        }

        // Récupérer les paramètres de l'action
        $params = [];
        if (isset($mapping['idField'])) {
            $id = htmlspecialchars($_POST[$mapping['idField']]);
            $params[] = $id;
        }
        foreach ($mapping['fields'] ?? [] as $field) {
            $params[] = htmlspecialchars($postData[$field]);
        }

        // Vérifier si le controller existe ou la fonction websocket existe
        if (!isset($mapping['controller']) || isset($mapping['webSocketMessage'])) {
            if (isset($mapping['webSocketMessage']))
                echo $mapping['webSocketMessage'];
            else
                echo json_encode('Action non valide');
        } elseif (!empty($mapping['needResponse'])) {
            // Appeler la fonction appropriée avec les paramètres
            header('Content-Type: application/json');

            // Check si le code de session est correct
            if (call_user_func_array([$mapping['controller'], $action], $params)) {
                echo json_encode($mapping['success']);
            } else {
                echo json_encode($mapping['error']);
            }
        } else {
            $controllers = $mapping['controller'];
            // Appeler la fonction appropriée avec les paramètres $controllers->action($params);
            call_user_func_array([$controllers, $action], $params);
        }

        // Si le formulaire nécessite de déposer un fichier (ex: image d'un spartiate)
        if (isset($files["fileToUpload"])) {
            $target_dir = "../assets/spartImage/";
            $imageFileType = strtolower(pathinfo(basename($files["fileToUpload"]["name"]), PATHINFO_EXTENSION));
            $target_file = $target_dir . strtolower($postData['lastName']) . "_" . strtolower($postData['name'] . "." . $imageFileType);

            // restreindre aux extensions d'image
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                move_uploaded_file(str_replace("\\\\", "\\", $files["fileToUpload"]["tmp_name"]), $target_file);
            }
        }

        // Redirection
        if (isset($mapping['redirect'])) {
            echo $mapping['redirect'];
        }
    } else {

        // Gérer les actions non valides
        echo 'Action non valide';
    }
}

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && !empty($_POST['action'])) {
    if (isset($actionsMapping[$_POST['action']])) {
        // Utilisation de la fonction si la requête ajax est détectée
        handleAction($actionsMapping);
    } elseif ($_POST['action'] == 'deconnect') {
        $_SESSION['admin'] = false;
        echo '/home';
    }
}