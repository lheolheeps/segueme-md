<?php

/**
* @Table = frases
*/
class Frase {

    /**
    * @Serial
    * @Colmap = idfrases
    */
    private $id;

    /**
    * @Colmap = descricao
    * @Persistence (type=texto,NotNull=true,MaxSize=300)
    */
    private $descricao;

    /**
    * @Colmap = diasemana
    * @Persistence (type=texto,NotNull=true,MaxSize=45)
    */
    private $dia;

    /**
    * @Colmap = autor
    * @Persistence (type=texto,NotNull=true,MaxSize=45)
    */
    private $autor;
 
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getDia() {
        return $this->dia;
    }

    function getAutor() {
        return $this->autor;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setDia($dia) {
        $this->dia = $dia;
    }

    function setAutor($autor) {
        $this->autor = $autor;
    }


}
