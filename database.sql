CREATE DATABASE IF NOT EXISTS db_apotek;
USE db_apotek;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100),
    role ENUM('admin', 'kasir') DEFAULT 'admin'
);

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(100) NOT NULL,
    telepon VARCHAR(20),
    alamat TEXT
);

CREATE TABLE obat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_obat VARCHAR(100) NOT NULL,
    kategori VARCHAR(50),
    harga INT NOT NULL,
    stok INT NOT NULL
);

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tgl_transaksi DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_obat INT,
    jumlah INT,
    total_harga INT,
    FOREIGN KEY (id_obat) REFERENCES obat(id) ON DELETE CASCADE
);

INSERT INTO users (username, password, nama, role) VALUES ('admin', '12345', 'Admin Utama', 'admin');
INSERT INTO supplier (nama_supplier, telepon, alamat) VALUES ('PT Kimia Farma', '08123456789', 'Jl. Merdeka No. 10');
INSERT INTO obat (nama_obat, kategori, harga, stok) VALUES ('Paracetamol 500mg', 'Obat Bebas', 5000, 50);