<?php

class PublicacaoLogic extends LogicModel {

    public function __construct() {
        parent::__construct(new PublicacaoDAO());
    }
    
    public function inserir() {
        $SECURITY = SecurityHelper::getInstancia();
        if ($SECURITY->isLogado()) {
            $userLogado = $SECURITY->getUsuario();
            if($_POST['usuario'] !== '3'){
                $_POST['usuario'] = $userLogado->getId();
            }
            $_POST['data'] = $this->tratarData();
            $salvar = $this->salvar($_POST);
            if($salvar[0]){
                $post = $this->obterPorId($salvar[1]->getId());
                if($_FILES['imagem']['name'] !== ''){
                    $arquivo_tmp = $_FILES['imagem']['tmp_name'];
                    $nome = $_FILES['imagem']['name'];
                    $extensao = strrchr($nome, '.');
                    $extensao = strtolower($extensao);
                    if ($_FILES["imagem"]["error"] == 0 && strstr('.jpg;.jpeg;.png', $extensao)) {
                        $novoNome = md5(microtime()) . $extensao;
                        $destino = PATH_PUBLIC . 'images/posts/' . $novoNome;
                        $salvarImagem = @move_uploaded_file($arquivo_tmp, $destino);
                        if ($salvarImagem) {
                            $post->setUrlImagem(PATH_PUBLIC_URL . 'images/posts/' . $novoNome);
                            $atualizarPost = $this->salvar($post);
                            if ($atualizarPost[0]) {
                                //salvou imagem com sucesso
                                $_SESSION['successCad'] = true;
                                RedirectorHelper::goToControllerAction('Publicacao', 'listar');
                            } else {
                                //nn foi possivel salvar imagem no banco
                                $_SESSION['erro'] = true;
                                unlink($destino);
                                $this->excluirPorId($salvar[1]->getId());
                                RedirectorHelper::goToControllerAction('Publicacao', 'cadastrar');
                            }
                        } else {
                            //nn foi possivel salvar imagem no repositorio
                            $_SESSION['erro'] = true;
                            $this->excluirPorId($salvar[1]->getId());
                            RedirectorHelper::goToControllerAction('Publicacao', 'cadastrar');
                        }
                    } else {
                        //imagem nn tem as extenções corretas
                        $_SESSION['erroFormato'] = true;
                        $this->excluirPorId($salvar[1]->getId());
                        RedirectorHelper::goToControllerAction('Publicacao', 'cadastrar');
                    }
                } else {
                    $post->setUrlImagem(PATH_PUBLIC_URL . 'images/posts/padrao.jpg');    
                    $atualizarPost = $this->salvar($post);
                    if ($atualizarPost[0]) {
                        //salvou imagem com sucesso
                        $_SESSION['successCad'] = true;
                        RedirectorHelper::goToControllerAction('Publicacao', 'listar');
                    } else {
                        //nn foi possivel salvar imagem no banco
                        $_SESSION['erro'] = true;
                        unlink($destino);
                        $this->excluirPorId($salvar[1]->getId());
                        RedirectorHelper::goToControllerAction('Publicacao', 'cadastrar');
                    }
                }
            } else {
                $_SESSION['erro'] = true;
                RedirectorHelper::goToControllerAction('Publicacao', 'cadastrar');
            }
        }else{
            $_SESSION['erroLogue-se'] = true;
            RedirectorHelper::goToControllerAction('Logon', 'login');
        }
    }
    
    public function tratarData() {
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date('Y-m-d');
        $arrayData = explode("-", $dataAtual, 3);
        $meses = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
        $mes = (int)$arrayData[1];
        return "{$arrayData[2]} de {$meses[$mes - 1]} de {$arrayData[0]}";
    }
    
