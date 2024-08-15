<?php

/**
* @Table = canal
*/
class Canal {

    /**
    * @Serial
    * @Colmap = idcanal
    */
    private $id;

    /**
    * @Colmap = descricao
    * @Persistence (type=texto,NotNull=true,MaxSize=45)
    */
    private $descricao;
 
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }


}
