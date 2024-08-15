<?php

/**
* @Table = publicacao
*/
class Publicacao {

    /**
    * @Serial
    * @Colmap = idpublicacao
    */
    private $id;
    
    /**
    * @Colmap = titulo
    * @Persistence (type=texto,NotNull=true,MaxSize=45)
    */
    private $titulo;
    
    /**
    * @Colmap = descricao
    * @Persistence (type=texto,NotNull=true,MaxSize=400)
    */
    private $descricao;
    
    /**
    * @Colmap = url_img
    * @Persistence (type=texto,MaxSize=500)
    */
    private $urlImagem;
    
    /**
    * @Colmap = usuario
    * @Persistence (type=inteiro,NotNull=true)
    * @Relationship (objeto=Usuario,type=OneToOne)
    */
    private $usuario;
    
    /**
    * @Colmap = canal
    * @Persistence (type=inteiro,NotNull=true)
    * @Relationship (objeto=Canal,type=OneToOne)
    */
    private $canal;
    
    /**
    * @Colmap = data
    * @Persistence (type=texto,NotNull=true,MaxSize=45)
    */
    private $data;
     
    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getUrlImagem() {
        return $this->urlImagem;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getCanal() {
        return $this->canal;
    }

    function getData() {
        return $this->data;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setUrlImagem($urlImagem) {
        $this->urlImagem = $urlImagem;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setCanal($canal) {
        $this->canal = $canal;
    }

    function setData($data) {
        $this->data = $data;
    }


}
