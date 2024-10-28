
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
);

CREATE TABLE telefone (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,  -- Assuming you have a users table and this references it
    numero VARCHAR(15) NOT NULL,
    
    CONSTRAINT FK_user_id FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
);