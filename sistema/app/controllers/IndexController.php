<?php

class IndexController extends TPub {

    public function index() {
        $SECURITY = SecurityHelper::getInstancia();
        if ($SECURITY->isLogado()) {
            $publicacaoLogic = new PublicacaoLogic();
            $curtidasLogic = new CurtidasLogic();
            $comentariosLogic = new ComentariosLogic();
            $fraseLogic = new FraseLogic();
            
            //ultima/penultima Publicação
            $listPost = $publicacaoLogic->listar();
            $ultimoPost = array_pop($listPost);
            $penultimoPost = array_pop($listPost);
            
            //curtidas
            IF(!$ultimoPost){
                $curtidasUltima = 0;
            } else{
                $curtidasUltima = $curtidasLogic->totalRegistro("publicacao = {$ultimoPost->getId()}");
            }
            IF(!$penultimoPost){
                $curtidasPenultima = 0;
            } else{
                $curtidasPenultima = $curtidasLogic->totalRegistro("publicacao = {$penultimoPost->getId()}");
            }
            if ($curtidasUltima == 0){
                $curtidasPorcentagem = 100;
                $curtidasCor = 'red';
                $curtidasSeta = 'fa-sort-desc';
            }else{
                if($curtidasPenultima == 0){
                    $curtidasPorcentagem = 100;
                    $curtidasCor = 'green';
                    $curtidasSeta = 'fa-sort-asc';
                } else {
                   if($curtidasUltima > $curtidasPenultima){
                        $curtidasPorcentagem = (($curtidasUltima / $curtidasPenultima) -1) * 100;
                        $curtidasCor = 'green';
                        $curtidasSeta = 'fa-sort-asc';
                    }else{
                        $curtidasPorcentagem = (($curtidasPenultima / $curtidasUltima) -1) * 100;
                        $curtidasCor = 'red';
                        $curtidasSeta = 'fa-sort-desc';
                    }
                }
            }
            $this->addDados('curtidas', $curtidasUltima);
            $this->addDados('curtidasPorcentagem', $curtidasPorcentagem);
            $this->addDados('curtidasCor', $curtidasCor);
            $this->addDados('curtidasSeta', $curtidasSeta);
            
            //comentarios
            IF(!$ultimoPost){
                $comentariosUltima = 0;
            } else{
                $comentariosUltima = $comentariosLogic->totalRegistro("publicacao = {$ultimoPost->getId()}");
            }
            IF(!$penultimoPost){
                $comentariosPenultima = 0;
            } else{
                $comentariosPenultima = $comentariosLogic->totalRegistro("publicacao = {$penultimoPost->getId()}");
            }
            if ($comentariosUltima == 0){
                $comentariosPorcentagem = 100;
                $comentariosCor = 'red';
                $comentariosSeta = 'fa-sort-desc';
            }else{
                if($comentariosPenultima == 0){
                    $comentariosPorcentagem = 100;
                    $comentariosCor = 'green';
                    $comentariosSeta = 'fa-sort-asc';
                } else {
                   if($comentariosUltima > $comentariosPenultima){
                        $comentariosPorcentagem = (($comentariosUltima / $comentariosPenultima) -1) * 100;
                        $comentariosCor = 'green';
                        $comentariosSeta = 'fa-sort-asc';
                    }else{
                        $comentariosPorcentagem = (($comentariosPenultima / $comentariosUltima) -1) * 100;
                        $comentariosCor = 'red';
                        $comentariosSeta = 'fa-sort-desc';
                    }
                }
            }
            $this->addDados('comentarios', $comentariosUltima);
            $this->addDados('comentariosPorcentagem', $comentariosPorcentagem);
            $this->addDados('comentariosCor', $comentariosCor);
            $this->addDados('comentariosSeta', $comentariosSeta);
            
            // Frase do dia
            date_default_timezone_set('America/Sao_Paulo');
            $diaSemana = array('Domingo', 'Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado');
            $dataAtual = date('Y-m-d');
            $diaSemanaNum = date('w', strtotime($dataAtual));
            $frase = $fraseLogic->obter("diasemana = '{$diaSemana[$diaSemanaNum]}'");
            if(!$frase){
                $this->addDados('frase', 'Um Erro inesperado aconteceu, mas nn se preocupe Quase tudo está em ordem. Mas entre em contato cmg! [ERSENTENCE]');
                $this->addDados('autor', 'Felipe Assunção');
            }else{
                $this->addDados('frase', $frase->getDescricao());
                $this->addDados('autor', $frase->getAutor());
            }
            
            $SECURITY = SecurityHelper::getInstancia(); 
            $usuario = $SECURITY->getUsuario();
            $this->addDados('usuario', $usuario->getNome());
            $this->TView('index');
        } else {
            $_SESSION['erroLogue-se'] = true;
            RedirectorHelper::goToController('Logon');
        }
    }

}
