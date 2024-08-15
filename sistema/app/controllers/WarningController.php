<?php

/**
 * Controller direcionado visualização de erros
 * ocasionados durante execução do sistema
 * @author Felipe Assunção <felipeassuncao@pubapp.com.br>
 */
class WarningController extends TPub {

    public function index() {
        $this->addDados('erro', 'OPS!');
        $this->addDados('detalhes', 'Ocorreu um erro, isso é constrangedor!!!');
        $this->TError("erro");
    }

    public function HTTP_401() {
        $this->addDados('detalhes', 'ESTA PAGINA NÃO EXISTE!!!');
        $this->addDados('erro', '401');
        $this->TError("erro");
    }

    public function HTTP_403() {
        $this->addDados('detalhes', 'ACESSO NEGADO!!!');
        $this->addDados('erro', '403');
        $this->TError("erro");
    }

    public function HTTP_404() {
        $this->addDados('detalhes', 'ESTA PAGINA NÃO EXISTE!!!');
        $this->addDados('erro', '404');
        $this->TError("erro");
    }

    public function VIEW_404() {
        $this->addDados('detalhes', 'ESTA PAGINA NÃO EXISTE!!!');
        $this->addDados('erro', ' 404');
        $this->TError("erro");
    }

    public function database(){
        $this->addDados('erro', 'OPS!');
        $this->addDados('detalhes', 'Servidor - Temporariamente indisponivel!!!');
        $this->TError("erro");
    }

}