<?php

class TipoUsuarioLogic extends LogicModel {

    public function __construct() {
        parent::__construct(new TipoUsuarioDAO());
    }
    
}