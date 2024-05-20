-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 20 May 2024, 21:12:38
-- Sunucu sürümü: 8.0.31
-- PHP Sürümü: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `kutuphane`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `adresler`
--

DROP TABLE IF EXISTS `adresler`;
CREATE TABLE IF NOT EXISTS `adresler` (
  `adres_id` int NOT NULL AUTO_INCREMENT,
  `mahalle` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `cadde` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `sokak` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `binaNo` double NOT NULL,
  `kapiNo` double NOT NULL,
  `ilce` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `il` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`adres_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `adresler`
--

INSERT INTO `adresler` (`adres_id`, `mahalle`, `cadde`, `sokak`, `binaNo`, `kapiNo`, `ilce`, `il`) VALUES
(1, 'Üniversite', 'Myo', 'Bilgisayar', 1, 1, 'Merkez', 'Sinop'),
(2, 'Osmaniye', 'Üniversite', 'Bilgisayar', 1, 1, 'Merkez', 'Sinop'),
(3, 'Ziraat', 'Banka', 'Para', 2, 2, 'Fatih', 'İstanbul'),
(4, 'İş', 'Banka', 'Cumhuriyet', 81, 57, 'Kızılay', 'Ankara'),
(5, 'Yapı', 'Kredi', 'Banka', 34, 57, 'Fatih', 'İstanbul'),
(6, 'Osmaniye', 'Beyoğlu', 'Ankara', 6, 81, 'Beyoğlu', 'İstanbul'),
(7, 'Karbon', 'Kitap', 'Yayın', 34, 34, 'Bayrampaşa', 'İstanbul'),
(8, 'Kütüphane', 'Kitap', 'Sayfa', 1, 1, 'Merkez', 'Sinop'),
(9, 'Kitap', 'Kurdu', 'Sayfa', 57, 57, 'Merkez', 'Sinop');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

DROP TABLE IF EXISTS `kategoriler`;
CREATE TABLE IF NOT EXISTS `kategoriler` (
  `kategori_id` int NOT NULL AUTO_INCREMENT,
  `kitap_id` int NOT NULL,
  `kategoriAdi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`kategori_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`kategori_id`, `kitap_id`, `kategoriAdi`) VALUES
(1, 1, 'Tarih'),
(2, 2, 'Kişisel Gelişim'),
(3, 3, 'Roman'),
(4, 4, 'Roman'),
(5, 5, 'Roman'),
(6, 6, 'Roman'),
(7, 7, 'Roman'),
(8, 8, 'Roman'),
(9, 9, 'Macera'),
(10, 10, 'Roman'),
(11, 11, 'Roman'),
(12, 12, 'Okuma Kitabı'),
(13, 13, 'Roman'),
(14, 14, 'Roman'),
(15, 15, 'Roman'),
(16, 16, 'Roman');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kitaplar_kutuphane`
--

DROP TABLE IF EXISTS `kitaplar_kutuphane`;
CREATE TABLE IF NOT EXISTS `kitaplar_kutuphane` (
  `kitap_id` int NOT NULL,
  `kutuphane_id` int NOT NULL,
  `adet` int NOT NULL,
  PRIMARY KEY (`kitap_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kitaplar_kutuphane`
--

INSERT INTO `kitaplar_kutuphane` (`kitap_id`, `kutuphane_id`, `adet`) VALUES
(1, 1, 49),
(2, 1, 57),
(3, 1, 30),
(4, 1, 20),
(5, 1, 79),
(6, 1, 15),
(7, 1, 50),
(8, 1, 70),
(9, 1, 90),
(10, 1, 50),
(11, 1, 40),
(12, 1, 30),
(13, 1, 79),
(14, 1, 70),
(15, 1, 70),
(16, 1, 60);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_emanet`
--

DROP TABLE IF EXISTS `tbl_emanet`;
CREATE TABLE IF NOT EXISTS `tbl_emanet` (
  `emanet_id` int NOT NULL AUTO_INCREMENT,
  `uye_id` int NOT NULL,
  `kitap_id` int NOT NULL,
  `kutuphane_id` int NOT NULL,
  `emanetTarihi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `teslimTarihi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `ucret` int NOT NULL,
  `emanetmi` tinyint(1) NOT NULL,
  PRIMARY KEY (`emanet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `tbl_emanet`
--

INSERT INTO `tbl_emanet` (`emanet_id`, `uye_id`, `kitap_id`, `kutuphane_id`, `emanetTarihi`, `teslimTarihi`, `ucret`, `emanetmi`) VALUES
(1, 1, 1, 1, '20.05.2024', '30.05.2024', 0, 1),
(2, 1, 5, 1, '20.05.2024', '30.05.2024', 0, 1),
(3, 1, 8, 1, '20.05.2024', '30.05.2024', 0, 0),
(4, 1, 13, 1, '20.05.2024', '30.05.2024', 0, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_kitaplar`
--

DROP TABLE IF EXISTS `tbl_kitaplar`;
CREATE TABLE IF NOT EXISTS `tbl_kitaplar` (
  `kitap_id` int NOT NULL AUTO_INCREMENT,
  `yayinEvi_id` int NOT NULL,
  `ISBN` bigint NOT NULL,
  `kitapAdi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `yayinTarihi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `sayfaSayisi` int NOT NULL,
  `kitapDili` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`kitap_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `tbl_kitaplar`
--

INSERT INTO `tbl_kitaplar` (`kitap_id`, `yayinEvi_id`, `ISBN`, `kitapAdi`, `yayinTarihi`, `sayfaSayisi`, `kitapDili`) VALUES
(1, 4, 9786256774018, 'Cumhuriyet’İn Doğuşu\r\nKurtuluş Ve Kuruluş Yılları', '8.02.2024', 304, 'Türkçe'),
(2, 4, 9786257631525, 'İnsan İnsana', '3.01.2024', 312, 'Türkçe'),
(3, 5, 9786052194973, 'Bir İdam Mahkumunun Son Günü', '8.04.2024', 85, 'Türkçe'),
(4, 5, 9786057860606, 'Küçük Prens', '5.01.2023', 117, 'Türkçe'),
(5, 5, 9786257109321, 'İrade Terbiyesi', '31.01.2020', 280, 'Türkçe'),
(6, 3, 9789750815546, 'Pal Sokağı Çocukları', '8.04.2024', 235, 'Türkçe'),
(7, 3, 9789750807145, 'İnce Memed 1', '20.05.2024', 436, 'Türkçe'),
(8, 3, 9789750826146, 'Masumiyet Müzesi', '20.05.2024', 524, 'Türkçe'),
(9, 3, 9789750810039, 'Semerkant', '14.05.2024', 318, 'Türkçe'),
(10, 3, 9789753638029, 'Kürk Mantolu Madonna', '20.05.2024', 160, 'Türkçe'),
(11, 2, 9786052957929, 'Otomatik Portakal', '8.04.2024', 171, 'Türkçe'),
(12, 2, 9786254296376, 'Diş Hekimine Gidiyoruz / İlk Okuma Kitabım', '20.05.2024', 24, 'Türkçe'),
(13, 5, 9786057860804, 'Kürk Mantolu Madonna', '20.05.2024', 212, 'Türkçe'),
(14, 3, 9789750807176, 'İnce Memed 2', '20.05.2024', 459, 'Türkçe'),
(15, 3, 9789750862915, 'Yanımda Kal', '14.05.2024', 96, 'Türkçe'),
(16, 4, 9786256989498, 'Cumhuriyet’İn İlk Sabahı', '7.05.2024', 120, 'Türkçe');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_kutuphane`
--

DROP TABLE IF EXISTS `tbl_kutuphane`;
CREATE TABLE IF NOT EXISTS `tbl_kutuphane` (
  `kutuphane_id` int NOT NULL AUTO_INCREMENT,
  `kutuphaneAd` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `adres_id` int NOT NULL,
  PRIMARY KEY (`kutuphane_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `tbl_kutuphane`
--

INSERT INTO `tbl_kutuphane` (`kutuphane_id`, `kutuphaneAd`, `adres_id`) VALUES
(1, 'Sinop Üniversitesi', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_uyeler`
--

DROP TABLE IF EXISTS `tbl_uyeler`;
CREATE TABLE IF NOT EXISTS `tbl_uyeler` (
  `uye_id` int NOT NULL AUTO_INCREMENT,
  `adres_id` int NOT NULL,
  `uyeAd` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `uyeSoyad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `kullaniciAdi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `sifre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `cinsiyet` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `telefon` bigint NOT NULL,
  `eposta` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `yetki` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `kayitTarihi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `yasaklimi` tinyint(1) NOT NULL,
  PRIMARY KEY (`uye_id`),
  UNIQUE KEY `kullaniciAdi` (`kullaniciAdi`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `tbl_uyeler`
--

INSERT INTO `tbl_uyeler` (`uye_id`, `adres_id`, `uyeAd`, `uyeSoyad`, `kullaniciAdi`, `sifre`, `cinsiyet`, `telefon`, `eposta`, `yetki`, `kayitTarihi`, `yasaklimi`) VALUES
(1, 1, 'Ömer Faruk', 'Ercan', 'Admin', 'Library123456784113491239871234567890', 'Erkek', 1234567890, 'admin@admin.com', 'Admin', '20.05.2024', 0),
(2, 8, 'Ömer Faruk', 'Ercan', 'Mod', 'Library123456784113491239871234567890', 'Erkek', 1234569870, 'mod@mod.com', 'Moderator', '20.05.2024', 0),
(3, 9, 'Roman', 'Kitap', 'kitapkurdu', 'Library123456784113491239871234567890', 'Kadın', 3214657570, 'kitapkurdu@gmail.com', 'Üye', '20.05.2024', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_yayin_evleri`
--

DROP TABLE IF EXISTS `tbl_yayin_evleri`;
CREATE TABLE IF NOT EXISTS `tbl_yayin_evleri` (
  `yayinEvi_id` int NOT NULL AUTO_INCREMENT,
  `yayinEviAdi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `adres_id` int NOT NULL,
  PRIMARY KEY (`yayinEvi_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `tbl_yayin_evleri`
--

INSERT INTO `tbl_yayin_evleri` (`yayinEvi_id`, `yayinEviAdi`, `adres_id`) VALUES
(1, 'Ziraat Yayınları', 3),
(2, 'İş Bankası', 4),
(3, 'Yapıkredi', 5),
(4, 'Kronik', 6),
(5, 'Karbon Kitaplar', 7);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yazarlar`
--

DROP TABLE IF EXISTS `yazarlar`;
CREATE TABLE IF NOT EXISTS `yazarlar` (
  `yazar_id` int NOT NULL AUTO_INCREMENT,
  `kitap_id` int NOT NULL,
  `yazarAd` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `yazarSoyad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`yazar_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `yazarlar`
--

INSERT INTO `yazarlar` (`yazar_id`, `kitap_id`, `yazarAd`, `yazarSoyad`) VALUES
(1, 1, 'İlber', 'Ortaylı'),
(2, 2, 'Doğan', 'Cüceoğlu'),
(3, 3, 'Victor', 'Hugo'),
(4, 4, 'Antoine', 'De Saint Exupery'),
(5, 5, 'Jules', 'Payot'),
(6, 6, 'Ferenc', 'Molnar'),
(7, 7, 'Yaşar', 'Kemal'),
(8, 8, 'Orhan', 'Pamuk'),
(9, 9, 'Amin', 'Maalouf'),
(10, 10, 'Sebahattin', 'Ali'),
(11, 11, 'Anthony', 'Burgess'),
(12, 12, 'Andrea', 'Zschocher'),
(13, 13, 'Sebahattin', 'Ali'),
(14, 14, 'Yaşar', 'Kemal'),
(15, 15, 'Eylem', 'Ata Güleç'),
(16, 16, 'İlber', 'Ortaylı');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
