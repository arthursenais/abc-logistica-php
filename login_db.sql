-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Nov-2022 às 14:12
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `login_db`
--
CREATE DATABASE IF NOT EXISTS `login_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `login_db`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `id` int(11) NOT NULL,
  `conteudo_post` text NOT NULL,
  `data_post` datetime NOT NULL,
  `postado_por` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `agendamento`
--

INSERT INTO `agendamento` (`id`, `conteudo_post`, `data_post`, `postado_por`) VALUES
(114, 'Agendamento 1 que eu criei kkk', '2022-11-18 10:15:00', 41);

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorio`
--

CREATE TABLE `relatorio` (
  `id` int(11) NOT NULL,
  `conteudo_relatorio` text NOT NULL,
  `data_relatorio` datetime NOT NULL,
  `postado_por` int(11) NOT NULL,
  `destinatario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `relatorio`
--

INSERT INTO `relatorio` (`id`, `conteudo_relatorio`, `data_relatorio`, `postado_por`, `destinatario`) VALUES
(27, 'vai tomar no meio do cu', '2022-11-18 08:32:32', 42, 40);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(128) NOT NULL,
  `cpfcnpj` varchar(128) NOT NULL,
  `hash_senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `cpfcnpj`, `hash_senha`) VALUES
(37, 'outrto2', '22222222222', '$2y$10$eW0dPHjwjwuv2j5ymiYkh.sd./9y5E4d80LDaOX4jmWh39RPyNtne'),
(40, 'Maicon', '56743218901', '$2y$10$uD.jb8/8yIa16LP.ixBQOuJExHuhOuIYMzWB4FjmDh80Dgfh6GGoC'),
(41, 'Arthur', '13130205918', '$2y$10$5M/jFqcIJbN9mXUTOfm2lOgn91ggZg4Ipo/CrV6HLOhpLOneHRohu'),
(42, 'teste', '11111111111', '$2y$10$ApV9KS5XvSw7RkT58aSs7uTPmHcyhvapRmV.YWAaALR.RL0Grjrae'),
(43, 'Arthur2', '55555555555', '$2y$10$cYGAlpfmkZJMfEk2Fin2zuQzOk87alKzSUibd2l3FqmcNjBV/FN8a');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postado_por` (`postado_por`);

--
-- Índices para tabela `relatorio`
--
ALTER TABLE `relatorio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postado_por` (`postado_por`),
  ADD KEY `destinatario` (`destinatario`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpfcnpj` (`cpfcnpj`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de tabela `relatorio`
--
ALTER TABLE `relatorio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD CONSTRAINT `agendamento_ibfk_1` FOREIGN KEY (`postado_por`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `relatorio`
--
ALTER TABLE `relatorio`
  ADD CONSTRAINT `relatorio_ibfk_1` FOREIGN KEY (`postado_por`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `relatorio_ibfk_2` FOREIGN KEY (`destinatario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
