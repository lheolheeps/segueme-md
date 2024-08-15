<?php

class PublicacaoController extends TPub {

    public function index() {
        RedirectorHelper::goToAction('listar');
    }
    
    public function listar() {
        $SECURITY = SecurityHelper::getInstancia();
        if (!$SECURITY->isLogado()) {
            $_SESSION['erroLogue-se'] = true;
            RedirectorHelper::goToController('Logon');
        } else {
            if(isset($_SESSION['successCad'])){
                $this->addDados('success', $_SESSION['successCad']);
                $this->addDados('infoSuccess', 'Post Publicado com Sucesso, VAMOS CONFERIR!!!');
                unset($_SESSION['successCad']);
            }
            if(isset($_SESSION['successDel'])){
                $this->addDados('success', $_SESSION['successDel']);
                $this->addDados('infoSuccess', 'Post excluido com Sucesso, VAMOS PUBLICAR!!!');
                unset($_SESSION['successDel']);
            }
            if(isset($_SESSION['successAtt'])){
                $this->addDados('success', $_SESSION['successAtt']);
                $this->addDados('infoSuccess', 'Post atuaizado com Sucesso, VAMOS CONFERIR!!!');
                unset($_SESSION['successAtt']);
            }
            if(isset($_SESSION['erroDel'])){
                $this->addDados('error', true);
                $this->addDados('infoErro', 'Ocorreu um erro inesperado, e o registro não foi deletado. Tente novamente ou Contate o Administrador!!!');
                unset($_SESSION['erroDel']);
            }
            $userLogado = $SECURITY->getUsuario();
            $publicacaoLogic = new PublicacaoLogic();
            $pagina = ($this->getParam('pagina', false)) ? $this->getParam('pagina', false) : 1 ;
            $totalPosts = $publicacaoLogic->totalRegistro("usuario = {$userLogado->getId()} or usuario = 3");
            $postsPorPagina = 20;
            $totalPagina = ceil($totalPosts / $postsPorPagina);
            $inicio = ($postsPorPagina * $pagina) - $postsPorPagina;
            $listaPosts = $publicacaoLogic->listar("usuario = {$userLogado->getId()} OR usuario = 3", "id:desc", null, null, $inicio, $postsPorPagina);
            $this->addDados('listaPosts', $listaPosts);
            $this->addDados('totalPagina', $totalPagina);
            $this->addDados('pagina', $pagina);
            $this->TView('lista');
        }
    }
    
    public function cadastrar() {
        $SECURITY = SecurityHelper::getInstancia();
        if (!$SECURITY->isLogado()) {
            $_SESSION['erroLogue-se'] = true;
            RedirectorHelper::goToController('Logon');
        } else {
            if(isset($_SESSION['erro'])){
                $this->addDados('erro', $_SESSION['erro']);
                $this->addDados('infoErro', 'Um Erro inesperado aconteceu. Por favor contate o Administrador!!!');
                unset($_SESSION['erro']);
            }
            
            if(isset($_SESSION['erroFormato'])){
                $this->addDados('erro', $_SESSION['erroFormato']);
                $this->addDados('infoErro', 'Esse formato não é permitido, Por favor adicione uma imagem nos formatos .PNG ou .JPG!!!');
                unset($_SESSION['erroFormato']);
            }
            
            $usuario = $SECURITY->getUsuario()->getNome();
            $this->addDados('usuario', $usuario);
            $this->TView('cadastro');
        }
    }
    
    public function excluir(){
       $SECURITY = SecurityHelper::getInstancia();
        if (!$SECURITY->isLogado()) {
            $_SESSION['erroLogue-se'] = true;
            RedirectorHelper::goToController('Logon');
        } else {
            $publicacaoLogic = new PublicacaoLogic();
            $curtidasLogic = new CurtidasLogic();
            $comentariosLogic = new ComentariosLogic();
            $id = $this->getParam('id');
            if ($curtidasLogic->excluir("publicacao = {$id}")){
                if($comentariosLogic->excluir("publicacao = {$id}")){
                    $padrao = PATH_PUBLIC_URL . 'images/posts/padrao.jpg';
                    $post = $publicacaoLogic->obterPorId($id);
                    $destinoOLD = $post->getUrlImagem();
                    if ($destinoOLD !== $padrao){
                        $arrayDestino = explode("/", $destinoOLD, 6);
                        $img = PATH_PUBLIC . $arrayDestino[5];
                        unlink($img);
                    }
                    $result = $publicacaoLogic->excluirPorId($id);
                    if(!$result){
                        $_SESSION['erroDel'] = true;
                    } else {
                        $_SESSION['successDel'] = true;
                    }
                } else {
                    $_SESSION['erroDel'] = true;
                }
            } else{
                $_SESSION['erroDel'] = true;
            }
            RedirectorHelper::addParameter('pagina', $this->getParam('p',false));
            RedirectorHelper::goToControllerAction('Publicacao', 'listar');
        } 
    }
    
    public function alterar(){
       $SECURITY = SecurityHelper::getInstancia();
        if (!$SECURITY->isLogado()) {
            $_SESSION['erroLogue-se'] = true;
            RedirectorHelper::goToController('Logon');
        } else {
            if(isset($_SESSION['erro'])){
                $this->addDados('erro', $_SESSION['erro']);
                $this->addDados('infoErro', 'Um Erro inesperado aconteceu. Por favor contate o Administrador!!!');
                unset($_SESSION['erro']);
            }
            
            if(isset($_SESSION['erroFormato'])){
                $this->addDados('erro', $_SESSION['erroFormato']);
                $this->addDados('infoErro', 'Esse formato não é permitido, Por favor adicione uma imagem nos formatos .PNG ou .JPG!!!');
                unset($_SESSION['erroFormato']);
            }
            
            if(isset($_SESSION['erroDel'])){
                $this->addDados('error', true);
                $this->addDados('infoErro', 'Ocorreu um erro ao tentar atualizar a imagem. Tente novamente ou Contate o Administrador!!!');
                unset($_SESSION['erroDel']);
            }
            $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.populate.js");
            $this->HTML->addJavaScript(PATH_JS_CORE_URL . "jquery.maskMoney.js");
            $publicacaoLogic = new PublicacaoLogic();
            $post = $publicacaoLogic->obterPorId($this->getParam('id'));
            $jsonObjeto = $publicacaoLogic->objectToJson($post);
            $this->addDados("json_objeto", $jsonObjeto);
            $this->addDados("img", $post->getUrlImagem());
            $usuario = $SECURITY->getUsuario()->getNome();
            $this->addDados('usuario', $usuario);
            $this->addDados('pagina', $this->getParam('p',false));
            $this->TView('alterar');
        } 
    }

}
