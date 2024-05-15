-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2024 a las 17:29:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `2melody`
--

--
-- Volcado de datos para la tabla `artista`
--

INSERT INTO `artista` (`id_artista`, `archivado`) VALUES
('bad_bunny', 0),
('direS', 0),
('Eagles', 0),
('icecube', 0),
('jamiroquai', 0),
('Mozart', 0),
('skrillex', 0);

--
-- Volcado de datos para la tabla `cancion`
--

INSERT INTO `cancion` (`id_cancion`, `titulo`, `imagen`, `fecha`, `id_artista`, `likes`, `ruta`, `tags`) VALUES
(1, 'Me fui de vacaciones', 'Un verano sin ti.png', '2019-07-01', 'bad_bunny', 0, '6644a8b20c4ec.mp3', 'Reggaeton'),
(2, 'Titi me preguntó', 'Un verano sin ti.png', '2019-07-01', 'bad_bunny', 1, '6644ac9615789.mp3', 'Reggaeton'),
(4, 'Sultans Of Swing', 'Sultans Of Swing.jpg', '1978-01-01', 'direS', 0, '6644ad7d6c1c0.mp3', 'Rock'),
(5, 'You know how we do it', 'Lethal Injection.jpg', '1978-01-01', 'icecube', 0, '6644aed979df0.mp3', 'Hip'),
(6, 'Hotel California', 'Hotel California.jpg', '1976-12-08', 'Eagles', 0, '6644afd0a71b2.mp3', 'Rock'),
(7, 'Virtual Insanity', 'Travelling without moving.jpg', '1996-08-28', 'jamiroquai', 0, '6644b07dd4dbd.mp3', 'Disco'),
(8, 'Bangarang', 'Bangarang.jpg', '2011-12-23', 'skrillex', 0, '6644b1125ff70.mp3', 'Dubstep'),
(9, 'Concierto Piano Orquesta Mov 1', 'Concierto Piano Orquesta 20 D Minor.jpg', '1785-01-01', 'Mozart', 0, '6644b1d356023.mp3', 'Clásica');

--
-- Volcado de datos para la tabla `cancionfav`
--

INSERT INTO `cancionfav` (`id_cancion`, `id_user`) VALUES
(2, 'bad_bunny');

--
-- Volcado de datos para la tabla `playlist`
--

INSERT INTO `playlist` (`id_playlist`, `id_user`, `imagen`, `nombre`, `fecha`) VALUES
(2, 'user1', 'playlist_fav.png', 'Favoritos', '2024-05-15'),
(3, 'user2', 'playlist_fav.png', 'Favoritos', '2024-05-15'),
(4, 'user3', 'playlist_fav.png', 'Favoritos', '2024-05-15'),
(5, 'user4', 'playlist_fav.png', 'Favoritos', '2024-05-15'),
(6, 'admin', 'playlist_fav.png', 'Favoritos', '2024-05-15'),
(7, 'bad_bunny', 'Un verano sin ti.png', 'Un verano sin ti', '2019-07-01'),
(8, 'direS', 'Sultans Of Swing.jpg', 'Sultans Of Swing', '1978-01-01'),
(9, 'icecube', 'Lethal Injection.jpg', 'Lethal Injection', '1978-01-01'),
(10, 'Eagles', 'Hotel California.jpg', 'Hotel California', '1976-12-08'),
(11, 'jamiroquai', 'Travelling without moving.jpg', 'Travelling without moving', '1996-08-28'),
(12, 'skrillex', 'Bangarang.jpg', 'Bangarang', '2011-12-23'),
(13, 'Mozart', 'Concierto Piano Orquesta 20 D Minor.jpg', 'Concierto Piano Orquesta 20 D Minor', '1785-01-01');

--
-- Volcado de datos para la tabla `play_cancion`
--