    public function atualizar() {
        $SECURITY = SecurityHelper::getInstancia();
        if ($SECURITY->isLogado()) {
            $userLogado = $SECURITY->getUsuario();
            if($_POST['usuario'] !== '3'){
                $_POST['usuario'] = $userLogado->getId();
            }
            $_POST['data'] = $this->tratarData();
            $salvar = $this->salvar($_POST);
            if($salvar[0]){
                $post = $this->obterPorId($salvar[1]->getId());
                if($_FILES['imagem']['name'] !== ''){
                    $arquivo_tmp = $_FILES['imagem']['tmp_name'];
                    $nome = $_FILES['imagem']['name'];
                    $extensao = strrchr($nome, '.');
                    $extensao = strtolower($extensao);
                    if ($_FILES["imagem"]["error"] == 0 && strstr('.jpg;.jpeg;.png', $extensao)) {
                        $novoNome = md5(microtime()) . $extensao;
                        $destino = PATH_PUBLIC . 'images/posts/' . $novoNome;
                        $salvarImagem = @move_uploaded_file($arquivo_tmp, $destino);
                        if ($salvarImagem) {
                            $destinoOLD = $post->getUrlImagem();
                            $post->setUrlImagem(PATH_PUBLIC_URL . 'images/posts/' . $novoNome);
                            $atualizarPost = $this->salvar($post);
                            if ($atualizarPost[0]) {
                                //salvou imagem com sucesso
                                $padrao = PATH_PUBLIC_URL . 'images/posts/padrao.jpg';
                                if ($destinoOLD !== $padrao){
                                    $arrayDestino = explode("/", $destinoOLD, 6);
                                    $img = PATH_PUBLIC . $arrayDestino[5];
                                    unlink($img);
                                }
                                $_SESSION['successAtt'] = true;
                                RedirectorHelper::addParameter('pagina', $_POST['pagina']);
                                RedirectorHelper::goToControllerAction('Publicacao', 'listar');
                            } else {
                                //nn foi possivel salvar imagem no banco
                                $_SESSION['erroImg'] = true;
                                unlink($destino);
                                RedirectorHelper::addUrlParameter('id', $post->getId());
                                RedirectorHelper::goToControllerAction('Publicacao', 'alterar');
                            }
                        } else {
                            //nn foi possivel salvar imagem no repositorio
                            $_SESSION['erroImg'] = true;
                            RedirectorHelper::addUrlParameter('id', $post->getId());
                            RedirectorHelper::goToControllerAction('Publicacao', 'alterar');
                        }
                    } else {
                        //imagem nn tem as extenções corretas
                        $_SESSION['erroFormato'] = true;
                        RedirectorHelper::addUrlParameter('id', $post->getId());
                        RedirectorHelper::goToControllerAction('Publicacao', 'alterar');
                    }
                } else {
                    //Sem imagem para atualizar
                    $_SESSION['successAtt'] = true;
                    RedirectorHelper::addParameter('pagina', $_POST['pagina']);
                    RedirectorHelper::goToControllerAction('Publicacao', 'listar');
                }
            } else {
                $_SESSION['erro'] = true;
                RedirectorHelper::addUrlParameter('id', $post->getId());
                RedirectorHelper::goToControllerAction('Publicacao', 'alterar');
            }
        }else{
            $_SESSION['erroLogue-se'] = true;
            RedirectorHelper::goToControllerAction('Logon', 'login');
        }
    }
    
