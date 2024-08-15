<?php

class CurtidasLogic extends LogicModel {

    public function __construct() {
        parent::__construct(new CurtidasDAO());
    }
}