<?php

class WebApiController extends Controller{

    public function index() {
        ApiServeHelper::start();
    }

}
