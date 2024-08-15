<?php

class UsuarioLogic extends LogicModel {

    public function __construct() {
        parent::__construct(new UsuarioDAO());
    }
    
    public function logar() {
        $SECURITY = SecurityHelper::getInstancia();
        $usuario = $this->obter("email = '{$_POST['email']}' AND senha = '{$_POST['senha']}'",true);
        if($usuario !== false){
            if($usuario->getStatus() === 'A'){
                if($usuario->getTipo()->getDescricao() == 'admin'){
                    $SECURITY->iniciarSessao($usuario);
                    RedirectorHelper::goToController('Index');
                } else {
                    $_SESSION['erroTipo'] = true;
                    RedirectorHelper::goToController('Logon');
                }
            } else {
                $_SESSION['erroStatus'] = true;
                RedirectorHelper::goToController('Logon');
            }
        }else{
            $_SESSION['erro'] = true;
            RedirectorHelper::goToController('Logon');
        }
    }
    
    public function loginFB($email) {
        $SECURITY = SecurityHelper::getInstancia();
        $usuario = $this->obter("email = '{$email}'",true);
        if($usuario !== false){
            if($usuario->getStatus() === 'A'){
                if($usuario->getTipo()->getDescricao() == 'admin'){
                    $SECURITY->iniciarSessao($usuario);
                    return "ok";
                } else {
                    $_SESSION['erroTipo'] = true;
                    return "tipo";
                }
            } else {
                $_SESSION['erroStatus'] = true;
                return "status";
            }
        }else{
            $_SESSION['erro'] = true;
            return "erro";
        }
    }
    
    public function deslogar() {
        $SECURITY = SecurityHelper::getInstancia();
        $SECURITY->destruirSessao();
        RedirectorHelper::goToController('Logon');
    }  
    
    public function atualizar(){
        $SECURITY = SecurityHelper::getInstancia();
        $usuario = $this->obterPorId($_POST['id']);
        $usuario->setNome($_POST['nome']);
        $usuario->setApelido($_POST['apelido']);
        $salvar = $this->salvar($usuario);
        if($salvar[0]){
            $_SESSION['success'] = true;
        }else{
            $_SESSION['erro'] = true;
        }
        RedirectorHelper::addParameter('id', $_POST['id']);
        RedirectorHelper::goToControllerAction('Perfil', 'editar');
    }
    
    public function alterarSenha(){
        $SECURITY = SecurityHelper::getInstancia();
        $usuario = $this->obterPorId($_POST['id']);
        if($usuario->getSenha() == $_POST['senhaAtual']){
            if($_POST['senha'] == $_POST['confirmacao']){
                $usuario->setSenha($_POST['senha']);
                $salvar = $this->salvar($usuario);
                if($salvar[0]){
                    $_SESSION['success'] = true;
                }else{
                    $_SESSION['erro'] = true;
                }
            }else{
                $_SESSION['erroConfirmacao'] = true;
            }
        }else{
           $_SESSION['erroSenha'] = true; 
        }
        RedirectorHelper::addParameter('id', $_POST['id']);
        RedirectorHelper::goToControllerAction('Perfil', 'alterarSenha');
    }

    public function inserir() {
        $SECURITY = SecurityHelper::getInstancia();
        if($_POST['senha'] != $_POST['confirmacao']){
            $_SESSION['erroSenha'] = true;
            RedirectorHelper::goToControllerAction('Perfil', 'cadastrar');
        }else{
            $_POST['status'] = 'D';
            $_POST['notificacoes'] = 'D';
            $_POST['tipo'] = 1;
            $salvar = $this->salvar($_POST);
            if($salvar[0]){
                $usuario = $this->obterPorId($salvar[1]->getId());
                if($_FILES['imagem']['name'] !== ''){
                    $arquivo_tmp = $_FILES['imagem']['tmp_name'];
                    $nome = $_FILES['imagem']['name'];
                    $extensao = strrchr($nome, '.');
                    $extensao = strtolower($extensao);
                    if ($_FILES["imagem"]["error"] == 0 && strstr('.jpg;.jpeg;.png', $extensao)) {
                        $novoNome = md5(microtime()) . $extensao;
                        $destino = PATH_PUBLIC . 'images/perfis/' . $novoNome;
                        $salvarImagem = @move_uploaded_file($arquivo_tmp, $destino);
                        if ($salvarImagem) {
                            $usuario->setUrlImagem(PATH_PUBLIC_URL . 'images/perfis/' . $novoNome);
                            $atualizar = $this->salvar($usuario);
                            if ($atualizar[0]) {
                                //salvou imagem com sucesso
                                $_SESSION['success'] = true;
                            } else {
                                //nn foi possivel salvar imagem no banco
                                $_SESSION['erro'] = true;
                                unlink($destino);
                                $this->excluirPorId($salvar[1]->getId());
                            }
                        } else {
                            //nn foi possivel salvar imagem no repositorio
                            $_SESSION['erro'] = true;
                            $this->excluirPorId($salvar[1]->getId());
                        }
                    } else {
                        //imagem nn tem as extenções corretas
                        $_SESSION['erroFormato'] = true;
                        $this->excluirPorId($salvar[1]->getId());
                    }
                } else {
                    //nn foi possivel salvar imagem no banco
                    $_SESSION['erroImg'] = true;
                    unlink($destino);
                    $this->excluirPorId($salvar[1]->getId());
                }
            } else {
                $_SESSION['erro'] = true;
            }
            RedirectorHelper::goToControllerAction('Perfil', 'cadastrar');
        }
    }
    
