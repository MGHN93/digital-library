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
    ('Sapiens',              'Yuval Noah Harari','Non-fiksi', 2011, 3),

    ('The Pragmatic Programmer', 'Andrew Hunt',      'Teknologi', 1999, 3),
    ('Code Complete',            'Steve McConnell',  'Teknologi', 2004, 2),
    ('Refactoring',              'Martin Fowler',    'Teknologi', 1999, 2),
    ('Design Patterns',          'Gang of Four',     'Teknologi', 1994, 1),
    ('Eloquent JavaScript',      'Marijn Haverbeke', 'Teknologi', 2018, 4),

    ('Rich Dad Poor Dad',        'Robert Kiyosaki',  'Non-fiksi', 1997, 3),
    ('The Psychology of Money',  'Morgan Housel',    'Non-fiksi', 2020, 5),
    ('Thinking Fast and Slow',   'Daniel Kahneman',  'Non-fiksi', 2011, 2),
    ('Deep Work',                'Cal Newport',      'Non-fiksi', 2016, 3),
    ('The Power of Habit',       'Charles Duhigg',   'Non-fiksi', 2012, 2),

    ('Negeri 5 Menara',          'Ahmad Fuadi',      'Novel',     2009, 4),
    ('Ayat-Ayat Cinta',          'Habiburrahman',    'Novel',     2004, 3),
    ('Dilan 1990',               'Pidi Baiq',        'Novel',     2014, 5),
    ('Perahu Kertas',            'Dee Lestari',      'Novel',     2009, 2),
    ('Pulang',                   'Tere Liye',        'Novel',     2015, 4),

    ('Harry Potter',             'J.K. Rowling',     'Novel',     1997, 5),
    ('The Hobbit',               'J.R.R. Tolkien',   'Novel',     1937, 3),
    ('The Alchemist',            'Paulo Coelho',     'Novel',     1988, 4),
    ('To Kill a Mockingbird',    'Harper Lee',       'Novel',     1960, 2),
    ('1984',                     'George Orwell',    'Novel',     1949, 3);