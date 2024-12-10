SET SQL_MODE = "STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = '+07:00'; -- Waktu Jakarta (GMT+7)

CREATE DATABASE IF NOT EXISTS perpustakaan CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE perpustakaan;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expires` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci

CREATE TABLE `buku` (
  `id_buku` VARCHAR(20) NOT NULL,
  `judul_buku` VARCHAR(256) NOT NULL,
  `penulis` VARCHAR(256) NOT NULL,
  `tahun_terbit` INT(4) NOT NULL,
  `jenis_buku` VARCHAR(256) NOT NULL,
  `bahasa` VARCHAR(30) NOT NULL,
  `ketersedian` VARCHAR(30) NOT NULL DEFAULT 'Tersedia',
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `reservasi` (
  `no_rsvs` CHAR(10) NOT NULL,
  `nama` VARCHAR(50) NOT NULL,
  `id_buku` VARCHAR(20) NOT NULL,
  `tanggal_pengambilan` DATETIME NOT NULL,
  `kontak` VARCHAR(20) NOT NULL,
  `status` VARCHAR(20) NOT NULL DEFAULT 'process',
  `user` INT(11) NOT NULL,
  PRIMARY KEY (`no_rsvs`),
  FOREIGN KEY (`user`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Buat Trigger char(10)
DELIMITER $$

CREATE FUNCTION generate_random_string()
RETURNS CHAR(10)
DETERMINISTIC
BEGIN
    DECLARE result CHAR(10);
    SET result = SUBSTRING(MD5(RAND()), 1, 10);
    RETURN result;
END$$

DELIMITER ;

-- Buat Trigger untuk no_rsvs
DELIMITER $$

CREATE TRIGGER before_insert_reservasi
BEFORE INSERT ON reservasi
FOR EACH ROW
BEGIN
    DECLARE new_no_rsvs CHAR(10);
    
    -- Loop untuk memastikan nilai unik
    REPEAT
        SET new_no_rsvs = generate_random_string();
    UNTIL NOT EXISTS (
        SELECT 1 FROM reservasi WHERE no_rsvs = new_no_rsvs
    ) END REPEAT;

    -- Tetapkan nilai unik ke kolom no_rsvs
    SET NEW.no_rsvs = new_no_rsvs;
END$$

DELIMITER ;

CREATE TABLE `pengunjung` (
  `nomor_kunjungan` INT(15) NOT NULL AUTO_INCREMENT,
  `nim` INT(15) NOT NULL,
  `nama_pengunjung` VARCHAR(256) NOT NULL,
  `prodi` VARCHAR(256) NOT NULL,
  `fakultas` VARCHAR(256) NOT NULL,
  `waktu_berkunjung` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`nomor_kunjungan`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pinjam` (
  `no_pinjam` CHAR(12) NOT NULL,
  `nomor_kunjungan` INT(15) NOT NULL,
  `id_buku` VARCHAR(20) NOT NULL,
  `tanggal_pinjam` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `tanggal_pengembalian` DATE NOT NULL,
  `kontak` BIGINT(20) NOT NULL,
  `status` VARCHAR(20) NOT NULL DEFAULT 'belum dikembalikan',
  `user` INT(11) NOT NULL,
  PRIMARY KEY (`no_pinjam`),
  FOREIGN KEY (`nomor_kunjungan`) REFERENCES `pengunjung`(`nomor_kunjungan`),
  FOREIGN KEY (`id_buku`) REFERENCES `buku`(`id_buku`),
  FOREIGN KEY (`user`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Buat Trigger untuk char(12)
DELIMITER $$

CREATE FUNCTION generate_random_string_12()
RETURNS CHAR(12)
DETERMINISTIC
BEGIN
    DECLARE result CHAR(12);
    SET result = SUBSTRING(MD5(RAND()), 1, 12);
    RETURN result;
END$$

DELIMITER ;


-- Buat Trigger untuk no_pinjam
DELIMITER $$

CREATE TRIGGER before_insert_pinjam
BEFORE INSERT ON pinjam
FOR EACH ROW
BEGIN
    DECLARE new_no_pinjam CHAR(12);

    -- Loop untuk memastikan nilai unik
    REPEAT
        SET new_no_pinjam = generate_random_string_12();
    UNTIL NOT EXISTS (
        SELECT 1 FROM pinjam WHERE no_pinjam = new_no_pinjam
    ) END REPEAT;

    -- Tetapkan nilai unik ke kolom no_pinjam
    SET NEW.no_pinjam = new_no_pinjam;
END$$

DELIMITER ;

-- Insert data Admin ke tabel `users`
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('Azul', 'greatazul', 'admin');

-- Dumping data untuk tabel `buku`
INSERT INTO `buku` (`id_buku`, `judul_buku`, `penulis`, `tahun_terbit`, `jenis_buku`, `bahasa`) VALUES
('B001', 'Belajar PHP untuk Pemula', 'John Doe', 2020, 'Pemrograman', 'Indonesia'),
('B002', 'Mengenal Basis Data', 'Jane Smith', 2019, 'Teknologi', 'Indonesia'),
('B003', 'Pengenalan HTML dan CSS', 'Tom Brown', 2018, 'Web Development', 'Inggris'),
('B004', 'Algoritma dan Struktur Data', 'Emily White', 2021, 'Pemrograman', 'Indonesia'),
('B005', 'Machine Learning Dasar', 'Michael Green', 2022, 'Teknologi', 'Inggris');

-- Dumping data untuk tabel `reservasi`
INSERT INTO `reservasi` (`nama`, `id_buku`, `tanggal_pengambilan`, `kontak`, `status`, `user`) VALUES
('Andi Surya', 'B001', '2024-12-15 08:30:00', '081234567890', 'process', 1),
('Budi Santoso', 'B002', '2024-12-16 09:00:00', '082345678901', 'process', 1),
('Citra Dewi', 'B003', '2024-12-17 10:00:00', '083456789012', 'process', 1),
('Dedi Prasetyo', 'B004', '2024-12-18 11:30:00', '084567890123', 'process', 1),
('Eka Lestari', 'B005', '2024-12-19 14:00:00', '085678901234', 'process', 1);

-- Dumping data untuk tabel `pengunjung`
INSERT INTO `pengunjung` (`nim`, `nama_pengunjung`, `prodi`, `fakultas`) VALUES
(123456789, 'Ali Ahmad', 'Informatika', 'Fakultas Teknik'),
(987654321, 'Budi Santoso', 'Matematika', 'Fakultas Sains'),
(112233445, 'Citra Dewi', 'Teknik Elektro', 'Fakultas Teknik'),
(556677889, 'Dika Pratama', 'Fisika', 'Fakultas Sains'),
(223344556, 'Eka Lestari', 'Biologi', 'Fakultas Sains');

-- Dumping data untuk tabel `pinjam`
INSERT INTO `pinjam` (`nomor_kunjungan`, `id_buku`, `tanggal_pengembalian`, `kontak`, `user`) VALUES
(1, 'B001', '2024-12-17', 8123456789, 1),
(2, 'B002', '2024-12-17', 8234567890, 1),
(3, 'B003', '2024-12-17', 8345678901, 1),
(4, 'B004', '2024-12-17', 8456789012, 1),
(5, 'B005', '2024-12-17', 8567890123, 1);

COMMIT;
