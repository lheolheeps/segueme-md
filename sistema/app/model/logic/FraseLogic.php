<?php

class FraseLogic extends LogicModel {

    public function __construct() {
        parent::__construct(new FraseDAO());
    }
    
}