CREATE DATABASE IF NOT EXISTS perpustakaan;
USE perpustakaan;

CREATE TABLE books (
    id         INT PRIMARY KEY AUTO_INCREMENT,
    title      VARCHAR(200) NOT NULL,
    author     VARCHAR(150) NOT NULL,
    category   VARCHAR(100),
    year       YEAR,
    stock      INT DEFAULT 1,
    cover      VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE borrowings (
    id            INT PRIMARY KEY AUTO_INCREMENT,
    book_id       INT NOT NULL,
    borrower_name VARCHAR(150) NOT NULL,
    borrow_date   DATE NOT NULL,
    return_date   DATE,
    status        ENUM('dipinjam', 'dikembalikan') DEFAULT 'dipinjam',
    FOREIGN KEY (book_id) REFERENCES books(id)
);

CREATE TABLE users (
    id         INT PRIMARY KEY AUTO_INCREMENT,
    username   VARCHAR(50) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL
);

-- Data awal
INSERT INTO books (title, author, category, year, stock) VALUES
    ('Laskar Pelangi',       'Andrea Hirata',    'Novel',   2005, 3),
    ('Bumi Manusia',         'Pramoedya Ananta', 'Novel',   1980, 2),
    ('Atomic Habits',        'James Clear',      'Non-fiksi', 2018, 4),
    ('Clean Code',           'Robert C. Martin', 'Teknologi', 2008, 2),
    ('Sapiens',              'Yuval Noah Harari','Non-fiksi', 2011, 3);