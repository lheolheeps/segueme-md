<?php

class PerfilController extends TLogin {

    public function index() {
        RedirectorHelper::goToAction('cadastrar');
    }
    
    public function cadastrar() {
        $SECURITY = SecurityHelper::getInstancia();
        $this->HTML->addJavaScript(PATH_JS_URL . $this->getController() . "/" . $this->getAction() . ".js");
        if(isset($_SESSION['erro'])){
            $this->addDados('erro', $_SESSION['erro']);
            unset($_SESSION['erro']);
        }

        if(isset($_SESSION['erroEmail'])){
            $this->addDados('erroEmail', $_SESSION['erroEmail']);
            unset($_SESSION['erroEmail']);
        }

        if(isset($_SESSION['erroSenha'])){
            $this->addDados('erroSenha', $_SESSION['erroSenha']);
            unset($_SESSION['erroSenha']);
        }

        if(isset($_SESSION['erroImg'])){
            $this->addDados('erroImg', $_SESSION['erroImg']);
            unset($_SESSION['erroImg']);
        }

        if(isset($_SESSION['success'])){
            $this->addDados('success', $_SESSION['success']);
            unset($_SESSION['success']);
        }
        $this->TViewLogin('cadastro');
    }
    
    public function editar() {
        $SECURITY = SecurityHelper::getInstancia();
        $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.min.js");
        $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.populate.js");
        $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.maskMoney.js");
        
        if(isset($_SESSION['erro'])){
            $this->addDados('erro', $_SESSION['erro']);
            unset($_SESSION['erro']);
        }

        if(isset($_SESSION['success'])){
            $this->addDados('success', $_SESSION['success']);
            unset($_SESSION['success']);
        }
        $usuarioLogic = new UsuarioLogic();
        $usuario = $usuarioLogic->obterPorId($this->getParam('id',false));
        $jsonObjeto = $usuarioLogic->objectToJson($usuario);
        $this->addDados("json_objeto", $jsonObjeto);
        $this->TViewLogin('edita');
    }
    
    public function alterarSenha() {
        $SECURITY = SecurityHelper::getInstancia();
        
        if(isset($_SESSION['erro'])){
            $this->addDados('erro', $_SESSION['erro']);
            unset($_SESSION['erro']);
        }
        
        if(isset($_SESSION['erroConfirmacao'])){
            $this->addDados('erroConfirmacao', $_SESSION['erroConfirmacao']);
            unset($_SESSION['erroConfirmacao']);
        }
        
        if(isset($_SESSION['erroSenha'])){
            $this->addDados('erroSenha', $_SESSION['erroSenha']);
            unset($_SESSION['erroSenha']);
        }

        if(isset($_SESSION['success'])){
            $this->addDados('success', $_SESSION['success']);
            unset($_SESSION['success']);
        }
        
        $this->addDados("id", $this->getParam('id',false));
        $this->TViewLogin('alteraSenha');
    }
}

