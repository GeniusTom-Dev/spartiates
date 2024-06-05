<?php

namespace controls;

use Exception;
use JetBrains\PhpStorm\NoReturn;
use stdClass;
use view\View;

/**
 * Class RouteController
 *
 * This class is responsible for managing routes.
 */
class RouteController{
    /**
     * @var array The array of routes.
     */
    private array $routes = [];

    /**
     * @var array The array of titles.
     */
    private array $titles = [];

    /**
     * @var string The URL.
     */
    private string $url;

    /**
     * @var stdClass The route.
     */
    private stdClass $route;

    /**
     * RouteController constructor.
     *
     * Initializes a new instance of the RouteController class.
     */
    public function __construct(){
        $this->getAllTitles();
    }

    /**
     * Displays routes.
     *
     * @param string $url The URL.
     *
     * @return void
     */
    public function displayRoutes($url): void{
        $this->url = $url;
        $route = $this->getRoute();
        if($route !== null) {
            $this->route = $route;
            if ($route->isAdminPage === true && empty($_SESSION['admin'])){
                header('refresh:0;url=/connect');
            }else{
                if(empty($route->controller) === false && empty($route->method) === false){
                    $method = $route->method;
                    if ($route->method === "showUpdateForm"){
                        $route->controller->$method($this->url, htmlspecialchars($_GET['id']));
                    }else{
                        $route->controller->$method();
                    }
                }elseif (empty($route->controller) && empty($route->method) === false) {
                    $method = $route->method;
                    $this->$method();

                    if($method === "forms"){
                        View::display($route->title, $route->filePath);
                    }
                }else{
                    if($route->routes[0] === "download"){
                        View::display($route->title, $route->filePath, null, false);
                    }else{
                        View::display($route->title, $route->filePath);
                    }
                }
            }

        }else{
            View::display("", "");
        }
    }

    /**
     * Gets a route.
     *
     * @return stdClass|null The route.
     */
    private function getRoute(): ?stdClass {
        foreach($this->routes as $route){
            if (in_array($this->url, $route->routes)){
                return $route;
            }
        }

        return null;
    }


    /**
     * Adds a route.
     *
     * @param string|array $routes The routes.
     * @param string $fileName The file name.
     * @param bool $isAdminPage Whether the page is an admin page.
     * @param mixed $controller The controller.
     * @param string|null $method The method.
     *
     * @return void
     * @throws Exception
     */
    public function addRoute(string|array $routes, string $fileName, bool $isAdminPage = false,  mixed $controller = null, string $method = null): void{
        $route = new stdClass();

        if(is_array($routes) === false){
            $route->routes = [$routes];
        }else{
            $route->routes = $routes;
        }

        $route->filePath = $this->findFile($fileName);

        if(empty($route->filePath) || file_exists($route->filePath) === false){
            throw new Exception("File : " . $fileName . " not found");
        }

        $route->controller = $controller;
        $route->method = $method;

        if(empty($this->titles[$fileName]) === false){
            $route->title = $this->titles[$fileName];
        }

        $route->isAdminPage = $isAdminPage;

        $this->routes[] = $route;
        unset($route);

    }

    /**
     * Sets a route.
     *
     * @param string $route The route.
     *
     * @return void
     */
    #[NoReturn] public function setRoute(string $route): void {
        header('refresh:0;url=/' . $route);
        exit;
    }

    /**
     * Finds a file.
     *
     * @param string $file The file.
     * @param string|null $subDir The subdirectory.
     *
     * @return string The file path.
     */
    public function findFile(string $file, string $subDir = null): string {
        $dir = $subDir ?? "view";
        $files = scandir($dir);
        $findValue = "";

        foreach ($files as $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $explodedPath = explode("/", $path);
                if(end($explodedPath) == $file . ".php"){
                    $findValue = implode("/", array_slice($explodedPath, 4));
                    break;
                }
            } else if ($value != "." && $value != "..") {
                $findValue = $this->findFile($file, $dir . DIRECTORY_SEPARATOR . $value);
                if(empty($findValue) === false){
                    break;
                }
            }
        }

        return $findValue;
    }

    /**
     * Gets all titles.
     *
     * @return void
     */
    private function getAllTitles(): void{
        $this->titles = json_decode(file_get_contents("./assets/data/titles.json"), true);
    }

    /**
     * Handles the game route.
     *
     * @return void
     */
    private function game(): void {
        $codesController = new CodesController();
        if (!isset($_SESSION['code']) || !$codesController->checkSessionCode($_SESSION['code'])) {
            $_SESSION['username'] = null;
            $_SESSION['spartanId'] = null;
            $this->setRoute("sessionCode");
        } elseif (empty($_SESSION['spartanId'])) {
            $spartanController = new SpartanController();
            $spartanController->showChooseSpartan();
        }else{
            View::display($this->route->title, $this->route->filePath);
        }

    }

    /**
     * Handles the forms route.
     *
     * @return void
     */
    public function forms(): void {
        $codesController = new CodesController();
        if ($this->url != "username" || (!empty($_SESSION['code']) && $codesController->checkSessionCode($_SESSION['code']))) {
            $_SESSION['spartanId'] = null;
        } else {
            $this->setRoute("sessionCode");
        }

    }

    /**
     * Handles the reset password route.
     *
     * @return void
     */
    public function resetPassword(): void {
        $token = $_GET['token'] ?? null;
        if ($token) {
            View::display("Réinitialiser le mot de passe", "view/forms/resetPwd.php", ['token' => $token]);
        } else {
            View::display("Erreur", "view/error.php");
        }
    }
}