CREATE DATABASE games;
USE games;

CREATE TABLE generos(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE jogos(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(200) NOT NULL,
  imagem VARCHAR(255) NULL,
  generos_id INT NOT NULL REFERENCES generos(id)
);

CREATE TABLE plataformas(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL
);

CREATE TABLE plataformas_executam_jogos(
  plataformas_id INT NOT NULL REFERENCES plataformas(id),
  jogos_id INT NOT NULL REFERENCES jogos(id),
  PRIMARY KEY(plataformas_id, jogos_id)
);