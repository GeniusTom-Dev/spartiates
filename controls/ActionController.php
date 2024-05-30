<?php

namespace controls;

class ActionController{

    private array $actions = array();

    public function registerAction(string $name, array $fields, string $controller, ?string $redirect, bool $adminOnly = false, mixed ...$bonusArgs): void{

        $newAction = new \stdClass();
        $newAction->name = $name;
        $newAction->fields = $fields;
        $newAction->controller = $controller;
        $newAction->redirect = $redirect;
        $newAction->adminOnly = $adminOnly;

        foreach ($bonusArgs as $arg) {
            foreach ($arg as $key => $value) {
                $newAction->$key = $value;
            }

        }

        $this->actions[$name] = $newAction;

    }


    public function handleAction(): void
    {
        $postData = $_POST;
        $files = $_FILES;
        $action = $_POST['action'];
        if (isset($actions[$action])) {
            $mapping = $actions[$action];

            // Vérifier si l'action nécessite des privilèges administratifs
            if ($mapping->adminOnly && empty($_SESSION['admin'])) {
                echo 'Vous n\'avez pas les droits administratifs nécessaires.';
                return;
            }

            // Vérifier si tous les champs requis pour les actions de type POST sont présents
            if (isset($mapping->fields)) {
                foreach ($mapping->fields as $field) {
                    if (empty(trim($postData[$field])) && $postData[$field] !== "0" && $field != 'mail') {
                        echo "Champ $field manquant";
                        return;
                    }
                }
            }

            // Récupérer les paramètres de l'action
            $params = [];
            if (isset($mapping->idField)) {
                $id = htmlspecialchars($_POST[$mapping->idField]);
                $params[] = $id;
            }
            foreach ($mapping->fields ?? [] as $field) {
                $params[] = htmlspecialchars($postData[$field]);
            }

            // Vérifier si le controller existe ou la fonction websocket existe
            if (!isset($mapping->controller) || isset($mapping->webSocketMessage)) {
                if (isset($mapping->webSocketMessage))
                    echo $mapping->webSocketMessage;
                else
                    echo json_encode('Action non valide');
            } elseif (!empty($mapping->needResponse)) {
                // Appeler la fonction appropriée avec les paramètres
                header('Content-Type: application/json');

                // Check si le code de session est correct
                if (call_user_func_array([$mapping->controller, $action], $params)) {
                    echo json_encode($mapping->success);
                } else {
                    echo json_encode($mapping->error);
                }
            } else {
                $controllers = $mapping->controller;
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
            if (isset($mapping->redirect)) {
                echo $mapping->redirect;
            }
        } else {

            // Gérer les actions non valides
            echo 'Action non valide';
        }
    }
}