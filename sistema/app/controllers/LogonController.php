<?php

class LogonController extends TLogin {

    public function index() {
        RedirectorHelper::goToAction('login');
    }
    
    public function login() {
        $SECURITY = SecurityHelper::getInstancia();
        if ($SECURITY->isLogado()) {
            RedirectorHelper::goToControllerAction('Index', 'index');
        } else {
            $this->HTML->addJavaScript(PATH_JS_URL . $this->getController() . "/" . $this->getAction() . ".js");
            if(isset($_SESSION['erro'])){
                $this->addDados('erro', $_SESSION['erro']);
                unset($_SESSION['erro']);
            }

            if(isset($_SESSION['erroLogue-se'])){
                $this->addDados('erroLoguese', $_SESSION['erroLogue-se']);
                unset($_SESSION['erroLogue-se']);
            }

            if(isset($_SESSION['erroStatus'])){
                $this->addDados('erroStatus', $_SESSION['erroStatus']);
                unset($_SESSION['erroStatus']);
            }
            if(isset($_SESSION['erroTipo'])){
                $this->addDados('erroTipo', $_SESSION['erroTipo']);
                unset($_SESSION['erroTipo']);
            }
            $this->TViewLogin('login');
        }
    }
    
    public function loginFB() {
        $usuarioLogic = new UsuarioLogic();
        $retorno = $usuarioLogic->loginFB($this->getParam('email',false));
        echo $retorno;
    }

}
