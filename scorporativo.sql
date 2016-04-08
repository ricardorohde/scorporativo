-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2016 at 12:04 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `sc_acessos`
--

INSERT INTO `sc_acessos` (`id`, `data_cadastro`, `usuario`, `ip`) VALUES
(1, '2016-02-09 17:28:45', 'admin', '::1'),
(2, '2016-02-09 17:29:25', 'admin', '::1'),
(3, '2016-02-09 17:31:59', 'admin', '::1'),
(4, '2016-02-09 17:32:48', 'admin', '::1'),
(5, '2016-02-09 17:34:43', 'admin', '::1'),
(6, '2016-02-09 17:35:27', 'admin', '::1'),
(7, '2016-02-09 17:36:10', 'admin', '::1'),
(8, '2016-02-09 17:36:14', 'admin', '::1'),
(9, '2016-02-09 17:36:29', 'admin', '::1'),
(10, '2016-02-09 17:37:58', 'admin', '::1'),
(11, '2016-02-09 17:38:20', 'admin', '::1'),
(12, '2016-02-09 17:38:30', 'admin', '::1'),
(13, '2016-02-09 17:38:40', 'admin', '::1'),
(14, '2016-02-09 17:38:47', 'admin', '::1'),
(15, '2016-02-09 17:39:26', 'admin', '::1'),
(16, '2016-02-09 17:39:38', 'admin', '::1'),
(17, '2016-02-09 17:42:57', 'admin', '::1'),
(18, '2016-02-09 17:53:32', 'muller.guilherme@gmail.com', '::1'),
(19, '2016-02-09 17:53:51', 'muller.guilherme@gmail.com', '::1'),
(20, '2016-02-09 17:54:14', 'muller.guilherme@gmail.com', '::1'),
(21, '2016-02-09 17:54:26', 'muller.guilherme@gmail.com', '::1'),
(22, '2016-02-09 17:59:55', 'muller.guilherme@gmail.com', '::1'),
(23, '2016-02-19 19:49:04', 'admin', '::1'),
(24, '2016-04-08 10:00:22', 'admin', '::1'),
(25, '2016-04-08 10:03:51', 'muller.guilherme@gmail.com', '::1');

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
  `ativo` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  KEY `nivel` (`nivel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sc_adm`
--

INSERT INTO `sc_adm` (`id`, `nome`, `login`, `senha`, `salt`, `nivel`, `ativo`) VALUES
(1, 'Administrador', 'admin', '97ac7d540b3e20ce0c8c14120b801bfded2ab5fc', '0.67589800 1437499538', 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sc_clientes`
--

INSERT INTO `sc_clientes` (`id`, `data_cadastro`, `tipo`, `nome`, `email`) VALUES
(1, '2016-02-09 17:52:30', 'fisica', 'Guilherme Müller', 'muller.guilherme@gmail.com');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sc_imagens`
--

INSERT INTO `sc_imagens` (`id`, `data_cadastro`, `mini`, `thumb`, `med`, `big`, `mini_2x`, `thumb_2x`, `med_2x`, `big_2x`, `ordem`, `obj_id`, `obj_tipo`, `legenda`, `categoria_id`, `link`) VALUES
(1, '2016-02-19 19:50:58', NULL, NULL, 'slide_92a5fa6eefe1578eb54a7f67e7ebab98.jpg', NULL, NULL, NULL, NULL, NULL, 2, 0, 'slide', '', NULL, ''),
(2, '2016-02-19 19:51:06', NULL, NULL, 'slide_ae8d84004205f814b59d8f98d1b7e0da.jpg', NULL, NULL, NULL, NULL, NULL, 1, 0, 'slide', '', NULL, '');

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
(6, 'Rodapé - Coluna Esquerda', 'Rodapé - Coluna Esquerda', 'rodape_esq', '<p>email@email.com.br 41 3333-4444</p>', NULL, 0, 0, 'padrao', 0, 1, 1),
(7, 'Rodapé - Coluna Direita', 'Rodapé - Coluna Direita', 'rodape_dir', '<p>Rua Teste, 123 <br /> Curitiba, PR <br /> 80000-000</p>', NULL, 0, 0, 'padrao', 0, 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sc_usuarios`
--

INSERT INTO `sc_usuarios` (`id`, `rel_id`, `data_cadastro`, `nome`, `tipo`, `email`, `senha`, `salt`, `ativo`, `nivel`) VALUES
(1, 1, '2016-02-09 17:52:30', 'Guilherme Müller', 'cliente', 'muller.guilherme@gmail.com', '3fe4de2a4f4f169a1a24b1f1cf70cb52af17e676', '0.59539100 1455040350', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
