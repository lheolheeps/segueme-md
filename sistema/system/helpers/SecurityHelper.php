<?php

#Author Felipe Assunção

class SecurityHelper {

    private $usuarioLogado;
    private static $instancia = null;
    private $seguranca;

    public static function getInstancia() {
        if (self::$instancia == null) {
            self::$instancia = new SecurityHelper();
        }
        return self::$instancia;
    }
    
    public function SecurityHelper() {

        if (!isset($_SESSION))
            session_start();

        $this->seguranca = $this->getDadosSeguranca();
    }
    
    private function getDadosSeguranca() {
        $ini = parse_ini_file('system/config/config.ini', true);
        return $ini['seguranca'];
    }
    
    public function alterarUsuario($idPessoa){
        $usuarioLogic = new UsuarioLogic();
        unset($_SESSION[$this->seguranca['sessao']]);
        $_SESSION[$this->seguranca['sessao']] = serialize($usuarioLogic->obter("pessoa = '{$idPessoa}'",true));
    }

    public function iniciarSessao($usuario) {
        $_SESSION['time_session'] = time();
        $_SESSION[$this->seguranca['sessao']] = serialize($usuario);
    }

    public function destruirSessao() {
        unset($_SESSION['time_session']);
        unset($_SESSION[$this->seguranca['sessao']]);
        $this->seguranca['sessao'] = null;
    }

    public function getUsuario() {
        return unserialize($_SESSION[$this->seguranca['sessao']]);
    }

    public function isLogado() {
        if ($this->getUsuario() !== FALSE) {
            return true;
        } else {
            return false;
        }
    }

}
