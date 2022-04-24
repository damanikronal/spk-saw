-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 28. Oktober 2012 jam 00:23
-- Versi Server: 5.0.67
-- Versi PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `saw`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE IF NOT EXISTS `alternatif` (
  `id_alt` varchar(3) collate latin1_general_ci NOT NULL,
  `nm_alt` varchar(100) collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alt`, `nm_alt`) VALUES
('1', 'SAMSUNG GALAXY TAB 10.1'),
('2', 'LG OPTIMUS PAD V900'),
('3', 'HUAWEI S7 TABLET'),
('4', 'AXIOO PICOPAD');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bobot_kriteria`
--

CREATE TABLE IF NOT EXISTS `bobot_kriteria` (
  `id_kriteria` varchar(3) collate latin1_general_ci NOT NULL,
  `bobot` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `bobot_kriteria`
--

INSERT INTO `bobot_kriteria` (`id_kriteria`, `bobot`) VALUES
('1', 0.22),
('2', 0.22),
('3', 0.19),
('4', 0.18),
('5', 0.19);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE IF NOT EXISTS `hasil` (
  `id_alt` varchar(3) collate latin1_general_ci NOT NULL,
  `bobot_hasil` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_alt`, `bobot_hasil`) VALUES
('1', 0.645),
('2', 0.599),
('3', 0.736),
('4', 0.702);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE IF NOT EXISTS `kriteria` (
  `id_kriteria` varchar(3) collate latin1_general_ci NOT NULL,
  `nama_kriteria` varchar(100) collate latin1_general_ci NOT NULL,
  `tipe` enum('COST','BENEFIT') collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `tipe`) VALUES
('1', 'Harga', 'COST'),
('2', 'Teknologi', 'BENEFIT'),
('3', 'Memory', 'BENEFIT'),
('4', 'Berat', 'COST'),
('5', 'Baterai', 'BENEFIT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `matrik`
--

CREATE TABLE IF NOT EXISTS `matrik` (
  `id_alt` varchar(3) collate latin1_general_ci NOT NULL,
  `id_kriteria` varchar(3) collate latin1_general_ci NOT NULL,
  `nilai` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `matrik`
--

INSERT INTO `matrik` (`id_alt`, `id_kriteria`, `nilai`) VALUES
('1', '1', 150),
('1', '2', 15),
('1', '3', 2),
('1', '4', 2),
('1', '5', 3),
('2', '1', 500),
('2', '2', 200),
('2', '3', 2),
('2', '4', 3),
('2', '5', 2),
('3', '1', 200),
('3', '2', 10),
('3', '3', 3),
('3', '4', 1),
('3', '5', 3),
('4', '1', 350),
('4', '2', 100),
('4', '3', 3),
('4', '4', 1),
('4', '5', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `matrik_norm`
--

CREATE TABLE IF NOT EXISTS `matrik_norm` (
  `id_alt` varchar(3) collate latin1_general_ci NOT NULL,
  `id_kriteria` varchar(3) collate latin1_general_ci NOT NULL,
  `nilai_norm` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `matrik_norm`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu` varchar(30) collate latin1_general_ci NOT NULL,
  `link` varchar(50) collate latin1_general_ci NOT NULL,
  `status` enum('admin','user') collate latin1_general_ci NOT NULL default 'user',
  `aktif` enum('y','n') collate latin1_general_ci NOT NULL,
  `urutan` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`menu`, `link`, `status`, `aktif`, `urutan`) VALUES
('Data Pengguna', '?modul=pengguna', 'admin', 'y', 1),
('Kriteria Penilaian', '?modul=kriteria', 'admin', 'y', 2),
('Bobot Kriteria', '?modul=bobot', 'user', 'y', 3),
('Evaluasi', '?modul=evaluasi', 'user', 'y', 5),
('Alternatif', '?modul=alternatif', 'admin', 'y', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE IF NOT EXISTS `pengguna` (
  `email` text collate latin1_general_ci NOT NULL,
  `username` varchar(30) collate latin1_general_ci NOT NULL,
  `password` varchar(32) collate latin1_general_ci NOT NULL,
  `level` enum('admin','user') collate latin1_general_ci NOT NULL default 'user',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`email`, `username`, `password`, `level`) VALUES
('karen@yahoo.com', 'karen', 'ba952731f97fb058035aa399b1cb3d5c', 'admin'),
('ari@yahoo.com', 'ari', '202cb962ac59075b964b07152d234b70', 'user'),
('putri@yahoo.com', 'putri', '202cb962ac59075b964b07152d234b70', 'user'),
('rina@yahoo.com', 'rina', '202cb962ac59075b964b07152d234b70', 'user');
