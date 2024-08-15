<?php

/**
 * Criação de url dinamicas para requisição
 * @author igor da hora <igordahora@gmail.com>
 */
class UrlRequestHelper {

    public static function mountUrlPost($logic, $action, Array $params = null, $encrypt = true) {
        $param = '';
        if ($params !== null) {
            $dados = array();
            foreach ($params as $key => $value) {
                $dados[] = $key;
                $dados[] = ($encrypt === false) ? $value : SecurityEncryptionHelper::getEncrypt($value);
            }
            $param = '/' . implode('/', $dados);
            unset($dados);
        }
        return "index.php?Request/post/l/{$logic}/a/{$action}{$param}";
    }

    public static function mountUrlGet($logic, $action, Array $params = null, $encrypt = true) {
        $param = '';
        if ($params !== null) {
            $dados = array();
            foreach ($params as $key => $value) {
                $dados[] = $key;
                $dados[] = ($encrypt === false) ? $value : SecurityEncryptionHelper::getEncrypt($value);
            }
            $param = '/' . implode('/', $dados);
            unset($dados);
        }
        return "index.php?Request/get/l/{$logic}/a/{$action}{$param}";
    }

    public static function mountUrl($controller, $action, Array $params = null, $encrypt = true) {

        $param = '';
        if ($params !== null) {
            $dados = array();
            foreach ($params as $key => $value) {
                $dados[] = $key;
                $dados[] = ($encrypt === false) ? $value : SecurityEncryptionHelper::getEncrypt($value);
            }
            $param = '/' . implode('/', $dados);
            unset($dados);
        }

        return "index.php?" . ucfirst($controller) . "/{$action}{$param}";
    }


}
