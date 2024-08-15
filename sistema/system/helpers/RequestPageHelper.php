<?php

/**
 * Helper destinado a pegar informações da página solicitante
 *
 * @author Igor da Hora <igordahora@gmail.com>
 */
class RequestPageHelper {

    public static function getObjPageRequisitante() {
        $url = ( isset($_SERVER['HTTP_REFERER']) ) ? $_SERVER['HTTP_REFERER'] : '';
        if ($url !== '') {
            $queryString = self::queryString($url);
            $arrayQueryString = explode('/', $queryString);
            $objPageRequisitante = new stdClass();
            $objPageRequisitante->controller = $arrayQueryString[0];
            $objPageRequisitante->action = $arrayQueryString[1];
            $objPageRequisitante->params = ( isset($arrayQueryString[2]) && isset($arrayQueryString[3]) ) ? self::getParams($arrayQueryString) : null;
            unset($queryString);
            return $objPageRequisitante;
        } else {
            return false;
        }
    }

    public static function queryString(&$url) {
        $arrayUrl = explode('?', $url);
        $queryString = (isset($arrayUrl[1])) ? $arrayUrl[1] : PAGE_INDEX;
        unset($arrayUrl);
        return $queryString;
    }

    public static function getParams($arrayQueryString) {
        unset($arrayQueryString[0], $arrayQueryString[1]);
        if (end($arrayQueryString) == null) {
            array_pop($arrayQueryString);
        }

        $i = 0;
        if (!empty($arrayQueryString)) {

            foreach ($arrayQueryString as $val) {
                if ($i % 2 == 0) {
                    $ind[] = $val;
                } else {
                    $value[] = $val;
                }
                $i++;
            }
        } else {
            $ind = array();
            $value = array();
        }

        $params = null;
        if (count($ind) === count($value) && !empty($ind) && !empty($value)) {
            $params = array_combine($ind, $value);
            if( isset($params['l']) ) unset($params['l']);
            if( isset($params['a']) ) unset($params['a']);
        }

        return $params;
    }

    public static function getParam(&$arrayParam,$param,$decrypt = true) {
        if(isset($arrayParam[$param])){
            return ($decrypt === false) ? $arrayParam[$param] : SecurityEncryptionHelper::getDecrypt($arrayParam[$param]);
        }else{
            return false;
        }
    }
    
}
