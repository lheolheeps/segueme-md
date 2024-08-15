<?php

/**
* @Table = curtidas
*/
class Curtidas {

    /**
    * @Serial
    * @Colmap = idcurtidas
    */
    private $id;
    
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
     
    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getPublicacao() {
        return $this->publicacao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setPublicacao($publicacao) {
        $this->publicacao = $publicacao;
    }


}
