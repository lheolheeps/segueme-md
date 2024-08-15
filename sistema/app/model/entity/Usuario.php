<?php

/**
* @Table = usuario
*/
class Usuario {

    /**
    * @Serial
    * @Colmap = idusuario
    */
    private $id;
    
    /**
    * @Colmap = nome
    * @Persistence (type=texto,NotNull=true,MaxSize=45)
    */
    private $nome;
    
    /**
    * @Colmap = email
    * @Persistence (type=texto,NotNull=true,MaxSize=150)
    */
    private $email;
    
    /**
    * @Colmap = tipo
    * @Persistence (type=inteiro,NotNull=true)
    * @Relationship (objeto=TipoUsuario,type=OneToOne)
    */
    private $tipo; 
    
    /**
    * @Colmap = apelido
    * @Persistence (type=texto,MaxSize=45)
    */
    private $apelido;
    
    /**
    * @Colmap = senha
    * @Persistence (type=texto,NotNull=true,MaxSize=45)
    */
    private $senha;
    
    /**
    * @Colmap = url_img
    * @Persistence (type=texto,MaxSize=250)
    */
    private $urlImagem;
    
    /**
    * @Colmap = notificacoes
    * @Persistence (type=texto,size=1)
    */
    private $notificacoes;
    
    /**
    * @Colmap = hierarquia
    * @Persistence (type=inteiro,NotNull=true)
    * @Relationship (objeto=Hierarquia,type=OneToOne)
    */
    private $hierarquia; 
    
    /**
    * @Colmap = status
    * @Persistence (type=texto,size=1)
    */
    private $status;
    
    /**
    * @Colmap = obs
    * @Persistence (type=texto,MaxSize=150)
    */
    private $observacao;
     
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getApelido() {
        return $this->apelido;
    }

    function getSenha() {
        return $this->senha;
    }

    function getUrlImagem() {
        return $this->urlImagem;
    }

    function getNotificacoes() {
        return $this->notificacoes;
    }

    function getHierarquia() {
        return $this->hierarquia;
    }

    function getStatus() {
        return $this->status;
    }

    function getObservacao() {
        return $this->observacao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setApelido($apelido) {
        $this->apelido = $apelido;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setUrlImagem($urlImagem) {
        $this->urlImagem = $urlImagem;
    }

    function setNotificacoes($notificacoes) {
        $this->notificacoes = $notificacoes;
    }

    function setHierarquia($hierarquia) {
        $this->hierarquia = $hierarquia;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setObservacao($observacao) {
        $this->observacao = $observacao;
    }


}
