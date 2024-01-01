-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:8889
-- Üretim Zamanı: 01 Oca 2024, 17:34:18
-- Sunucu sürümü: 5.7.39
-- PHP Sürümü: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `envanter-takip`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `kullanici_id` int(90) NOT NULL,
  `kullanici_isim` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `kullanici_soyisim` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `kullanici_kullanici_adi` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `kullanici_mail` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `kullanici_sifre` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `kullanici_ise_baslangic` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `kullanici_departman` int(11) NOT NULL,
  `kullanici_rutbe` int(11) NOT NULL,
  `kullanici_yetki` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`kullanici_id`, `kullanici_isim`, `kullanici_soyisim`, `kullanici_kullanici_adi`, `kullanici_mail`, `kullanici_sifre`, `kullanici_ise_baslangic`, `kullanici_departman`, `kullanici_rutbe`, `kullanici_yetki`) VALUES
(1, 'baris', 'demirci', 'barisdemirci', 'baris19052003', 'barisbaba3', 'barisbaba', 1, 2, 3),
(2, 'baris', 'demirci', 'barisdemirci', 'baris19052003', 'barisbaba3', 'barisbaba', 1, 2, 3),
(3, 'baris', 'demirci', 'barisdemirci', 'baris19052003', 'barisbaba3', 'barisbaba', 1, 2, 3),
(4, 'baris', 'demirci', 'barisdemasdsairci', 'baris19052003', 'barisbaba3', 'barisbaba', 1, 2, 3);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`kullanici_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `kullanici_id` int(90) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
