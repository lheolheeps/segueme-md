<?php

class HierarquiaLogic extends LogicModel {

    public function __construct() {
        parent::__construct(new HierarquiaDAO());
    }
    
}