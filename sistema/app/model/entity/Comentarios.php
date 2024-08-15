<?php

/**
* @Table = comentarios
*/
class Comentarios {

    /**
    * @Serial
    * @Colmap = idcomentarios
    */
    private $id;
    
    /**
    * @Colmap = comentario
    * @Persistence (type=texto,NotNull=true,MaxSize=300)
    */
    private $comentario;
    
    /**
    * @Colmap = usuario
    * @Persistence (type=inteiro,NotNull=true)
    * @Relationship (objeto=Usuario,type=OneToOne)
    */
    private $usuario;
    
    /**
    * @Colmap = publicacao
    * @Persistence (type=inteiro,NotNull=true)
    * @Relationship (objeto=Publicacao,type=OneToOne)
    */
    private $publicacao;
    
    /**
    * @Colmap = data
    * @Persistence (type=texto,NotNull=true,MaxSize=45)
    */
    private $data;
     
    function getId() {
        return $this->id;
    }

    function getComentario() {
        return $this->comentario;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getPublicacao() {
        return $this->publicacao;
    }

    function getData() {
        return $this->data;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setPublicacao($publicacao) {
        $this->publicacao = $publicacao;
    }

    function setData($data) {
        $this->data = $data;
    }


}
