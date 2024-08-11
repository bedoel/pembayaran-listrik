-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Agu 2024 pada 09.32
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pembayaran-listrik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `nama_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`id_level`, `nama_level`) VALUES
(1, 'Administrator'),
(2, 'Petugas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor_kwh` varchar(20) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `id_tarif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `username`, `password`, `nomor_kwh`, `nama_pelanggan`, `alamat`, `id_tarif`) VALUES
(6, 'udin123', '$2y$10$Pto3xTnZEP45XBjiU.RRDuAzgDY9HgY0znGBnniDRcebu2vQSGL6m', '1168905274', 'Udin', 'Jl. Senggol', 1),
(7, 'lala123', '$2y$10$6EeiK4tcZq/ANCOWWF66ie6Ot.SzLbg.iIbzzmNRHg0ahqSIA8Zsa', '5542532537', 'Lala', 'Jl. Kramat', 8),
(9, 'ardi123', '$2y$10$b/e.feA9a7xgkjaQkRBu8ecuHlpQkkOrxLUgUV950.57lWTg6A00a', '5863302272', 'ardi', 'jl jalan', 17),
(10, 'qweqwe', '$2y$10$84.Wb4Axdw37nfcLlexg8OPE9eAkbuFiDhc8G0paRjank9eyMptUK', '2472073013', 'qweqwe', 'qweqwe', 1);

--
-- Trigger `pelanggan`
--
DELIMITER $$
CREATE TRIGGER `before_pelanggan_delete` BEFORE DELETE ON `pelanggan` FOR EACH ROW BEGIN
    -- Hapus data dari tabel tagihan yang terkait dengan pelanggan
    DELETE FROM tagihan WHERE id_pelanggan = OLD.id_pelanggan;
    
    -- Hapus data dari tabel penggunaan yang terkait dengan pelanggan
    DELETE FROM penggunaan WHERE id_pelanggan = OLD.id_pelanggan;
    DELETE FROM pembayaran
    WHERE id_tagihan = OLD.id_pelanggan;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_pembayaran_after_pelanggan_delete` BEFORE DELETE ON `pelanggan` FOR EACH ROW BEGIN
    DELETE FROM pembayaran
    WHERE id_tagihan IN (SELECT id_tagihan FROM tagihan WHERE id_pelanggan = OLD.id_pelanggan);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_related_data_after_pelanggan_delete` BEFORE DELETE ON `pelanggan` FOR EACH ROW BEGIN
    -- Hapus data pembayaran terkait
    DELETE FROM pembayaran 
    WHERE id_tagihan IN (SELECT id_tagihan FROM tagihan WHERE id_pelanggan = OLD.id_pelanggan);

    -- Hapus data tagihan terkait
    DELETE FROM tagihan 
    WHERE id_pelanggan = OLD.id_pelanggan;

    -- Hapus data penggunaan terkait
    DELETE FROM penggunaan 
    WHERE id_pelanggan = OLD.id_pelanggan;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_tagihan_after_pelanggan_delete` BEFORE DELETE ON `pelanggan` FOR EACH ROW BEGIN
    DELETE FROM tagihan
    WHERE id_pelanggan = OLD.id_pelanggan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_tagihan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `bulan_bayar` varchar(20) NOT NULL,
  `biaya_admin` decimal(10,2) NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nama_admin_copy` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_tagihan`, `id_pelanggan`, `tanggal_pembayaran`, `bulan_bayar`, `biaya_admin`, `total_bayar`, `id_user`, `nama_admin_copy`) VALUES
