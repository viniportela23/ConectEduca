-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27-Jun-2023 às 20:30
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
-- Banco de dados: `usuarios`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pesquisa`
--

CREATE TABLE `pesquisa` (
  `idpesquisa` int(11) NOT NULL,
  `pergunta` text DEFAULT NULL,
  `resposta` text DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `materia` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pesquisa`
--

INSERT INTO `pesquisa` (`idpesquisa`, `pergunta`, `resposta`, `iduser`, `materia`) VALUES
(81, 'Qual foi o primeiro animal a ser enviado ao espaço?\r\n', '\n1965—Palhaço do circo \"Candido Delícia\" —which was a Brazilian clown in the\n\n1955—Primeiro animal da Raça Labrador retriever. —First Labrador\n\n1960— Primeiro animal', 17, 'matematica'),
(82, 'Por que os flamingos ficam em uma perna só?\r\n', '\nEsse hábito de ficar em uma perna só não se deve tanto ao peso, nem às criações artificiais de lagos ou de beira', 17, 'portugues'),
(83, 'Qual é o país com a maior população do mundo?\r\n', 'comentar\n22.05.2015\ndomingo\nAs autoridades asiáticas concluíram que o avião lançado este sábado, com 239', 17, 'historia'),
(84, 'Quanto tempo uma lesma pode dormir?\r\n', '\n— Faça uma fila e venha comprar. O que são estes carretos?\n\nA fila ficou menor, mais curta do que seria considerada decente.\n\n', 17, 'geografia'),
(85, 'Como os pássaros conseguem dormir em galhos sem cair?\r\n', '\n— Adoro aviários — disse Loki, deslizando pela multidão. Eu segui o felino preto até os aficionados que observavam as pessoas que enfe', 17, 'ciencias'),
(86, 'Por que as folhas das árvores mudam de cor no outono?\r\n', '\nLeipzig disse a si mesmo que tinha que ficar restrito a lugares apinhados. Em lugares onde a conversa não podia ir além de banalidades. O lugar', 17, 'fisica'),
(87, 'Qual é a maior montanha do mundo?\r\n', 'Quão perto está a maior lua do famoso?\nC) QUANDO UM INDICE\n(CARACTERÍSTICAS PESSOAS)\nRecebeu palha', 17, 'biologia'),
(88, 'aasdasdasdasdasdasdasdasdasdasdasassssssss', 'sssssssssssssssssssssssssssssssssasgggucgggugawgggaaawasgwsgagasaspc igggcgggggcgccacavgwg', 19, 'portugues');

-- --------------------------------------------------------

--
-- Estrutura da tabela `recadinhos_da_paroquia`
--

CREATE TABLE `recadinhos_da_paroquia` (
  `idrec` int(11) NOT NULL,
  `recado` text DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `recadinhos_da_paroquia`
--

INSERT INTO `recadinhos_da_paroquia` (`idrec`, `recado`, `iduser`) VALUES
(1, 'sdffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff', 17),
(2, 'sdffffffffffffffffffffffffffffffffffffffffff', 17),
(3, 'dsfsfsdfsdfsd', 19),
(4, 'dsfsfsdfsdfsd', 19);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `iduser` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha_criptografada` varchar(255) NOT NULL,
  `nivel` int(11) NOT NULL DEFAULT 1,
  `email` varchar(255) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT 'aluno'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`iduser`, `usuario`, `senha_criptografada`, `nivel`, `email`, `cargo`) VALUES
(17, 'root', '$2y$10$ZS8rv2rHVUmzNw2sCR55UuFapOdwB/0yC8W1zWaJDD6Ws6RtI0WY2', 1, NULL, 'aluno'),
(19, 'rootpro', '$2y$10$ib39H0fXVFRyOBtDXast3OXJr.7ToJazcCr6TMJ6aY3.SWsPqSCNu', 2, NULL, 'portugues');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `pesquisa`
--
ALTER TABLE `pesquisa`
  ADD PRIMARY KEY (`idpesquisa`),
  ADD KEY `iduser` (`iduser`);

--
-- Índices para tabela `recadinhos_da_paroquia`
--
ALTER TABLE `recadinhos_da_paroquia`
  ADD PRIMARY KEY (`idrec`),
  ADD KEY `iduser` (`iduser`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `pesquisa`
--
ALTER TABLE `pesquisa`
  MODIFY `idpesquisa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de tabela `recadinhos_da_paroquia`
--
ALTER TABLE `recadinhos_da_paroquia`
  MODIFY `idrec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `pesquisa`
--
ALTER TABLE `pesquisa`
  ADD CONSTRAINT `pesquisa_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `usuarios` (`iduser`);

--
-- Limitadores para a tabela `recadinhos_da_paroquia`
--
ALTER TABLE `recadinhos_da_paroquia`
  ADD CONSTRAINT `recadinhos_da_paroquia_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `usuarios` (`iduser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
