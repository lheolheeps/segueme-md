<?php

class ComentariosLogic extends LogicModel {

    public function __construct() {
        parent::__construct(new ComentariosDAO());
    }
    
    public function tratarData() {
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date('Y-m-d');
        $arrayData = explode("-", $dataAtual, 3);
        $meses = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
        $mes = (int)$arrayData[1];
        return "{$arrayData[2]} de {$meses[$mes - 1]}";
    }
    
    /** INICIO - WebApi * */
    public static function lista(&$view, $params, $dados) {
        $view->status = 200;
        $comentariosLogic = new ComentariosLogic();
        $usuarioLogic = new UsuarioLogic();
        $hierarquiaLogic = new HierarquiaLogic();
        $qtdComentarios = $dados['qtd'];
        $inicio = 0;
        $totalComentarios = $comentariosLogic->totalRegistro("publicacao = {$dados['publicacao']}");
        $listaComentarios = $comentariosLogic->listar("publicacao = {$dados['publicacao']}", null, null, null, $inicio, $qtdComentarios);
        if(!$listaComentarios){
            $array = false;
            $mensagem = '204 No Content';
        }else{
            foreach ($listaComentarios as $key => $comentario) {
                $array[$key]['id'] = $comentario->getId();
                $array[$key]['descricao'] = $comentario->getComentario();
                $array[$key]['data'] = $comentario->getData();
                $usuario = $usuarioLogic->obterPorId($comentario->getUsuario());
                $array[$key]['img'] = $usuario->getUrlImagem();
                $hierarquia = $hierarquiaLogic->obterPorId($usuario->getHierarquia());
                $array[$key]['nome'] = $hierarquia->getDescricao() . ' ' . $usuario->getApelido();
                if($comentario->getUsuario() == $dados['usuario']){
                    $array[$key]['propriedade'] = true;                
                }else{
                    $array[$key]['propriedade'] = false;                
                }
            }
            $mensagem = '200 OK';
        }
        //var_dump($dados,$listaComentarios,$array,$totalComentarios);exit();
        return array('message' => $mensagem, 'comentarios' => $array, 'totalComentarios' => $totalComentarios);
    }
    
    public static function deleteComentario(&$view, $params, $dados) {
        $view->status = 201;
        $comentariosLogic = new ComentariosLogic();
        $retorno = false;
        $id = (int)$dados['id'];
        $comentario = $comentariosLogic->excluirPorId($id);
        if($comentario){
            $retorno = true;
        }
        
        return array('message' => '200 OK', 'retorno' => $retorno);
    }
    
    public static function comentar(&$view, $params, $dados) {
        $view->status = 201;
        $comentariosLogic = new ComentariosLogic();
        $comentario = new Comentarios();
        $retorno = false;
        $comentario->setUsuario((int)$dados['usuario']);
        $comentario->setPublicacao((int)$dados['publicacao']);
        $comentario->setComentario($dados['comentario']);
        $data = $comentariosLogic->tratarData();
        $comentario->setData($data);
        $salvar = $comentariosLogic->salvar($comentario);
        if($salvar){
            $retorno = true;
        }
        
        return array('message' => '200 OK', 'retorno' => $retorno);
    }
    /** FIM - WebApi * */
}