(13, 11, 6, '2024-08-01', '08', 2500.00, 44000.00, 1, 'Admin Satu'),
(14, 12, 7, '2024-08-01', '08', 2500.00, 62500.00, 1, 'Admin Satu'),
(15, 14, 6, '2024-08-01', '09', 2500.00, 85500.00, 1, 'Admin Satu'),
(16, 15, 7, '2024-08-02', '08', 2500.00, 122500.00, 7, 'Erik'),
(18, 16, 9, '2024-08-03', '08', 2500.00, 112500.00, 1, 'Admin Satu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penggunaan`
--

CREATE TABLE `penggunaan` (
  `id_penggunaan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `tahun` int(11) NOT NULL,
  `meter_awal` int(11) NOT NULL,
  `meter_akhir` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `penggunaan`
--

INSERT INTO `penggunaan` (`id_penggunaan`, `id_pelanggan`, `bulan`, `tahun`, `meter_awal`, `meter_akhir`) VALUES
(13, 6, '08', 2024, 100, 200),
(14, 7, '08', 2024, 100, 300),
(16, 6, '09', 2024, 300, 500),
(17, 7, '08', 2024, 100, 300),
(18, 9, '08', 2024, 200, 300),
(19, 10, '08', 2024, 100, 300);

--
-- Trigger `penggunaan`
--
DELIMITER $$
CREATE TRIGGER `after_penggunaan_update` AFTER UPDATE ON `penggunaan` FOR EACH ROW BEGIN
    DECLARE v_jumlah_meter INT;
    
    SET v_jumlah_meter = NEW.meter_akhir - NEW.meter_awal;
    
    UPDATE tagihan
    SET 
        id_pelanggan = NEW.id_pelanggan,
        bulan = NEW.bulan,
        tahun = NEW.tahun,
        jumlah_meter = v_jumlah_meter
    WHERE id_penggunaan = NEW.id_penggunaan;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_penggunaan_delete` BEFORE DELETE ON `penggunaan` FOR EACH ROW BEGIN
    DELETE FROM pembayaran 
    WHERE id_tagihan IN (SELECT id_tagihan FROM tagihan WHERE id_penggunaan = OLD.id_penggunaan);
    DELETE FROM tagihan WHERE id_penggunaan = OLD.id_penggunaan;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_tagihan_after_penggunaan_delete` BEFORE DELETE ON `penggunaan` FOR EACH ROW BEGIN
    DELETE FROM tagihan WHERE id_penggunaan = OLD.id_penggunaan;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_insert_tagihan` AFTER INSERT ON `penggunaan` FOR EACH ROW BEGIN
    DECLARE v_jumlah_meter INT;
    
    SET v_jumlah_meter = NEW.meter_akhir - NEW.meter_awal;
    
    INSERT INTO tagihan (id_penggunaan, id_pelanggan, bulan, tahun, jumlah_meter, status)
    VALUES (NEW.id_penggunaan, NEW.id_pelanggan, NEW.bulan, NEW.tahun, v_jumlah_meter, 'Belum Bayar');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` int(11) NOT NULL,
  `id_penggunaan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `tahun` int(11) NOT NULL,
  `jumlah_meter` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `id_penggunaan`, `id_pelanggan`, `bulan`, `tahun`, `jumlah_meter`, `status`) VALUES
(11, 13, 6, '08', 2024, 100, 'Lunas'),
(12, 14, 7, '08', 2024, 200, 'Lunas'),
(14, 16, 6, '09', 2024, 200, 'Lunas'),
(15, 17, 7, '08', 2024, 200, 'Lunas'),
(16, 18, 9, '08', 2024, 100, 'Lunas'),
(17, 19, 10, '08', 2024, 200, 'Belum Bayar');

--
-- Trigger `tagihan`
--
DELIMITER $$
CREATE TRIGGER `delete_pembayaran_after_tagihan_delete` BEFORE DELETE ON `tagihan` FOR EACH ROW BEGIN
    DELETE FROM pembayaran WHERE id_tagihan = OLD.id_tagihan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tarif`
--

CREATE TABLE `tarif` (
  `id_tarif` int(11) NOT NULL,
  `daya` int(11) NOT NULL,
  `tarifperkwh` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tarif`
--

INSERT INTO `tarif` (`id_tarif`, `daya`, `tarifperkwh`) VALUES
(1, 450, 415.00),
(8, 900, 600.00),
(9, 1200, 1350.00),
(17, 1000, 1100.00);

--
-- Trigger `tarif`
--
DELIMITER $$
CREATE TRIGGER `before_tarif_delete` BEFORE DELETE ON `tarif` FOR EACH ROW BEGIN
    UPDATE pelanggan 
    SET id_tarif = NULL
    WHERE id_tarif = OLD.id_tarif;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `id_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_admin`, `id_level`) VALUES
(1, 'admin1', '$2y$10$vO3L87ckbNlzglq.NYukUu3ETP5SvcQwbm5v7Bfpc6k0j6T6LlEhW', 'Admin Satu', 1),
(7, 'erik123', '$2y$10$dEiAyapTiuTCbKGxBugaV.jQnTLdgtYZ7hEDCfmjFOHWEvlJxr82u', 'Erik', 2);

--
-- Trigger `user`
--
DELIMITER $$
CREATE TRIGGER `before_user_delete` BEFORE DELETE ON `user` FOR EACH ROW BEGIN
    -- Update id_user di tabel pembayaran menjadi NULL
    UPDATE pembayaran
    SET id_user = NULL, nama_admin_copy = OLD.nama_admin
    WHERE id_user = OLD.id_user;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_penggunaan_listrik`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_penggunaan_listrik` (
`id_pelanggan` int(11)
,`nama_pelanggan` varchar(100)
,`nomor_kwh` varchar(20)
,`bulan` varchar(20)
,`tahun` int(11)
,`meter_awal` int(11)
,`meter_akhir` int(11)
,`jumlah_penggunaan` bigint(12)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_penggunaan_listrik`
--
DROP TABLE IF EXISTS `view_penggunaan_listrik`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_penggunaan_listrik`  AS SELECT `p`.`id_pelanggan` AS `id_pelanggan`, `pl`.`nama_pelanggan` AS `nama_pelanggan`, `pl`.`nomor_kwh` AS `nomor_kwh`, `p`.`bulan` AS `bulan`, `p`.`tahun` AS `tahun`, `p`.`meter_awal` AS `meter_awal`, `p`.`meter_akhir` AS `meter_akhir`, `p`.`meter_akhir`- `p`.`meter_awal` AS `jumlah_penggunaan` FROM (`penggunaan` `p` join `pelanggan` `pl` on(`p`.`id_pelanggan` = `pl`.`id_pelanggan`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD KEY `id_tarif` (`id_tarif`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_tagihan` (`id_tagihan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `pembayaran_ibfk_3` (`id_user`);

--
-- Indeks untuk tabel `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD PRIMARY KEY (`id_penggunaan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `id_penggunaan` (`id_penggunaan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_level` (`id_level`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `penggunaan`
--
ALTER TABLE `penggunaan`
  MODIFY `id_penggunaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id_tagihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`id_tarif`) REFERENCES `tarif` (`id_tarif`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_tagihan`) REFERENCES `tagihan` (`id_tagihan`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD CONSTRAINT `penggunaan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);

--
-- Ketidakleluasaan untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`id_penggunaan`) REFERENCES `penggunaan` (`id_penggunaan`),
  ADD CONSTRAINT `tagihan_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