    /** INICIO - WebApi * */
    public static function lista(&$view, $params, $dados) {
        $view->status = 200;
        $publicacaoLogic = new PublicacaoLogic();
        $usuarioLogic = new UsuarioLogic();
        $curtidasLogic = new CurtidasLogic();
        $comentariosLogic = new ComentariosLogic();
        $qtdPosts = $dados['qtd'];
        $inicio = 0;
        $where = 'canal != 2';
        //var_dump($dados['qtd']);exit();
        if(isset($dados['filtro'])){   
            $filtroSemEspacos = $dados['filtro'];
            $filtro = str_replace("%20"," ",$filtroSemEspacos);
            $where = "canal != 2 and titulo LIKE '%{$filtro}%' OR descricao LIKE '%{$filtro}%'";
        }
        $totalPosts = $publicacaoLogic->totalRegistro($where);
        $listaPosts = $publicacaoLogic->listar($where, "id:desc", null, null, $inicio, $qtdPosts);
        if(!$listaPosts){
            $array = false;
            $mensagem = '204 No Content';
        }else{
            foreach ($listaPosts as $key => $post) {
                $array[$key]['id'] = $post->getId();
                $array[$key]['titulo'] = $post->getTitulo();
                $array[$key]['descricao'] = $post->getDescricao();
                $array[$key]['img'] = $post->getUrlImagem();
                $usuario = $usuarioLogic->obterPorId($post->getUsuario());
                $array[$key]['imgUsuario'] = $usuario->getUrlImagem();
                $array[$key]['data'] = $post->getData();
                $array[$key]['curtidas'] = $curtidasLogic->totalRegistro("publicacao = {$post->getId()}");
                $array[$key]['btnCurtir'] = ($curtidasLogic->totalRegistro("publicacao = {$post->getId()} AND usuario = {$dados['usuario']}") > 0) ? "" : "-outline";
                $array[$key]['curtido'] = ($curtidasLogic->totalRegistro("publicacao = {$post->getId()} AND usuario = {$dados['usuario']}") > 0) ? true : false;
                $array[$key]['comentarios'] = $comentariosLogic->totalRegistro("publicacao = {$post->getId()}");
            }
            $mensagem = '200 OK';
        }
        return array('message' => $mensagem, 'posts' => $array, 'totalPost' => $totalPosts);
    }

    public static function DesCurtir(&$view, $params, $dados) {
        $view->status = 201;
        $curtidasLogic = new CurtidasLogic();
        $retorno = false;
        $usuario = (int)$dados['usuario'];
        $publicacao = (int)$dados['publicacao'];
        $curtida = $curtidasLogic->obter("usuario = {$usuario} AND publicacao = {$publicacao}");
        if($curtida){
            $descurtir = $curtidasLogic->excluirPorId($curtida->getId());
            if($descurtir){
                $curtidas = $curtidasLogic->totalRegistro("publicacao = {$publicacao}");
                $retorno = true;
            }else{
                $retorno = false;
            }
        }else{
            $curtida = new Curtidas();
            $curtida->setPublicacao($publicacao);
            $curtida->setUsuario($usuario);
            $curtir = $curtidasLogic->salvar($curtida);
            if($curtir[0]){
                $curtidas = $curtidasLogic->totalRegistro("publicacao = {$publicacao}");
                $retorno = true;
            }else{
                $retorno = false;
            }
        }
        
        return array('message' => '200 OK', 'retorno' => $retorno, 'newcurtidas' => $curtidas);
    }
    
    public static function ObterPost(&$view, $params, $dados) {
        $view->status = 201;
        $publicacaoLogic = new PublicacaoLogic();
        $usuarioLogic = new UsuarioLogic();
        $curtidasLogic = new CurtidasLogic();
        $comentariosLogic = new ComentariosLogic();
        $post = $publicacaoLogic->obterPorId($dados['id']);
        
        if(!$post){
            $array = false;
            $mensagem = '204 No Content';
        }else{
            $array['id'] = $post->getId();
            $array['titulo'] = $post->getTitulo();
            $array['descricao'] = $post->getDescricao();
            $array['img'] = $post->getUrlImagem();
            $usuario = $usuarioLogic->obterPorId($post->getUsuario());
            $array['imgUsuario'] = $usuario->getUrlImagem();
            $array['data'] = $post->getData();
            $array['curtidas'] = $curtidasLogic->totalRegistro("publicacao = {$post->getId()}");
            $array['btnCurtir'] = ($curtidasLogic->totalRegistro("publicacao = {$post->getId()} AND usuario = {$dados['usuario']}") > 0) ? "" : "-outline";
            $array['curtido'] = ($curtidasLogic->totalRegistro("publicacao = {$post->getId()} AND usuario = {$dados['usuario']}") > 0) ? true : false;
            $array['comentarios'] = $comentariosLogic->totalRegistro("publicacao = {$post->getId()}");
            $mensagem = '200 OK';
        }
        
        return array('message' => '200 OK', 'publicacao' => $array);
    }

    /** FIM - WebApi * */
}