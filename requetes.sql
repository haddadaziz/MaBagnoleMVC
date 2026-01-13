CREATE DATABASE mabagnole;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_complet VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50)
);
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT NOT NULL
)
CREATE TABLE vehicules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marque VARCHAR(100) NOT NULL,
    modele VARCHAR(100) NOT NULL,
    prix_journalier DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255),
    disponible BOOLEAN DEFAULT 1,
    categorie_id INT,
    FOREIGN KEY (categorie_id) REFERENCES categories(id)
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    lieu_depart VARCHAR(255) NOT NULL,
    lieu_retour VARCHAR(255) NOT NULL,
    prix_total DECIMAL(10, 2) NOT NULL,
    statut VARCHAR(50),
    user_id INT,
    vehicule_id INT,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (vehicule_id) REFERENCES vehicules(id)
);
CREATE TABLE avis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    note INT NOT NULL,
    commentaire TEXT,
    is_deleted BOOLEAN DEFAULT 0,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_id INT,
    vehicule_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (vehicule_id) REFERENCES vehicules(id)
);