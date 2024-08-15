<?php

class ServiceLogic {

    public function post(&$view, $params = null, $dados = null) {
        if (isset($params['l']) && isset($params['a'])) {
            $logic = ucfirst($params['l'] . 'Logic');
            $action = $params['a'];
            unset($params['l'], $params['a']);
            return $logic::$action($view, $params, $dados);
        } else {
            $view->status = 400;
            return array('message' => '400 Bad Request');
        }
    }

}
