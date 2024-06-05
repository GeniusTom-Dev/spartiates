<?php

namespace controls;

use stdClass;

/**
 * Class ActionController
 *
 * This class manages the registration and handling of various actions.
 * It allows actions to be registered with specific fields, controllers, redirection,
 * and other optional parameters. It handles the execution of these actions based on the provided POST data.
 */
class ActionController{

    /**
     * @var array $actions An array that stores the registered actions.
     */
    private array $actions = array();

    /**
     * Registers a new action with the specified parameters.
     *
     * @param string $name The name of the action.
     * @param array $fields An array containing fields required for the action.
     *                     'fields' key contains the required fields, 'idField' key contains the ID field.
     * @param string $controller The controller that will handle the action.
     * @param string|null $redirect URL to redirect after the action is handled. Null if no redirection.
     * @param bool $adminOnly Indicates if the action requires admin privileges.
     * @param mixed ...$bonusArgs Additional optional arguments for the action.
     *
     * @return void
     */
    public function registerAction(string $name, array $fields, string $controller, ?string $redirect, bool $adminOnly = false, mixed ...$bonusArgs): void{

        $newAction = new stdClass();
        $newAction->name = $name;
        $newAction->fields = $fields['fields'] ?? [];

        if (isset($fields['idField'])) {
            $newAction->idField = $fields['idField'];
        }

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

    /**
     * Handles the action based on POST data and registered actions.
     *
     * This method checks if the action is registered, validates the required fields,
     * checks for admin privileges if necessary, and executes the corresponding controller method.
     *
     * @return void
     */
    public function handleAction(): void
    {
        $postData = $_POST;
        $files = $_FILES;
        $action = $_POST['action'];

        if (isset($this->actions[$action])) {

            // Retrieve the array corresponding to the action to be performed
            $mapping = $this->actions[$action];

            // Check if the action requires admin privileges
            if ($mapping->adminOnly && empty($_SESSION['admin'])) {
                echo 'Vous n\'avez pas les droits administratifs nécessaires.';
                return;
            }

            // Check if all required fields for POST actions are present
            if (isset($mapping->fields)) {
                foreach ($mapping->fields as $field) {
                    if (empty(trim($postData[$field])) && $postData[$field] !== "0" && $field !== 'phone') {
                        echo "Champ $field manquant";
                        return;
                    }
                }
            }

            // Retrieve the parameters of the action
            $params = [];
            if (isset($mapping->idField)) {
                $id = htmlspecialchars($_POST[$mapping->idField]);
                $params[] = $id;
            }
            foreach ($mapping->fields ?? [] as $field) {
                $params[] = trim(htmlspecialchars($postData[$field]));
            }

            if(isset($mapping->controller)){
                $mapping->controller = "controls\\" . $mapping->controller;
                $mapping->controller = new $mapping->controller();
            }

            // Check if the controller exists or the websocket function exists
            if (!isset($mapping->controller) || isset($mapping->webSocketMessage)) {
                if (isset($mapping->webSocketMessage))
                    echo $mapping->webSocketMessage;
                else
                    echo json_encode('Action non valide');
            } elseif (!empty($mapping->needResponse)) {
                // Call the appropriate function with the parameters
                header('Content-Type: application/json');

                // Check if the session code is correct
                if (call_user_func_array([$mapping->controller, $action], $params)) {
                    echo json_encode($mapping->success);
                } else {
                    echo json_encode($mapping->error);
                }
            } else {
                $controllers = $mapping->controller;
                // Call the appropriate function with the parameters $controllers->action($params);
                call_user_func_array([$controllers, $action], $params);
            }

            // If the form requires uploading a file (e.g., image of a Spartan)
            if (isset($files["fileToUpload"])) {
                $target_dir = realpath(".") . "/assets/spartImage/";
                $imageFileType = strtolower(pathinfo(basename($files["fileToUpload"]["name"]), PATHINFO_EXTENSION));
                $target_file = $target_dir . strtolower($postData['lastName']) . "_" . strtolower($postData['name'] . "." . $imageFileType);

                // Restrict to image extensions
                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                    move_uploaded_file(str_replace("\\\\", "\\", $files["fileToUpload"]["tmp_name"]), $target_file);
                }

            }

            // Redirection
            if (isset($mapping->redirect)) {
                echo $mapping->redirect;
            }
        } else {
            // Handle invalid actions
            echo 'Action non initialisée';
        }
    }
}