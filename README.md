php -S localhost:8000

-- Tabella utenti
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    mail VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabella consigli manga
CREATE TABLE recommendation_manga (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria VARCHAR(20) NOT NULL DEFAULT 'Manga',
    titolo VARCHAR(100) NOT NULL,
    foto VARCHAR(255),
    autore VARCHAR(100),
    data_pubblicazione DATE,
    descrizione TEXT,
    commento TEXT,
    pannelli JSON, -- massimo 5 immagini
    voto TINYINT, -- 1-5
    link_acquisto VARCHAR(255),
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabella consigli videogiochi
CREATE TABLE recommendation_videogioco (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria VARCHAR(20) NOT NULL DEFAULT 'Videogioco',
    titolo VARCHAR(100) NOT NULL,
    foto VARCHAR(255),
    descrizione TEXT,
    commento TEXT,
    piattaforma VARCHAR(50),
    genere VARCHAR(50),
    voto TINYINT, -- 1-5
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabella consigli canzoni
CREATE TABLE recommendation_canzoni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria VARCHAR(20) NOT NULL DEFAULT 'Canzone',
    titolo VARCHAR(100) NOT NULL,
    genere VARCHAR(50),
    autore VARCHAR(100),
    testo TEXT,
    commento TEXT,
    anno SMALLINT,
    album VARCHAR(100),
    link_video VARCHAR(255),
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
