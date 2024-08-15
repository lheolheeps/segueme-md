<?php

/**
 * @author Felipe Assunção
 */
class TPub extends Controller {

    public $HTML;

    public function __construct() {

        parent::__construct();

        # Constantes
        define("TEMPLATE", __CLASS__ );
        define("PATH_DIR_TEMPLATE_URL", PATH_TEMPLATE_URL . TEMPLATE . "/");
        define("PATH_TEMPLATE_JS_URL", PATH_DIR_TEMPLATE_URL . "js/");
        define("PATH_TEMPLATE_CSS_URL", PATH_DIR_TEMPLATE_URL . "css/");
        define("PATH_TEMPLATE_IMAGE_URL", PATH_DIR_TEMPLATE_URL . "images/");      
        define("PATH_TEMPLATE_FONTS_URL", PATH_DIR_TEMPLATE_URL . "fonts/");      
        define("PATH_TEMPLATE_LESS_URL", PATH_DIR_TEMPLATE_URL . "less/");      

        $this->HTML = new THtmlHelper();
    }

    public function init() {

        parent::init();

        # Definir icon padrãoo do sistema
        $this->HTML->setIcon("");
        
        # Define MetaTag
        $this->HTML->addMetaViewport();
        $this->HTML->addMetaCharset();
        $this->HTML->addMetaAuthor('EquipePUB');

        # Definir nome da pagina
        $this->HTML->setTitle(strtoupper(NAME_SIS));

        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "nb.js", true); //3 a entrar
        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "nprogress.js", true); //2 a entrar
        $this->HTML->addJavaScript(PATH_TEMPLATE_JS_URL . "jquery.min.js", true); //1 a entrar
        
        $this->HTML->addCss(PATH_TEMPLATE_CSS_URL . "icheck/flat/green.css", true); //5 entrar
        $this->HTML->addCss(PATH_TEMPLATE_CSS_URL . "custom.css", true); //4 entrar
        $this->HTML->addCss(PATH_TEMPLATE_FONTS_URL . "css/animate.min.css", true); //3 entrar
        $this->HTML->addCss(PATH_TEMPLATE_FONTS_URL . "css/font-awesome.min.css", true); //2 entrar
        $this->HTML->addCss(PATH_TEMPLATE_CSS_URL . "bootstrap.min.css", true); //1 entrar

        # Configurar Body
        $this->HTML->setBodyAttribute('class="nav-md"');

    }

    public function TView($nome) {

        # Inicia o buffer
        ob_start();

        #base da tela
        echo '<div class="container body">';
            echo '<div class="main_container">';
                # Incluir cabecalho no template 
                $this->viewCore('header');
                # Fim do cabecalho
                echo '<div class="right_col" role="main">';
                    # Incluir pagina no template
                    $this->view($nome);
                    # Fim da pagina
                    echo '<br />';
                    # Incluir rodape no template
                    $this->viewCore('footer');
                    # fim rodapé
                echo '</div>';
            echo '</div>';
        echo '</div>';
        # Incluir Notificações
        $this->viewCore('notificacoes');
        # Incluir Demais JS's
        $this->viewCore('javascript');
        
        # Pegar view e aloca numa variavel
        $content = ob_get_clean();

        # Adiconar css
        if (file_exists(PATH_PUBLIC . "css/custom.css")) {
            $this->HTML->addCss(PATH_CSS_URL . "custom.css");
        }

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Imprime o HTML
        echo $this->HTML->getHtml();
    }
    
    public function TError($nome) {

        # Inicia o buffer
        ob_start();

        #base da tela
        echo '<div class="container body">';
            echo '<div class="main_container">';
                # Incluir pagina no template
                $this->view($nome);
                # Fim da pagina
            echo '</div>';
        echo '</div>';
        # Incluir Demais JS's
        $this->viewCore('javascript');
        
        # Pegar view e aloca numa variavel
        $content = ob_get_clean();

        # Adiconar css
        if (file_exists(PATH_PUBLIC . "css/custom.css")) {
            $this->HTML->addCss(PATH_CSS_URL . "custom.css");
        }

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Imprime o HTML
        echo $this->HTML->getHtml();
    }
    
    public function TLogin($nome) {

        # Inicia o buffer
        ob_start();

        # Inicio da pagina
        echo '<div class="container">';
        $this->view($nome);
        echo '</div>';
        # Fim da pagina
        
        
        # Pegar view e aloca numa variavel
        $content = ob_get_clean();

        # Adiconar css
        if (file_exists(PATH_PUBLIC . "css/custom.css")) {
            $this->HTML->addCss(PATH_CSS_URL . "custom.css");
        }

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Imprime o HTML
        echo $this->HTML->getHtml();
    }

}