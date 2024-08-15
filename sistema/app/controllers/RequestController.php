<?php
/**
 * Controller de requisição de dados
 */
class RequestController extends TRequest {

    public function post() {
        $nameObjLogic = ucfirst($this->getParam('l',false)) . 'Logic';
        $method = $this->getParam('a',false);
        $ObjLogic = new $nameObjLogic();
        $ObjLogic->$method( RequestPageHelper::getObjPageRequisitante() );
    }

    public function get() {
        $nameObjLogic = ucfirst($this->getParam('l')) . 'Logic';
        $method = $this->getParam('a');
        $ObjLogic = new $nameObjLogic();
        $params = $this->getParam();
        unset($params['a'],$params['l']);
        (count($params) > 0) ? $ObjLogic->$method($params) : $ObjLogic->$method();
    }

}