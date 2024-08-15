-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Abr 19, 2016 as 09:39 
-- Versão do Servidor: 5.1.41
-- Versão do PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `segueme`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `canal`
--

CREATE TABLE IF NOT EXISTS `canal` (
  `idcanal` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`idcanal`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `canal`
--

INSERT INTO `canal` (`idcanal`, `descricao`) VALUES
(1, 'mobile'),
(2, 'web'),
(3, 'ambos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
  `idcomentarios` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(300) NOT NULL,
  `usuario` int(11) NOT NULL,
  `publicacao` int(11) NOT NULL,
  `data` varchar(45) NOT NULL,
  PRIMARY KEY (`idcomentarios`),
  KEY `fk_usuario_comentario_idx` (`usuario`),
  KEY `fk_publicacao_comentario_idx` (`publicacao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Extraindo dados da tabela `comentarios`
--

INSERT INTO `comentarios` (`idcomentarios`, `comentario`, `usuario`, `publicacao`, `data`) VALUES
(4, 'coment 4 ', 2, 11, '08 de Abril'),
(5, 'coment 5', 1, 11, '08 de Abril'),
(6, 'coment 6', 2, 11, '08 de Abril'),
(7, 'coment 7', 1, 11, '08 de Abril'),
(8, 'coment 8', 2, 11, '08 de Abril'),
(10, 'coment 10', 2, 11, '08 de Abril'),
(24, 'Agora eu consigo colocar mais de 30 caracteres no comentario', 1, 18, '08 de Abril'),
(40, 'Nooossa, vc Ã© o cara!', 2, 18, '09 de Abril'),
(41, 'Mais um teste apenas', 1, 18, '18 de Abril');

-- --------------------------------------------------------

--
-- Estrutura da tabela `curtidas`
--

CREATE TABLE IF NOT EXISTS `curtidas` (
  `idcurtidas` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) NOT NULL,
  `publicacao` int(11) NOT NULL,
  PRIMARY KEY (`idcurtidas`),
  KEY `fk_usuario_curtida_idx` (`usuario`),
  KEY `fk_publicacao_curtida_idx` (`publicacao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Extraindo dados da tabela `curtidas`
--

INSERT INTO `curtidas` (`idcurtidas`, `usuario`, `publicacao`) VALUES
(4, 2, 11),
(11, 1, 17),
(21, 2, 18),
(22, 1, 18),
(23, 1, 16),
(25, 1, 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `frases`
--

CREATE TABLE IF NOT EXISTS `frases` (
  `idfrases` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(300) NOT NULL,
  `diasemana` varchar(45) NOT NULL,
  `autor` varchar(45) NOT NULL,
  PRIMARY KEY (`idfrases`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `frases`
--

INSERT INTO `frases` (`idfrases`, `descricao`, `diasemana`, `autor`) VALUES
(1, 'Que sejamos um batalhão de Amor!', 'Domingo', 'Segue-me'),
(2, 'Ninguém pode dizer que me segue se não obedece aos mandamentos da Lei de meu Pai', 'Segunda', 'Jesus Cristo'),
(3, 'O homem não pode receber coisa alguma, se não lhe for dada do céu.', 'Terça', 'João Batista'),
(4, 'Este é o meu mandamento: amai-vos uns aos outros, como eu vos amo.', 'Quarta', 'Jesus Cristo (Jo, 15:12)'),
(5, 'Feliz o homem que não procede conforme o conselho dos ímpios, não trilha o caminho dos pecadores, nem se assenta entre os escarnecedores.', 'Quinta', 'Salmos 1:1'),
(6, 'Se alguém quer vir após mim, negue-se a si mesmo, tome a sua cruz, e siga-me.', 'Sexta', 'Jesus Cristo (Lc, 9:23)'),
(7, 'Queridos jovens, regressando às suas casas, não tenham medo de ser generosos com Cristo, de testemunhar o seu Evangelho.', 'Sabado', 'Papa Francisco');

-- --------------------------------------------------------

--
-- Estrutura da tabela `hierarquia`
--

CREATE TABLE IF NOT EXISTS `hierarquia` (
  `idhierarquia` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`idhierarquia`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `hierarquia`
--

INSERT INTO `hierarquia` (`idhierarquia`, `descricao`) VALUES
(1, 'Primo(a)'),
(2, 'Tio(a)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `publicacao`
--

CREATE TABLE IF NOT EXISTS `publicacao` (
  `idpublicacao` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) NOT NULL,
  `descricao` varchar(400) NOT NULL,
  `url_img` varchar(500) DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `canal` int(11) NOT NULL,
  `data` varchar(45) NOT NULL,
  PRIMARY KEY (`idpublicacao`),
  KEY `fk_usuario_publicacao_idx` (`usuario`),
  KEY `fk_canal_publicacao_idx` (`canal`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Extraindo dados da tabela `publicacao`
--

INSERT INTO `publicacao` (`idpublicacao`, `titulo`, `descricao`, `url_img`, `usuario`, `canal`, `data`) VALUES
(1, 'Via Sacra - 2016', 'E Nessa Sexta- feira somos os convidados e responsÃ¡veis pela a Via Sacra , esperamos por todos de Camisa amarela . Vamos vivÃªncia mais esse momento com o Nosso Senhor Jesus Cristo . \r\nâ€ª#â€ŽSouSeguidorâ€¬ â€ª#â€ŽSouFrutoDoAmorDeDeusâ€¬', 'http://localhost/SeguememdSistema/public/images/posts/0aa3ad0c3cf7b3115cac57c6b73b056e.jpg', 3, 1, '01 de Abril de 2016'),
(5, 'Paixao de Cristo - 3 Dias', 'SÃ³ 3 dias gente!!!\r\nChega sexta-feira santa...\r\nâ€ª#â€ŽPaixÃ£oDeCristo2016â€¬ â€ª#â€ŽSextaDaPaixÃ£oâ€¬ â€ª#â€ŽMadreDeDeusâ€¬ â€ª#â€ŽParÃ³quiaSagradaFamÃ­liaâ€¬', 'http://localhost/SeguememdSistema/public/images/posts/bdc5c94a86b49ee59fe20293dba99342.jpg', 3, 1, '01 de Abril de 2016'),
(7, 'Bom Dia ðŸ’›', 'Mas aqueles que contam com o Senhor renovam suas forÃ§as; ele dÃ¡-lhes asas de Ã¡guia. Correm sem se cansar, vÃ£o para a frente sem se fatigar. (IsaÃ­as 40, 31) BOM DIA SEGUIDOR ðŸ’›âœŒðŸ¾', 'http://localhost/SeguememdSistema/public/images/posts/padrao.jpg', 1, 1, '01 de Abril de 2016'),
(11, 'PaixÃ£o de Cristo - 2 Dias', 'Apenas 2 dias de emoÃ§Ã£o e ansiedade. \r\nVem sexta-feira, vem sexta-feira!!\r\n#PaixÃ£oDeCristo2016 #SextaDaPaixÃ£o #MadreDeDeus #ParÃ³quiaSagradaFamÃ­lia', 'http://localhost/SeguememdSistema/public/images/posts/45f98211676a43dd3e1c60dbb3d694ec.jpg', 3, 1, '01 de Abril de 2016'),
(12, 'teste 1', 'asd', 'http://localhost/SeguememdSistema/public/images/posts/padrao.jpg', 3, 1, '01 de Abril de 2016'),
(13, 'teste 2', 'asd', 'http://localhost/SeguememdSistema/public/images/posts/padrao.jpg', 3, 1, '01 de Abril de 2016'),
(14, 'teste 3', 'asd', 'http://localhost/SeguememdSistema/public/images/posts/padrao.jpg', 3, 1, '01 de Abril de 2016'),
(15, 'teste 4', 'asd', 'http://localhost/SeguememdSistema/public/images/posts/padrao.jpg', 3, 1, '01 de Abril de 2016'),
(16, 'teste 5', 'asd', 'http://localhost/SeguememdSistema/public/images/posts/padrao.jpg', 3, 1, '01 de Abril de 2016'),
(17, 'teste 6 new', 'asd', 'http://localhost/SeguememdSistema/public/images/posts/padrao.jpg', 3, 1, '02 de Abril de 2016'),
(18, 'Mensagem do Papa Franscisco!', 'Conheci um Grande Amigo, Jesus! â™«', 'http://localhost/SeguememdSistema/public/images/posts/e1298ed77805369585f744b72c8e35bc.jpg', 3, 3, '07 de Abril de 2016');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `idtipo_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`idtipo_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`idtipo_usuario`, `descricao`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `email` varchar(150) NOT NULL,
  `tipo` int(11) NOT NULL,
  `apelido` varchar(45) DEFAULT NULL,
  `senha` varchar(45) NOT NULL,
  `url_img` varchar(250) NOT NULL,
  `notificacoes` varchar(1) NOT NULL DEFAULT 'A',
  `hierarquia` int(11) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'D',
  `obs` varchar(150) DEFAULT 'Nenhuma Observação Cadastrada.',
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_tipo_usuario_idx` (`tipo`),
  KEY `fk_hierarquia_usuario_idx` (`hierarquia`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nome`, `email`, `tipo`, `apelido`, `senha`, `url_img`, `notificacoes`, `hierarquia`, `status`, `obs`) VALUES
(1, 'Felipe AssunÃ§Ã£o', 'l_assuncao@hotmail.com', 2, 'PÃ£o', 'esemsenha.00', 'http://felipeassuncao.com/curriculum/images/lheo.png', 'D', 1, 'A', 'Nenhuma Observacao Cadastrada.'),
(2, 'LheoLheps', 'rooncatto@gmail.com', 1, 'PÃ£o', 'esemsenha', 'http://3.bp.blogspot.com/_HwxB51wkeTE/THa6_MV1zvI/AAAAAAAAElw/I-QSY-TJjbw/s1600/batman-for-facebook.jpg', 'D', 2, 'A', 'Cadastrado via e-mail'),
(3, 'Segue-me', 'contato@seguememd.com.br', 2, 'Segue-me', 'senhasegueme', 'http://localhost/seguememdsistema/public/images/perfis/segueme.jpg', 'D', 2, 'A', 'Nenhuma Observacao Cadastrada.'),
(5, 'MArcos', 'bubu@sdads', 1, 'QuinhÃµ', 'sdfasd', 'http://localhost/SeguememdSistema/public/images/perfis/afb2f02fa64cf2679cf2a1e48bea1f81.jpg', 'D', 1, 'D', 'sdf'),
(12, 'Guri Oxado', 'lheolheps@outlook.com', 1, 'Bubao', 'senhafb', 'http://localhost/SeguememdSistema/public/images/perfis/03e52feefd92fd4b42c51f1ef96d6ae2.jpg', 'D', 2, 'A', 'Nenhuma Observacao Cadastrada.');

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `fk_publicacao_comentario` FOREIGN KEY (`publicacao`) REFERENCES `publicacao` (`idpublicacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_comentario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `curtidas`
--
ALTER TABLE `curtidas`
  ADD CONSTRAINT `fk_publicacao_curtida` FOREIGN KEY (`publicacao`) REFERENCES `publicacao` (`idpublicacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_curtida` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `publicacao`
--
ALTER TABLE `publicacao`
  ADD CONSTRAINT `fk_canal_publicacao` FOREIGN KEY (`canal`) REFERENCES `canal` (`idcanal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_publicacao` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_hierarquia_usuario` FOREIGN KEY (`hierarquia`) REFERENCES `hierarquia` (`idhierarquia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tipo_usuario` FOREIGN KEY (`tipo`) REFERENCES `tipo_usuario` (`idtipo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
