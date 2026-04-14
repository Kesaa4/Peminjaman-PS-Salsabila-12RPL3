-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2026 at 04:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjaman_ps`
--

-- --------------------------------------------------------
-- Table: activity_logs
-- --------------------------------------------------------

CREATE TABLE `activity_logs` (
  `id`          int(11)      NOT NULL,
  `user_id`     int(11)      NOT NULL,
  `action`      varchar(50)  NOT NULL,
  `description` text         NOT NULL,
  `ip_address`  varchar(45)  DEFAULT NULL,
  `user_agent`  text         DEFAULT NULL,
  `created_at`  timestamp    NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 1, 'login', 'User login ke sistem', '::1', 'Mozilla/5.0', '2026-04-14 14:09:29'),
(2, 1, 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0', '2026-04-14 14:09:49'),
(3, 1, 'login', 'User login ke sistem', '::1', 'Mozilla/5.0', '2026-04-14 14:11:15'),
(4, 1, 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0', '2026-04-14 14:11:18'),
(5, 2, 'login', 'User login ke sistem', '::1', 'Mozilla/5.0', '2026-04-14 14:11:28'),
(6, 2, 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0', '2026-04-14 14:11:34'),
(7, 3, 'login', 'User login ke sistem', '::1', 'Mozilla/5.0', '2026-04-14 14:12:31'),
(8, 3, 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0', '2026-04-14 14:12:44'),
(9, 1, 'login', 'User login ke sistem', '::1', 'Mozilla/5.0', '2026-04-14 14:12:48'),
(10, 1, 'create', 'Menambahkan user baru: Keysha Kirana (keysha)', '::1', 'Mozilla/5.0', '2026-04-14 14:13:14'),
(11, 1, 'update', 'Mengupdate user: Peminjam Satu (peminjam)', '::1', 'Mozilla/5.0', '2026-04-14 14:13:40'),
(12, 1, 'update', 'Mengupdate user: petugas (petugas)', '::1', 'Mozilla/5.0', '2026-04-14 14:13:46'),
(13, 1, 'update', 'Mengupdate user: Admin PS (admin)', '::1', 'Mozilla/5.0', '2026-04-14 14:13:58'),
(14, 1, 'update', 'Mengupdate user: petugas (petugas)', '::1', 'Mozilla/5.0', '2026-04-14 14:14:15'),
(15, 1, 'update', 'Mengupdate user: petugas (petugas)', '::1', 'Mozilla/5.0', '2026-04-14 14:14:24'),
(16, 1, 'update', 'Mengupdate user: petugas (petugas)', '::1', 'Mozilla/5.0', '2026-04-14 14:14:33'),
(17, 1, 'create', 'Menambahkan user baru: Salsabila Putri R (salsabila)', '::1', 'Mozilla/5.0', '2026-04-14 14:15:23'),
(18, 1, 'create', 'Menambahkan user baru: Dea Amelia (dea)', '::1', 'Mozilla/5.0', '2026-04-14 14:15:40'),
(19, 1, 'update', 'Mengupdate user: salsabila (salsabila)', '::1', 'Mozilla/5.0', '2026-04-14 14:15:48'),
(20, 1, 'delete', 'Menghapus user id: 1238', '::1', 'Mozilla/5.0', '2026-04-14 14:16:00'),
(21, 1, 'create', 'Menambahkan PS baru: Playstation HARD DISK 300 Game VIP (PS5)', '::1', 'Mozilla/5.0', '2026-04-14 14:16:54'),
(22, 1, 'update', 'Mengupdate PS: Playstation HARD DISK 300 Game VIP (PS5)', '::1', 'Mozilla/5.0', '2026-04-14 14:17:01'),
(36, 1, 'create', 'Menambahkan PS baru: Playstation HARD DISK 300 Game VIP 2 (PS5)', '::1', 'Mozilla/5.0', '2026-04-14 14:18:19'),
(37, 1, 'create', 'Menambahkan PS baru: Playstation HARD DISK 200 Game SILVER (PS4)', '::1', 'Mozilla/5.0', '2026-04-14 14:19:02');

-- --------------------------------------------------------
-- Table: kategori
-- --------------------------------------------------------

CREATE TABLE `kategori` (
  `kategori_id`   int(11)      NOT NULL,
  `nama_kategori` varchar(55)  NOT NULL,
  `deskripsi`     varchar(255) NOT NULL DEFAULT '',
  `created_at`    datetime     NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `kategori` (`kategori_id`, `nama_kategori`, `deskripsi`, `created_at`) VALUES
(1, 'Konsol', '', NOW());

-- --------------------------------------------------------
-- Table: ps  (unit alat/PS yang bisa dipinjam, terhubung ke kategori)
-- --------------------------------------------------------

CREATE TABLE `ps` (
  `id`           int(11)                        NOT NULL,
  `kategori_id`  int(11)                        DEFAULT NULL,
  `nama_ps`      varchar(100)                   NOT NULL,
  `tipe`         enum('PS3','PS4','PS5')         NOT NULL,
  `status`       enum('tersedia','dipinjam')     DEFAULT 'tersedia',
  `harga_per_jam` int(11)                       NOT NULL,
  `created_at`   timestamp                      NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `ps` (`id`, `kategori_id`, `nama_ps`, `tipe`, `status`, `harga_per_jam`, `created_at`) VALUES
(14, 1, 'Playstation HARD DISK 300 Game VIP',   'PS5', 'tersedia', 35000, '2026-04-14 14:16:54'),
(15, 1, 'Playstation HARD DISK 300 Game VIP 2', 'PS5', 'tersedia', 35000, '2026-04-14 14:18:19'),
(16, 1, 'Playstation HARD DISK 200 Game SILVER','PS4', 'tersedia', 25000, '2026-04-14 14:19:02');

-- --------------------------------------------------------
-- Table: peminjaman
-- --------------------------------------------------------

CREATE TABLE `peminjaman` (
  `id`             int(11)                              NOT NULL,
  `user_id`        int(11)                              NOT NULL,
  `no_ktp`         varchar(20)                          DEFAULT NULL,
  `no_telepon`     varchar(15)                          DEFAULT NULL,
  `ps_id`          int(11)                              NOT NULL,
  `tanggal_pinjam` datetime                             NOT NULL,
  `tanggal_kembali` datetime                            DEFAULT NULL,
  `durasi_jam`     int(11)                              NOT NULL,
  `total_harga`    int(11)                              NOT NULL,
  `kondisi_ps`     enum('baik','rusak')                 DEFAULT NULL,
  `denda`          int(11)                              DEFAULT 0,
  `keterangan`     text                                 DEFAULT NULL,
  `status`         enum('pending','disetujui','ditolak','selesai') DEFAULT 'pending',
  `approved_by`    int(11)                              DEFAULT NULL,
  `approved_at`    datetime                             DEFAULT NULL,
  `alasan_tolak`   text                                 DEFAULT NULL,
  `created_at`     timestamp                            NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------

CREATE TABLE `users` (
  `id`         int(11)                              NOT NULL,
  `username`   varchar(50)                          NOT NULL,
  `password`   varchar(255)                         NOT NULL,
  `nama`       varchar(100)                         NOT NULL,
  `role`       enum('admin','petugas','peminjam')   NOT NULL,
  `created_at` timestamp                            NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `role`, `created_at`) VALUES
(1,    'admin',     '$2y$10$NiUbBEg6a.WgMlmArH62j.aAMJJH7MiVGfOynSP/DBtiTrV96VjYS', 'Admin PS',      'admin',    '2026-02-10 03:20:10'),
(2,    'petugas',   '$2y$10$72irBFFOH4kmfPwdZA5neO/TXUqxXVl.KirqgKhHULOeGPIahE7qy', 'petugas',       'petugas',  '2026-02-10 03:20:10'),
(3,    'peminjam',  '$2y$10$wzzE8OdKuoZ8da0JwIJS3OOj8lJaY85YLUIp/qeZdH.0WHCBb9FFW', 'Peminjam Satu', 'peminjam', '2026-02-10 03:20:10'),
(1235, 'keysha',    '$2y$10$8zMuSkJS.g5ThGYlKlF75uk051C16.0wVW1Rk80FBBxxaMkhmzmky', 'Keysha Kirana', 'peminjam', '2026-04-14 14:13:14'),
(1237, 'salsabila', '$2y$10$AnYoGFUpntV6uUpN.HqxNOf1c9wl64kD2lvo4RI349Dsa1xTyZLbu', 'salsabila',     'petugas',  '2026-04-14 14:15:23');

-- --------------------------------------------------------
-- Indexes
-- --------------------------------------------------------

ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_created_at` (`created_at`);

ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

ALTER TABLE `ps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ps_id` (`ps_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

-- --------------------------------------------------------
-- AUTO_INCREMENT
-- --------------------------------------------------------

ALTER TABLE `activity_logs` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
ALTER TABLE `kategori`      MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `ps`            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
ALTER TABLE `peminjaman`    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users`         MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1239;

-- --------------------------------------------------------
-- Foreign Keys
-- --------------------------------------------------------

ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `ps`
  ADD CONSTRAINT `ps_ibfk_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`) ON DELETE SET NULL;

ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`ps_id`) REFERENCES `ps` (`id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
