<?php

/**
 * @author Felipe Assunção
 */
class TApi extends Controller {

    public $HTML;

    public function __construct() {

        parent::__construct();    

        $this->HTML = new THtmlHelper();
    }

    public function init() {

        parent::init();

        # Definir icon padrãoo do sistema
        $this->HTML->setIcon("");
        
        # Define MetaTag
        $this->HTML->addMetaAuthor('Felipe Assunção');
        $this->HTML->addMetaType('application/json;charset=utf-8');

        # Definir nome da pagina
        $this->HTML->setTitle(strtoupper(NAME_SIS) . " - Api");

    }

    public function TView($nome) {

        # Inicia o buffer
        ob_start();

        #base da tela
        echo '<div>';
            # Incluir pagina no template
            $this->view($nome);
            # Fim da pagina
        echo '</div>';
        
        # Pegar view e aloca numa variavel
        $content = ob_get_clean();

        # Adicionar a view ao Body
        $this->HTML->setBodyContent($content);

        # Imprime o HTML
        echo $this->HTML->getHtml();
    }

}