-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 20-Jun-2023 às 12:50
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `login`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

DROP TABLE IF EXISTS `curso`;
CREATE TABLE IF NOT EXISTS `curso` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_comercial` varchar(30) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `carga_horaria` time NOT NULL,
  `dat_ini` date NOT NULL,
  `dat_fim` date NOT NULL,
  `qtd_max` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id`, `nome_comercial`, `descricao`, `carga_horaria`, `dat_ini`, `dat_fim`, `qtd_max`) VALUES
(2, 'portugues', 'curso sobre portuges', '02:30:00', '2023-06-16', '2023-06-22', 200),
(4, 'matematica basica', 'Matematica básica', '02:00:00', '2023-06-16', '2023-06-30', 200);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notas`
--

DROP TABLE IF EXISTS `notas`;
CREATE TABLE IF NOT EXISTS `notas` (
  `nota` int NOT NULL,
  `id_aluno` int NOT NULL,
  `id_curso` int NOT NULL,
  `id_nota` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_nota`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `notas`
--

INSERT INTO `notas` (`nota`, `id_aluno`, `id_curso`, `id_nota`) VALUES
(8, 11, 2, 10),
(8, 1, 2, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `pergunta` varchar(255) DEFAULT NULL,
  `resposta_correta` varchar(255) DEFAULT NULL,
  `resposta1` varchar(255) DEFAULT NULL,
  `resposta2` varchar(255) DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `curso_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `quiz`
--

INSERT INTO `quiz` (`pergunta`, `resposta_correta`, `resposta1`, `resposta2`, `id`, `curso_id`) VALUES
('Quem pintou a Mona Lisa?', 'Leonardo da Vinci', 'Vincent van Gogh', 'Pablo Picasso', 3, 2),
('Qual é a cor do céu em um dia ensolarado?', 'Azul', 'Amarelo', 'Verd', 4, 2),
('Quanto é 2+2', '4', '5', '6', 7, 7),
('Qual a raiz quadrada de 9', '3', '2', '67', 8, 7),
('Qual o nome da capital do Maranhão', 'São Luis', 'Amapa', 'Rondonia', 9, 2),
('Qual galaxia fica a terra?', 'Via Lactea', 'Venus', 'Cytron-086', 14, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `SENHA` varchar(20) DEFAULT NULL,
  `CARGO` varchar(9) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `curso_atual` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `vaga_id` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `idx_usuarios_ID` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`ID`, `SENHA`, `CARGO`, `email`, `curso_atual`, `vaga_id`) VALUES
(1, '12345', 'aluno', 'aluno@gmail.com', '2', 1),
(2, '12345', 'mentor', 'mentor@mentor.com', '', 0),
(3, '12345', 'empresa', 'empresa@empresa.com', '', 0),
(4, '12345', 'admin', 'admin@admin.com', '', 0),
(10, '12345', 'admin', 'may@admin.com', '', 0),
(11, '12345', 'aluno', 'mayrongermann@gmail.com', '2', 0),
(12, '12345', 'admin', 'mayron@admin.com', '', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vagas`
--

DROP TABLE IF EXISTS `vagas`;
CREATE TABLE IF NOT EXISTS `vagas` (
  `titulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `empresa` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `descricao` varchar(300) DEFAULT NULL,
  `faixa_salarial` int DEFAULT NULL,
  `requisitos` varchar(20) DEFAULT NULL,
  `id_vaga` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_vaga`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `vagas`
--

INSERT INTO `vagas` (`titulo`, `empresa`, `descricao`, `faixa_salarial`, `requisitos`, `id_vaga`) VALUES
('Programador', 'Bayer', 'Trabalho em front_end e home office', 2000, '2 anos de experienci', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
