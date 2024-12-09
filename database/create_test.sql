-- Estructura de tabla para la tabla `images`
--
CREATE DATABASE ff5images_test;
USE ff5images_test;

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

INSERT INTO `images` (`id`, `title`, `path`) VALUES
(2, 'hola', 'uploads/1733706143_image1.jpg'),
(3, 'hola', 'uploads/1733706184_image1.jpg'),
(4, 'hola', 'uploads/1733706186_image1.jpg'),
(5, 'hola', 'uploads/1733706188_image1.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
