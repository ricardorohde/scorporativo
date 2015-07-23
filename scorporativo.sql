-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2015 at 11:19 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `scorporativo`
--

-- --------------------------------------------------------

--
-- Table structure for table `sc_acessos`
--

CREATE TABLE IF NOT EXISTS `sc_acessos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` varchar(100) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sc_adm`
--

CREATE TABLE IF NOT EXISTS `sc_adm` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `login` varchar(30) NOT NULL,
  `senha` char(40) NOT NULL,
  `salt` char(21) NOT NULL,
  `nivel` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `bloqueado` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  KEY `nivel` (`nivel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sc_adm`
--

INSERT INTO `sc_adm` (`id`, `nome`, `login`, `senha`, `salt`, `nivel`, `bloqueado`) VALUES
(1, 'Administrador', 'admin', '97ac7d540b3e20ce0c8c14120b801bfded2ab5fc', '0.67589800 1437499538', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sc_categorias`
--

CREATE TABLE IF NOT EXISTS `sc_categorias` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `tipo` varchar(30) NOT NULL DEFAULT 'galeria',
  `nivel` varchar(50) DEFAULT NULL,
  `mae` int(11) DEFAULT NULL,
  `ativo` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=não, 1=sim',
  `ordem` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tipo` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sc_clientes`
--

CREATE TABLE IF NOT EXISTS `sc_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` varchar(30) NOT NULL DEFAULT 'fisica',
  `nome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sc_config`
--

CREATE TABLE IF NOT EXISTS `sc_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `valor_str` varchar(200) DEFAULT NULL,
  `valor_num` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sc_conteudo`
--

CREATE TABLE IF NOT EXISTS `sc_conteudo` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titulo` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `texto` text NOT NULL,
  `categoria_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `pagina_cod` varchar(50) NOT NULL DEFAULT 'noticias',
  `ativo` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=não, 1=sim',
  PRIMARY KEY (`id`),
  KEY `e_nome` (`titulo`),
  KEY `cat_id` (`categoria_id`),
  KEY `secao_cod` (`pagina_cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sc_estados`
--

CREATE TABLE IF NOT EXISTS `sc_estados` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `sigla` char(2) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `sc_estados`
--

INSERT INTO `sc_estados` (`id`, `sigla`, `nome`) VALUES
(1, 'PR', 'Paraná'),
(2, 'SP', 'São Paulo'),
(3, 'RR', 'Roraima'),
(4, 'RO', 'Rondônia'),
(5, 'SC', 'Santa Catarina'),
(6, 'RJ', 'Rio de Janeiro'),
(7, 'RS', 'Rio Grande do Sul'),
(8, 'MG', 'Minas Gerais'),
(9, 'DF', 'Distrito Federal'),
(10, 'TO', 'Tocantins'),
(11, 'RN', 'Rio Grande do Norte'),
(12, 'PB', 'Paraíba'),
(13, 'PA', 'Pará'),
(14, 'PE', 'Pernambuco'),
(15, 'BA', 'Bahia'),
(16, 'SE', 'Sergipe'),
(17, 'MA', 'Maranhão'),
(18, 'AM', 'Amazonas'),
(19, 'AC', 'Acre'),
(20, 'MS', 'Mato Grosso do Sul'),
(21, 'MT', 'Mato Grosso'),
(22, 'CE', 'Ceará'),
(23, 'AP', 'Amapá'),
(24, 'GO', 'Goiás'),
(25, 'ES', 'Espírito Santo'),
(26, 'PI', 'Piauí'),
(27, 'AL', 'Alagoas');

-- --------------------------------------------------------

--
-- Table structure for table `sc_imagens`
--

CREATE TABLE IF NOT EXISTS `sc_imagens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mini` varchar(200) DEFAULT NULL,
  `thumb` varchar(200) DEFAULT NULL,
  `med` varchar(200) DEFAULT NULL,
  `big` varchar(200) DEFAULT NULL,
  `mini_2x` varchar(200) DEFAULT NULL,
  `thumb_2x` varchar(200) DEFAULT NULL,
  `med_2x` varchar(200) DEFAULT NULL,
  `big_2x` varchar(200) DEFAULT NULL,
  `ordem` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `obj_id` mediumint(8) unsigned NOT NULL,
  `obj_tipo` varchar(20) NOT NULL DEFAULT 'foto',
  `legenda` varchar(100) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `obj_tipo` (`obj_tipo`),
  KEY `obj_id` (`obj_id`),
  KEY `ordem` (`ordem`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sc_paginas`
--

CREATE TABLE IF NOT EXISTS `sc_paginas` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `texto` text,
  `mae` tinyint(4) DEFAULT NULL,
  `ordem` tinyint(4) NOT NULL DEFAULT '0',
  `menu` tinyint(4) NOT NULL DEFAULT '1',
  `template` varchar(50) NOT NULL DEFAULT 'padrao',
  `submenu` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'se tem submenu',
  `editavel` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=não, 1=sim',
  `ativo` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '0=não, 1=sim',
  PRIMARY KEY (`id`),
  KEY `ordem` (`ordem`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `sc_paginas`
--

INSERT INTO `sc_paginas` (`id`, `nome`, `titulo`, `codigo`, `texto`, `mae`, `ordem`, `menu`, `template`, `submenu`, `editavel`, `ativo`) VALUES
(1, 'Home', 'Home', 'home', '<p>Texto teste.</p>', NULL, 1, 1, 'padrao', 0, 0, 1),
(2, 'Quem Somos', 'Quem Somos', 'quem_somos', '', NULL, 2, 1, 'padrao', 0, 1, 1),
(4, 'Serviços', 'Serviços', 'servicos', '', NULL, 3, 1, 'padrao', 0, 1, 1),
(5, 'Contato', 'Contato', 'contato', '', NULL, 4, 1, 'padrao', 0, 1, 1),
(6, 'Rodapé - Coluna Esquerda', 'Rodapé - Coluna Esquerda', 'rodapeesq', '<p>email@email.com.br 41 3333-4444</p>', NULL, 0, 0, 'padrao', 0, 1, 1),
(7, 'Rodapé - Coluna Direita', 'Rodapé - Coluna Direita', 'rodapedir', '<p>Rua Teste, 123 <br /> Curitiba, PR <br /> 80000-000</p>', NULL, 0, 0, 'padrao', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sc_produtos`
--

CREATE TABLE IF NOT EXISTS `sc_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nome` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `descricao` text,
  `peso` float NOT NULL DEFAULT '0',
  `preco` decimal(12,2) DEFAULT NULL,
  `ativo` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sc_produtos_categorias`
--

CREATE TABLE IF NOT EXISTS `sc_produtos_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sc_sessoes`
--

CREATE TABLE IF NOT EXISTS `sc_sessoes` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sc_usuarios`
--

CREATE TABLE IF NOT EXISTS `sc_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rel_id` int(11) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nome` varchar(200) NOT NULL,
  `tipo` varchar(100) NOT NULL DEFAULT 'cliente',
  `email` varchar(100) NOT NULL,
  `senha` varchar(40) NOT NULL,
  `salt` varchar(25) NOT NULL,
  `ativo` tinyint(4) NOT NULL DEFAULT '1',
  `nivel` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `rel_id` (`rel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
