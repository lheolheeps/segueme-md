<?php

class System {

    private $objUrlParam;

    public function __construct() {
        # Informa qual o conjunto de caracteres vai ser utilizado
        header('Content-Type: text/html; charset=UTF-8');
        $this->objUrlParam = new UrlParamHelper();
    }
    
    public function getController() {
        return $this->objUrlParam->getController();
    }
    
    public function getAction() {
        return $this->objUrlParam->getAction();
    }
    
    public function getParam($name = null,$dencrypt = true) {
        return $this->objUrlParam->getParam($name,$dencrypt);
    }

    public function isParam($name) {
        return $this->objUrlParam->isParam($name);
    }
    
    public function run() {

        $controller = $this->objUrlParam->getController() . 'Controller';
        $controller_path = CONTROLLERS . $controller .'.php';

        if (!file_exists($controller_path))
            RedirectorHelper::goToControllerAction("Warning", "VIEW_404");

        require_once ($controller_path);
        $app = new $controller();

        if (!method_exists($app, $this->objUrlParam->getAction()))
                RedirectorHelper::goToControllerAction("Warning", "VIEW_404");

        $method = new ReflectionMethod($controller, $this->objUrlParam->getAction());
        
        if (!$method->isPublic())
            RedirectorHelper::goToControllerAction("Warning", "VIEW_404");
        
        $action = $this->objUrlParam->getAction();
        $app->init();
        $app->$action();
    }

}