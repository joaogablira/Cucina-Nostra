-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Mar-2026 às 16:28
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cucina_nostra`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Massas'),
(2, 'Pizzas'),
(3, 'Doces'),
(4, 'Carnes');

-- --------------------------------------------------------

--
-- Estrutura da tabela `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `ingredients` text NOT NULL,
  `preparation` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `category_id`, `title`, `ingredients`, `preparation`, `image_url`, `status`, `created_at`) VALUES
(2, 3, 1, 'Linguini al Pesto Genovese (Especial do Chef)', '500g de massa tipo Linguini\n2 maços de manjericão fresco\n50g de pinolis (ou nozes/castanhas)\n50g de queijo Parmigiano-Reggiano\n50g de queijo Pecorino\n2 dentes de alho\n1 xícara de azeite extra virgem\nSal grosso', '1. No pilão (ou processador), amasse o alho com um pouco de sal grosso.\n2. Adicione as folhas de manjericão e continue amassando delicadamente.\n3. Junte os pinolis e os queijos ralados.\n4. Vá adicionando o azeite aos poucos até formar um creme verde lindo e aromático.\n5. Cozinhe o Linguini al dente, escorra (reserve um pouco da água) e misture com o pesto fora do fogo. \n6. Sirva com um ratinho debaixo do chapéu... ops, digo, com muito parmesão por cima!', 'https://images.unsplash.com/photo-1595295333158-4742f28fbd85?auto=format&fit=crop&w=800&q=80', 'pending', '2026-03-10 20:46:05'),
(3, 3, 1, 'Spaghetti à Carbonara', '400g de spaghetti\n150g de guanciale ou bacon\n4 gemas de ovo\n100g de queijo pecorino\nPimenta do reino', 'Frite o bacon até dourar. Misture as gemas com o queijo e a pimenta. Cozinhe a massa, junte ao bacon e, com o fogo desligado, adicione o creme de ovos. Misture rápido para não cozinhar o ovo.', 'assets/img/cozinhando.jpg', 'approved', '2026-03-11 08:24:38'),
(4, 3, 1, 'Lasanha à Bolonhesa', '500g de massa de lasanha\n500g de carne moída\nMolho de tomate rústico\n300g de queijo muçarela', 'Faça um molho bolonhesa encorpado. Em uma travessa, intercale: molho, massa, carne e queijo. Termine com bastante queijo e asse por 40 minutos a 200°C.', 'assets/img/cozinhando.jpg', 'approved', '2026-03-11 08:24:38'),
(5, 3, 2, 'Pizza Margherita Clássica', 'Massa de fermentação natural\nMolho de tomate pelati\nMuçarela de búfala\nFolhas de manjericão fresco', 'Abra a massa com as mãos. Espalhe uma concha de molho. Distribua a muçarela rasgada e leve ao forno na temperatura máxima. Finalize com o manjericão e azeite.', 'assets/img/cozinhando.jpg', 'approved', '2026-03-11 08:24:38'),
(6, 3, 2, 'Pizza de Pepperoni', 'Massa de pizza\nMolho de tomate\nMuçarela ralada\nFatias de pepperoni', 'Espalhe o molho sobre a massa, cubra com uma camada generosa de queijo muçarela e distribua as fatias de pepperoni. Asse até o pepperoni ficar crocante nas bordas.', 'assets/img/cozinhando.jpg', 'approved', '2026-03-11 08:24:38'),
(7, 3, 3, 'Tiramisù Tradicional', 'Biscoito champanhe\nCafé expresso forte\n500g de queijo Mascarpone\n3 gemas e açúcar\nCacau em pó', 'Bata as gemas com açúcar e misture ao mascarpone. Mergulhe os biscoitos no café rapidamente. Monte em camadas de biscoito e creme. Gele por 4 horas e polvilhe cacau.', 'assets/img/cozinhando.jpg', 'approved', '2026-03-11 08:24:38'),
(8, 3, 3, 'Cannoli Siciliano', 'Massa frita em formato de tubo\nRicota fresca escorrida\nAçúcar de confeiteiro\nGotas de chocolate', 'Misture a ricota com o açúcar e as gotas de chocolate até formar um creme firme. Coloque em um saco de confeitar e recheie os tubos de massa apenas na hora de servir.', 'assets/img/cozinhando.jpg', 'approved', '2026-03-11 08:24:38'),
(9, 3, 4, 'Bife à Parmegiana', '4 bifes de alcatra\nFarinha de trigo e rosca para empanar\nMolho de tomate\nMuçarela fatiada', 'Tempere os bifes, passe na farinha de trigo, no ovo e na farinha de rosca. Frite em óleo quente. Coloque em uma assadeira, cubra com molho, bastante queijo e gratine no forno.', 'assets/img/cozinhando.jpg', 'approved', '2026-03-11 08:24:38'),
(10, 3, 4, 'Ossobuco com Polenta', '4 pedaços de ossobuco de vitelo\nVinho tinto\nCenoura, cebola e aipo\nPolenta cremosa', 'Sele a carne na panela. Adicione os legumes picados e o vinho. Deixe cozinhar em fogo muito baixo por 3 horas até a carne desmanchar. Sirva sobre a polenta cremosa.', 'assets/img/cozinhando.jpg', 'approved', '2026-03-11 08:24:38'),
(11, 4, 4, 'Carne de Joãozinho', 'Joãozinho e temperos a seu gosto', 'Joga tudo na panela com óleo', 'assets/img/uploads/69b15b8fd474a.jpg', 'pending', '2026-03-11 12:09:51'),
(12, 5, 2, 'Sopa de Pedra', '500g de Brita triturada\r\n250g de Mármore Carrara em blocos\r\n2l de água do Rio Tietê\r\nSal a gosto \r\nPó de Paralelepípedo a gosto', 'Refogue a Brita com cebola e azeite, em seguida adicione o mármore e deixe até dourar. tempere com seus temperos favoritos (paralelepípedo fica bom) e se deleite com a receita.', 'assets/img/uploads/69b15d140aa1f.png', 'pending', '2026-03-11 12:16:20'),
(13, 6, 4, '2', 'sei lá', '1 taca tudo na panela', 'assets/img/uploads/69b15fa3b0069.avif', 'pending', '2026-03-11 12:27:15');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bio` text DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT 'assets/img/default-avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `bio`, `profile_pic`) VALUES
(1, 'jg', 'jg@gmail.com', '1234', '2026-03-03 20:44:22', NULL, 'assets/img/default-avatar.png'),
(3, 'Chef Linguini', 'linguini@gusteau.com', '$2y$10$ekxYGrGIqfAF7SuDFAI6W.UkXt4lU.25dmkL4lwk1NgMw2RFMbs6q', '2026-03-10 20:37:28', 'Cuidado com os ratão\' e parceiro do melhor cozinheiro de Paris.', 'assets/img/cozinhando.jpg'),
(4, 'Suzuki_Suzumee', 'suzukas@gmail.com', '$2y$10$Sel8JTimzTXh9zbxIGYxxuXlkxz0eGLmhKEuMhWEWzxVO9SWrovmS', '2026-03-11 12:03:59', 'Mestre da culinária brasileira/chinesa/italiana', 'assets/img/uploads/user_4_69b15b1d03107.jpg'),
(5, 'Sr. Locks (usted)', 'locks@ggmail.com', '$2y$10$zzpcghkk3rNR86xhJlFIEOhI3Kpr4YZKsUDYk//0fLd8Tct8Hheu2', '2026-03-11 12:11:43', NULL, 'assets/img/default-avatar.png'),
(6, 'teste', 'teste@gmail.com', '$2y$10$VDpmBc4xlG.PYDRyA23wGuW0Irwq5jqjFk5PYjLkjUpOEmcXxqMh.', '2026-03-11 12:25:52', 'Este é meu TCC', 'assets/img/uploads/user_6_69b179076405c.avif');

-- --------------------------------------------------------

--
-- Estrutura da tabela `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `voted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `recipe_id`, `voted_at`) VALUES
(1, 4, 11, '2026-03-11 12:10:00'),
(3, 5, 12, '2026-03-11 12:16:32'),
(5, 6, 13, '2026-03-11 14:16:04');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`recipe_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `recipes_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Limitadores para a tabela `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
