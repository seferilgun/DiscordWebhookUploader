-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 19 Tem 2023, 19:10:57
-- Sunucu sürümü: 10.6.11-MariaDB-cll-lve
-- PHP Sürümü: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `sinangilmakine_re`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fotograflar`
--

CREATE TABLE `fotograflar` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `fotograflar`
--

INSERT INTO `fotograflar` (`id`, `user_id`, `image_url`, `upload_date`) VALUES
(1, 1, 'https://cdn.discordapp.com/attachments/1125748819645186131/1130962428449013851/Adsz_1024_1024_piksel.png', '2023-07-18 20:40:48'),
(2, 1, 'https://cdn.discordapp.com/attachments/1125748819645186131/1130962554848563240/Adsz_1024_1024_piksel.png', '2023-07-18 20:41:18'),
(3, 1, 'https://cdn.discordapp.com/attachments/1125748819645186131/1130963729064927392/Adsz_1024_1024_piksel.png', '2023-07-18 20:45:58'),
(4, 1, 'https://cdn.discordapp.com/attachments/1125748819645186131/1130963861332304033/Adsz_1024_1024_piksel.png', '2023-07-18 20:46:29'),
(5, 1, 'https://cdn.discordapp.com/attachments/1125748819645186131/1130963881666285788/Adsz_1024_1024_piksel.png', '2023-07-18 20:46:34'),
(6, 1, 'https://cdn.discordapp.com/attachments/1125748819645186131/1130963988625244160/Adsz_1024_1024_piksel.png', '2023-07-18 20:47:00'),
(7, 1, 'https://cdn.discordapp.com/attachments/1125748819645186131/1130964021709914122/Black_And_White_Business_Logo.png', '2023-07-18 20:47:07'),
(8, 1, 'https://cdn.discordapp.com/attachments/1125748819645186131/1130964621617017024/Black_And_White_Business_Logo.png', '2023-07-18 20:49:30'),
(9, 1, 'https://cdn.discordapp.com/attachments/1125748819645186131/1130964748561829918/Black_And_White_Business_Logo.png', '2023-07-18 20:50:01'),
(10, 1, 'https://cdn.discordapp.com/attachments/1125748819645186131/1130966032509571173/Adsz_1024_1024_piksel.png', '2023-07-18 20:55:07'),
(11, 1, 'https://cdn.discordapp.com/attachments/1125748819645186131/1131097842690314292/Adsz_1024_1024_piksel_1.png', '2023-07-19 05:38:53');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'test', 'test1@test.com', 'test1'),
(2, 'carlos', 'carlos@carlos.com', 'carlos'),
(3, 'ali', 'ali@gmail.com', 'ali'),
(4, 'asdads', 'asda@gmail.com', 'asdasd'),
(5, 'testetr', 'ssssgks@gmail.com', 'safsdf');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `fotograflar`
--
ALTER TABLE `fotograflar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `fotograflar`
--
ALTER TABLE `fotograflar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `fotograflar`
--
ALTER TABLE `fotograflar`
  ADD CONSTRAINT `fotograflar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
