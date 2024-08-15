<?php

class ApiController extends TApi {

    public function index() {
        echo ' ';
    }
    
    public function posts() {
        $publicacaoLogic = new PublicacaoLogic();
        $pagina = ($this->getParam('pagina', false)) ? $this->getParam('pagina', false) : 1 ;
        $totalPosts = $publicacaoLogic->totalRegistro();
        $postsPorPagina = 10;
        $totalPagina = ceil($totalPosts / $postsPorPagina);
        $inicio = ($postsPorPagina * $pagina) - $postsPorPagina;
        $listaPosts = $publicacaoLogic->listar(null, null, null, null, $inicio, $postsPorPagina);
        foreach ($listaPosts as $object) {
            $array[] = $publicacaoLogic->objectToArray($object);
        }
        $json = json_encode($array);
        var_dump($json);exit();
        $this->addDados('json', $json);
        $this->TView('posts');
    }

}
