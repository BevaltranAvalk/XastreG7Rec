-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 26-Jun-2023 às 22:04
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id`, `nome_comercial`, `descricao`, `carga_horaria`, `dat_ini`, `dat_fim`, `qtd_max`) VALUES
(12, 'Matemática Básica', 'Curso introdutório que abrange os conceitos fundamentais da matemática, incluindo aritmética, álgebra e geometria.', '02:00:00', '2023-06-08', '2023-06-30', 2000),
(13, 'Língua Inglesa para Iniciantes', 'Curso de introdução ao inglês, que cobre vocabulário básico, gramática e habilidades de conversação.', '04:00:00', '2023-06-07', '2023-07-07', 2000),
(14, 'Introdução à Programação', 'Curso que ensina os conceitos básicos de programação, incluindo lógica de programação e estruturas de controle.', '02:00:00', '2023-06-08', '2023-07-01', 3000),
(15, 'Introdução à Economia', 'Curso introdutório que explora os princípios básicos da economia, incluindo oferta e demanda, mercado e políticas econômicas.', '03:00:00', '2023-06-13', '2023-06-30', 2000),
(16, 'Introdução à Arte', 'Curso que explora os fundamentos da arte, incluindo os principais movimentos artísticos, técnicas e apreciação artística.', '04:00:00', '2023-06-09', '2023-07-07', 3000);

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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `quiz`
--

INSERT INTO `quiz` (`pergunta`, `resposta_correta`, `resposta1`, `resposta2`, `id`, `curso_id`) VALUES
('Qual é a cor do céu em um dia ensolarado?', 'Azul', 'Amarelo', 'Verd', 4, 2),
('Qual a raiz quadrada de 9', '3', '2', '67', 8, 12),
('Qual galaxia fica a terra?', 'Via Lactea', 'Venus', 'Cytron-086', 14, 2),
('Qual é a capital do Brasil?', 'Brasília', 'Rio de Janeiro', 'São Paulo', 16, NULL),
('Quem descobriu o Brasil?', 'Pedro Álvares Cabral', 'Cristóvão Colombo', 'Fernão de Magalhães', 17, NULL),
('Quanto é 2 + 2?', '4', '3', '5', 18, 12),
('Quem pintou a Mona Lisa?', 'Leonardo da Vinci', 'Pablo Picasso', 'Vincent van Gogh', 19, NULL),
('Qual é o maior planeta do Sistema Solar?', 'Júpiter', 'Saturno', 'Marte', 20, NULL),
('Qual é a fórmula química da água?', 'H2O', 'CO2', 'NaCl', 24, NULL),
('Qual é a montanha mais alta do mundo?', 'Monte Everest', 'Monte Kilimanjaro', 'Monte Fuji', 26, NULL),
('Qual é o rio mais longo do mundo?', 'Rio Nilo', 'Rio Amazonas', 'Rio Yangtzé', 28, NULL),
('Quem foi o cientista que formulou a Teoria da Relatividade?', 'Albert Einstein', 'Isaac Newton', 'Galileu Galilei', 29, NULL),
('O que significa HTML?', 'HyperText Markup Language', 'Hyperlinks and Text Markup Language', 'Home Tool Markup Language', 31, 14),
('Qual é a linguagem de programação mais popular?', 'JavaScript', 'Python', 'Java', 32, 14),
('O que é CSS?', 'Cascading Style Sheets', 'Creative Style Sheets', 'Computer Style Sheets', 33, 14),
('Qual é o símbolo usado para comentários em JavaScript?', '//', '/* */', '#', 34, 14),
('O que é um loop em programação?', 'Uma estrutura de controle para repetir um bloco de código', 'Um tipo de dado', 'Uma função matemática', 35, 14);

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
  `aptidao` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `idx_usuarios_ID` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`ID`, `SENHA`, `CARGO`, `email`, `curso_atual`, `vaga_id`, `aptidao`) VALUES
(1, '12345', 'aluno', 'aluno@gmail.com', '', 1, 0),
(2, '12345', 'mentor', 'mentor@mentor.com', '', 0, 0),
(3, '12345', 'empresa', 'empresa@empresa.com', '', 0, 0),
(4, '12345', 'admin', 'admin@admin.com', '', 0, 0);

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
  `id_curso` int DEFAULT NULL,
  `id_empresa` int NOT NULL,
  PRIMARY KEY (`id_vaga`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `vagas`
--

INSERT INTO `vagas` (`titulo`, `empresa`, `descricao`, `faixa_salarial`, `requisitos`, `id_vaga`, `id_curso`, `id_empresa`) VALUES
('Programador', 'Bayer', 'Trabalho em front_end e home office', 2000, '2 anos de experienci', 1, 14, 3),
('Programador_senior', 'Bayer', 'Vaga de Programador Senior para a bayer', 3000, 'Cconhecmineto', 8, 14, 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
