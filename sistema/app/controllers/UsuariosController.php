<?php

class UsuariosController extends TPub {

    public function index() {
        RedirectorHelper::goToAction('listar');
    }

    public function listar() {
        $SECURITY = SecurityHelper::getInstancia();
        if ($SECURITY->isLogado()) {  
            if(isset($_SESSION['success'])){
                $this->addDados('success', $_SESSION['success']);
                $this->addDados('infoSuccess', 'Usuario Modificado com Sucesso!!!');
                unset($_SESSION['success']);
            }
            if(isset($_SESSION['error'])){
                $this->addDados('erro', true);
                $this->addDados('infoErro', 'Ocorreu um erro inesperado, e o usuario não foi modificado. Tente novamente ou Contate o Administrador!!!');
                unset($_SESSION['error']);
            }          
            $this->HTML->addCss(PATH_TEMPLATE_CSS_URL . "datatables/tools/css/dataTables.tableTools.css");
            $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "datatables/js/jquery.dataTables.js");
            $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "datatables/tools/js/dataTables.tableTools.js");
            $this->HTML->addJavaScript(PATH_JS_URL . $this->getController() . "/" . $this->getAction() . ".js");
            $usuarioLogic = new UsuarioLogic();
            $this->addDados('listaNovosUsuarios', $usuarioLogic->listar("status = 'D'"));
            $this->addDados('listaUsuariosRejeitados', $usuarioLogic->listar("status = 'R'"));
            $this->addDados('listaUsuarios', $usuarioLogic->listar("status = 'A' AND idusuario != 3 AND idusuario != {$SECURITY->getUsuario()->getId()}"));
            if(!$this->getParam('tab',false) || $this->getParam('tab',false) == 'n'){
                $this->addDados('novos', 'active');
                $this->addDados('existentes', '');
                $this->addDados('cancelados', '');
            }elseif($this->getParam('tab',false) == 'e'){
                $this->addDados('novos', '');
                $this->addDados('existentes', 'active');
                $this->addDados('cancelados', '');
            }elseif($this->getParam('tab',false) == 'c'){
                $this->addDados('novos', '');
                $this->addDados('existentes', '');
                $this->addDados('cancelados', 'active');
            }
            $this->TView('lista');
        } else {
            $_SESSION['erroLogue-se'] = true;
            RedirectorHelper::goToController('Logon');
        }
    }
    
    public function aceitar() {
        $SECURITY = SecurityHelper::getInstancia();
        if ($SECURITY->isLogado()) {  
            $usuarioLogic = new UsuarioLogic();
            $usuario = $usuarioLogic->obterPorId($this->getParam('id'));
            $usuario->setStatus('A');
            $salvar = $usuarioLogic->salvar($usuario);
            if($salvar[0]){
                $_SESSION['success'] = true;
            }else{
                $_SESSION['error'] = true;
            }
            if($this->getParam('tab',false) == 'n'){
                RedirectorHelper::addParameter('tab', 'n');
            }else{
                RedirectorHelper::addParameter('tab', 'c');
            }
            RedirectorHelper::goToAction('listar');
        } else {
            $_SESSION['erroLogue-se'] = true;
            RedirectorHelper::goToController('Logon');
        }
    }
    
    public function rejeitar() {
        $SECURITY = SecurityHelper::getInstancia();
        if ($SECURITY->isLogado()) {  
            $usuarioLogic = new UsuarioLogic();
            $usuario = $usuarioLogic->obterPorId($this->getParam('id'));
            $usuario->setStatus('R');
            $salvar = $usuarioLogic->salvar($usuario);
            if($salvar[0]){
                $_SESSION['success'] = true;
            }else{
                $_SESSION['error'] = true;
            }
            if($this->getParam('tab',false) == 'n'){
                RedirectorHelper::addParameter('tab', 'n');
            }else{
                RedirectorHelper::addParameter('tab', 'e');
            }
            RedirectorHelper::goToAction('listar');
        } else {
            $_SESSION['erroLogue-se'] = true;
            RedirectorHelper::goToController('Logon');
        }
    }

}
