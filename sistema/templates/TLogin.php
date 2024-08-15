<?php

/**
 * Description of Win8
 * @author felipeassuncao
 */
class TLogin extends Controller {

    public $HTML;

    public function __construct() {

        parent::__construct();

        # Constantes
        define("TEMPLATE", __CLASS__ );
        define("PATH_DIR_TEMPLATE_URL", PATH_TEMPLATE_URL . TEMPLATE . "/");
        define("PATH_TEMPLATE_JS_URL", PATH_DIR_TEMPLATE_URL . "js/");
        define("PATH_TEMPLATE_CSS_URL", PATH_DIR_TEMPLATE_URL . "css/");
        define("PATH_TEMPLATE_IMAGE_URL", PATH_DIR_TEMPLATE_URL . "images/");      

        $this->HTML = new THtmlHelper();
    }
    
    public function init() {

        parent::init();

        # Definir icon padrãoo do sistema
        //$this->HTML->setIcon();
        
        $this->HTML->addMetaViewport();
        $this->HTML->addMetaCharset();
        $this->HTML->addMetaAuthor("Felipe Assunção - Anaista e Desenvolvedor");

        # Definir nome da pagina
        $this->HTML->setTitle("Segue-me M/D - Login");

        /* CSS Default */
        $this->HTML->addCss(PATH_TEMPLATE_CSS_URL . "login.css"); //2 entrar
        $this->HTML->addCss("http://fonts.googleapis.com/css?family=Montserrat:400,700"); //1 entrar
        
        $this->addDados('action', $this->getAction());
    }
    
    public function TViewLogin($nome) {

        # Inicia o buffer
        ob_start();

        # Inicio da pagina
        echo '<div class="container">';
        # Incluir view no tamplate
        $this->view($nome);
        echo '</div>';
        # Fim da pagina
        
        # Pegar view e aloca numa variavel
        $content = ob_get_clean();

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Imprime o HTML
        echo $this->HTML->getHtml();
    }
    
}