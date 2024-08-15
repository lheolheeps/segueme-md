<?php

class CanalLogic extends LogicModel {

    public function __construct() {
        parent::__construct(new CanalDAO());
    }
    
}