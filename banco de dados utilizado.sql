-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Jun-2021 às 20:31
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 7.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `test`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `preco`
--

CREATE TABLE `preco` (
  `IDPRECO` int(11) NOT NULL,
  `PRECO` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `preco`
--

INSERT INTO `preco` (`IDPRECO`, `PRECO`) VALUES
(1, '1.50'),
(2, '15.50'),
(3, '17.99');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `IDPROD` int(11) NOT NULL,
  `NOME` varchar(255) NOT NULL,
  `COR` varchar(255) NOT NULL,
  `IDPRECO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`IDPROD`, `NOME`, `COR`, `IDPRECO`) VALUES
(3, 'Inserir 1', 'Vermelho', 2),
(4, 'Arroz', 'Amarelo', 3);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `preco`
--
ALTER TABLE `preco`
  ADD PRIMARY KEY (`IDPRECO`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`IDPROD`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `preco`
--
ALTER TABLE `preco`
  MODIFY `IDPRECO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `IDPROD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