INSERT INTO `play_cancion` (`id_playlist`, `id_cancion`) VALUES
(7, 1),
(7, 2),
(8, 4),
(9, 5),
(10, 6),
(11, 7),
(12, 8),
(13, 9);

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id_post`, `id_user`, `texto`, `imagen`, `likes`, `origen`, `tags`, `fecha`) VALUES
(8, 'user1', 'Alguna recomendación de musica??😋', 'NULL', 0, NULL, '', '2024-05-15'),
(9, 'user2', 'No se que poner por aquí', 'NULL', 0, NULL, '', '2024-05-15'),
(15, 'user2', 'El cucho', '6644cf2383d6d.jpg', 0, NULL, '', '2024-05-15'),
(18, 'user3', 'Buenos dias, que Dios os bendiga a todos', '6644d10bcfa08.jpg', 0, NULL, '', '2024-05-15');

--
-- Volcado de datos para la tabla `seguidores`
--

INSERT INTO `seguidores` (`id_user`, `id_seguidor`) VALUES
('bad_bunny', 'user2'),
('user1', 'user3'),
('user2', 'user1'),
('user2', 'user3'),
('user3', 'user1'),
('user3', 'user2'),
('user4', 'user1');

--
-- Volcado de datos para la tabla `suscripcion`
--

INSERT INTO `suscripcion` (`id_user`, `tipo`, `fecha_fin`, `archivado`) VALUES
('bad_bunny', 'prueba', '2024-05-15 15:59:16', NULL);

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_user`, `nickname`, `password`, `foto`, `descripcion`, `karma`, `fecha`, `correo`, `admin`) VALUES
('admin', 'admin', '$2y$10$QfAEJM0JlHfQo8vUJzGhsevdw5d19jPr8Anr.dvwKyJFERzEFY0ze', 'FotoPerfil.png', '', 0, '1990-01-01', 'admin@gmail.com', 1),
('bad_bunny', 'Bad Bunny', '$2y$10$h58nkhB3VweRSCSgjMdchuNMv6sLriS0nHIW7L4Otu0ZcH3BaIm.W', 'bad_bunny.jpg', '', 1, '1994-03-10', 'badbunny@gmail.com', 0),
('direS', 'dire straits', '$2y$10$z.M2mFRqj/sGHfGYxxNNJ.2EyOa.cCrrAqFSss91LJo8IRWkcW3o6', 'direS.jpg', '', 0, '1990-01-01', 'direstraits@gmail.com', 0),
('Eagles', 'Eagles', '$2y$10$b8xmdcYaAVRdIM1ArM17F.NeohAlIuW5YzfV0V57RIvYyWRrzXZSe', 'Eagles.jpg', '', 0, '1990-01-01', 'eagles@gmail.com', 0),
('icecube', 'IceCube', '$2y$10$QhoTwHc7cuJE./sRi8ZX7ujljPXatDReHNK5ocE8SWgmHzVjhvxp.', 'icecube.jpg', '', 0, '1990-01-01', 'icecube@gmail.com', 0),
('jamiroquai', 'jamiroquai', '$2y$10$srFYodSt0wrKwz3oUYJgPO03HlV/WPAL3V6UOOrRPplCS.mxcxb6i', 'jamiroquai.png', '', 0, '1990-01-01', 'jamiroquai@gmail.com', 0),
('Mozart', 'W.A Mozart', '$2y$10$jFbTYsuYsoZDwUR0sJaz.uI0wT2bEqY2wGwAnOGD0rnqtRrJxxeSm', 'Mozart.jpg', '', 0, '1770-01-01', 'mozart@gmail.com', 0),
('skrillex', 'skrillex', '$2y$10$LMqU7g52Rjdy0Gogv6vEqOyORLvvk9oXvHQ78Wg0nplP4U6GVv5N.', 'skrillex.png', '', 0, '2000-01-01', 'skrillex@gmail.com', 0),
('user1', 'usuario1', '$2y$10$g04E4EX/k.6V.iRBeDT/SeUjad9nbVK1ljfDS0zGKq71TXlM8tk.e', 'user1.jpg', '', 1400, '2001-01-01', 'user1@gmail.com', 0),
('user2', 'usuario2', '$2y$10$TE5N3zjZL9TtP8YU.GV2Ke3OrXPY1yQCkwihLRsx5Hns8Rydi0IyO', 'user2.png', '', 0, '2002-02-02', 'user2@gmail.com', 0),
('user3', 'usuario3', '$2y$10$WOCU76J1/izTEHCrF915J.lL1KKxrmRg1qj0EDpF3viORf18h3eoq', 'user3.jpg', '', 0, '2003-03-03', 'user3@gmail.com', 0),
('user4', 'usuario4', '$2y$10$61rTW9moQAhtYRnDDVs3kuxxywezQep/D8SBeplSJQNj1vmIBlWwq', 'FotoPerfil.png', '', 0, '2000-04-04', 'user4@gmail.com', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