    /** INICIO - WebApi * */
    public static function verificaUsuarioFB(&$view, $params, $dados) {
        $view->status = 200;
        $usuarioLogic = new UsuarioLogic();
        $usuario = $usuarioLogic->obter("email = '{$dados['email']}'");
        if($usuario !== false){
            if($usuario->getStatus() === 'A'){
                $user = $usuario->getId();
                $mensagem = '200 OK';
            }else{
                $user = false;
                $mensagem = '204 No Content';
            }
        }else{
            $user = null;
            $mensagem = '204 No Content';
        }
        return array('message' => $mensagem, 'user' => $user);
    }
    
    public static function verificaUsuario(&$view, $params, $dados) {
        $view->status = 200;
        $usuarioLogic = new UsuarioLogic();
        $usuario = $usuarioLogic->obter("email = '{$dados['email']}' AND senha = '{$dados['senha']}'");
        if($usuario !== false){
            if($usuario->getStatus() === 'A'){
                $user = $usuario->getId();
                $mensagem = '200 OK';
            }else{
                $user = false;
                $mensagem = '204 No Content';
            }
        }else{
            $user = null;
            $mensagem = '204 No Content';
        }
        return array('message' => $mensagem, 'user' => $user);
    }
    
    public static function obterUserLogado(&$view, $params, $dados) {
        $view->status = 200;
        $usuarioLogic = new UsuarioLogic();
        $hierarquiaLogic = new HierarquiaLogic();
        $usuario = $usuarioLogic->obterPorId($dados['id']);
        if($usuario !== false){
            $array['id'] = $usuario->getId();
            $array['nome'] = $usuario->getNome();
            $array['img'] = $usuario->getUrlImagem();
            $hierarquia = $hierarquiaLogic->obterPorId($usuario->getHierarquia());
            $array['apelido'] = $hierarquia->getDescricao() . ' ' . $usuario->getApelido();
            $array['alteraSenha'] = true;
            if($usuario->getObservacao() !== 'Nenhuma Observacao Cadastrada.'){
                $array['alteraSenha'] = false;
            }
            $array['notificacoes'] = true;
            if($usuario->getNotificacoes() !== 'A'){
                $array['notificacoes'] = false;
            }
        }else{
            $array = null;
            $mensagem = '204 No Content';
        }
        return array('message' => $mensagem, 'usuario' => $array);
    }
    
    public static function inserirFB(&$view, $params, $dados) {
        $view->status = 200;
        $usuarioLogic = new UsuarioLogic();
        $usuario = new Usuario();
        $usuario->setNome($dados['nome']);
        $usuario->setApelido($dados['apelido']);
        $usuario->setEmail($dados['email']);
        $hierarquia = (isset($dados['hierarquia'])) ? (int)$dados['hierarquia'] : 1;
        $usuario->setHierarquia($hierarquia);
        $usuario->setNotificacoes('D');
        $usuario->setObservacao('Nenhuma Observacao Cadastrada.');
        $usuario->setSenha('senhafb');
        $usuario->setStatus('D');
        $usuario->setTipo(1);
        $imgurl = 'http://graph.facebook.com/' . $dados['id'] . '/picture?type=large';
        $nome = md5(microtime()) . '.jpg';
        $destino = PATH_PUBLIC . 'images/perfis/' . $nome;
        $urlImagem = PATH_PUBLIC_URL . 'images/perfis/' . $nome;
        if( !@copy( $imgurl, $destino ) ) {
            $errors= error_get_last();
            $retorno = false;
            $mensagem = $errors['message'];
        } else {
            $usuario->setUrlImagem($urlImagem);
            $salvar = $usuarioLogic->salvar($usuario);
            if($salvar[0]){
                $retorno = true;
                $mensagem = '200 OK';
            }else{
                $retorno = false;
                $mensagem = '204 No Content';
            }
        }
        return array('message' => $mensagem, 'retorno' => $retorno);
    }
    /** FIM - WebApi * */
}