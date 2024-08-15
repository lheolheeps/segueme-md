<?php

class ApiServeHelper {

    public static function start() {
        header("Access-Control-Allow-Origin: *");
        //header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Headers: AUTHORIZATION, cache-control, pragma");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Cache-Control: max-age=0");
//        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");

        $view = self::getView(array('json'));
        set_exception_handler(function ($exception) use ($view) {
            $data = array("message" => $exception->getMessage());
            if ($exception->getCode()) {
                $view->status = $exception->getCode();
            } else {
                $view->status = 500;
            }
            $view->render($data);
        });

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            // return only the headers and not the content
            // only allow CORS if we're doing a GET - i.e. no saving for now.
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET') {
                header('Access-Control-Allow-Origin: *');
                header('Access-Control-Allow-Headers: X-Requested-With');
            }
            exit;
        }

        self::security();
        self::isPathInfo();
        $params = self::getParams();
        $dados = self::getDadosResquest();
        $class = self::getClass($params);
        $action = self::getAction($params);
        $paramsAction = self::getParamsAction($params);
        //$view->render($paramsAction);exit();
        $data = $class->$action($view, $paramsAction, $dados);
        $view->render($data);
    }

    private static function security() {
        //LogErroORM::gerarLog($_SERVER['PHP_AUTH_PW'], $_SERVER['PHP_AUTH_USER']);
        if (isset($_SERVER['PHP_AUTH_PW']) && isset($_SERVER['PHP_AUTH_USER'])) {

            $id = $_SERVER['PHP_AUTH_USER'];
            $pw = $_SERVER['PHP_AUTH_PW'];

            //$dados = DbORM::obter("SELECT ide_sistema, frase_segura FROM seguranca.sistema WHERE ide_sistema = :id", array('id' => $id));
            $dados['frase_segura'] = $pw;

            if (!isset($dados['frase_segura'])) {
                throw new Exception("401 Unauthorized", 401);
            }

            if ($dados['frase_segura'] !== $pw) {
                throw new Exception("401 Unauthorized", 401);
            }
        } else {
            throw new Exception("401 Unauthorized", 401);
        }
    }

    private static function getApplicationFormats(Array $formats) {

        $map = array(
            "json" => "application/json",
            "xml" => "application/xml"
        );

        $supported_formats = array();
        foreach ($formats as $format) {
            if (isset($map[$format])) {
                $supported_formats[] = $map[$format];
            }
        }

        return $supported_formats;
    }

    private static function getView($formats) {

        $accepted_formats = self::parseAccept();
        $supported_formats = self::getApplicationFormats($formats);
        foreach ($accepted_formats as $format) {
            if (in_array($format, $supported_formats)) {
                // yay, use this format
                break;
            }
        }
        switch ($format) {
            case "application/xml":
                $view = new XmlHelper();
                break;
            case "application/json":
            default:
                $view = new JsonHelper();
                break;
        }

        return $view;
    }

    private static function parseAccept() {
        $hdr = $_SERVER['HTTP_ACCEPT'];
        $accept = array();
        foreach (preg_split('/\s*,\s*/', $hdr) as $i => $term) {
            $o = new \stdclass;
            $o->pos = $i;
            if (preg_match(",^(\S+)\s*;\s*(?:q|level)=([0-9\.]+),i", $term, $M)) {
                $o->type = $M[1];
                $o->q = (double) $M[2];
            } else {
                $o->type = $term;
                $o->q = 1;
            }
            $accept[] = $o;
        }
        usort($accept, function ($a, $b) {
            /* first tier: highest q factor wins */
            $diff = $b->q - $a->q;
            if ($diff > 0) {
                $diff = 1;
            } else if ($diff < 0) {
                $diff = -1;
            } else {
                /* tie-breaker: first listed item wins */
                $diff = $a->pos - $b->pos;
            }
            return $diff;
        });
        $accept_data = array();
        foreach ($accept as $a) {
            $accept_data[$a->type] = $a->type;
        }
        return $accept_data;
    }

    private static function getParams() {

        $pieces = array();
        if (isset($_SERVER['PATH_INFO'])) {
            $pieces = explode('/', $_SERVER['PATH_INFO']);
            unset($pieces[0], $pieces[1], $pieces[2]);
        } else if (isset($_SERVER['REQUEST_URI'])) {
            $requestUri = explode('?', $_SERVER['REQUEST_URI']);
            $dados = explode('/', $requestUri[1]);
            foreach ($dados as $value) {
                if ($value !== 'WebApi' && $value !== 'index') {
                    $pieces[] = $value;
                }
            }
            unset($requestUri);
        }

        return (isset($pieces[0])) ? $pieces : null;
    }

    private static function isPathInfo() {
        if (!isset($_SERVER['PATH_INFO']) && !isset($_SERVER['REQUEST_URI'])) {
            throw new Exception("400 Bad Request", 400);
        }
    }

    private static function getDadosResquest() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return null;
            case 'POST':
                if (empty($_POST)){
                    $_POST = json_decode(file_get_contents('php://input'), true);
                }
                return $_POST;
            case 'PUT':
                $input = file_get_contents('php://input');
                parse_str($input, $params);
                return $params;
            case 'DELETE':
                return null;
            default:
                throw new Exception("400 Bad Request", 400);
        }
    }

    private static function getClass(&$params) {
        if (isset($params[0])) {
            $classLogic = ucfirst($params[0] . 'Logic');
            if (class_exists($classLogic)) {
                return new $classLogic();
            } else {
                throw new Exception("400 Bad Request - " . ucfirst($params[0] . 'Logic'), 400);
            }
        } else {
            throw new Exception("400 Bad Request", 400);
        }
    }

    private static function getActionRequest() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return 'get';
            case 'POST':
                return 'post';
            case 'PUT':
                return 'put';
            case 'DELETE':
                return 'delete';
            default:
                throw new Exception("400 Bad Request", 400);
        }
    }

    private static function getAction(&$params) {
        $classLogic = ucfirst($params[0] . 'Logic');
        unset($params[0]);
        //sort($params);
        if (is_callable(array($classLogic, self::getActionRequest()))) {
            return self::getActionRequest();
        } else {
            throw new Exception("400 Bad Request [{$classLogic}]", 400);
        }
    }

    private static function getParamsAction($params) {
        if (end($params) == null) {
            array_pop($params);
        }

        $i = 0;
        if (!empty($params)) {
            foreach ($params as $val) {
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

        if (count($ind) == count($value) && !empty($ind) && !empty($value)) {
            $params = array_combine($ind, $value);
        } else {
            $params = array();
        }
        
        return $params;
    }

}