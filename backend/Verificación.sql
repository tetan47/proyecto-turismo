CREATE Table if NOT EXISTS cliente(
    ID_Cliente INT(11) AUTO_INCREMENT PRIMARY KEY UNIQUE,
    Nombre VARCHAR(20) NOT NULL,
    Apellido VARCHAR(30) NOT NULL,
    Correo VARCHAR(50) NOT NULL UNIQUE,
    Contraseña VARCHAR(50) NOT NULL,
    Registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE Table if NOT EXISTS organizadores(
    Cédula INT(10) PRIMARY KEY UNIQUE,
    RUT VARCHAR(15) NOT NULL UNIQUE,
    Telefono VARCHAR(20) NOT NULL,
    ID_Cliente INT(11),
    FOREIGN KEY (ID_Cliente) REFERENCES cliente(ID_Cliente);
);

CREATE Table if NOT EXISTS administradores(
    ID_Administrador INT(11) AUTO_INCREMENT PRIMARY KEY UNIQUE,
    Nombre VARCHAR(25) NOT NULL,
    Apellido VARCHAR(25) NOT NULL,
    Correo VARCHAR(50) NOT NULL UNIQUE,
    Contraseña VARCHAR(35) NOT NULL,
    Telefono VARCHAR(25) NOT NULL,
    Activo BOOLEAN DEFAULT TRUE,
);

CREATE Table if NOT EXISTS eventos(
    ID_Evento INT(11) AUTO_INCREMENT PRIMARY KEY UNIQUE,
    Título VARCHAR(50) NOT NULL,
    Descripción VARCHAR(200) TEXT NOT NULL,
    Creacion_Evento DATE NOT NULL,
    Hora TIME NOT NULL,
    Ubicación VARCHAR(50) NOT NULL,
    Cédula INT(10),
    FOREIGN KEY (Cédula) REFERENCES organizadores(Cédula);
);

CREATE Table if NOT EXISTS comentarios(
    ID_Comentario INT(11) AUTO_INCREMENT PRIMARY KEY UNIQUE,
    ID_Cliente INT(11),
    FOREIGN KEY (ID_Cliente) REFERENCES cliente(ID_Cliente);
    ID_Evento INT(11),
    FOREIGN KEY (ID_Evento) REFERENCES eventos(ID_Evento);
    Cédula INT(10),
    FOREIGN KEY (Cédula) REFERENCES organizadores(Cédula);
    Texto VARCHAR(250) NOT NULL,
    Creación_Comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Valoración INT(1) NOT NULL CHECK (Valoración BETWEEN 1 AND 5);
);

CREATE Table if NOT EXISTS administra_eventos(
    ID_Administrador INT(11),
    FOREIGN KEY (ID_Administrador) REFERENCES administradores(ID_Administrador);
    ID_Evento INT(11),
    FOREIGN KEY (ID_Evento) REFERENCES eventos(ID_Evento);
    Cédula INT(10),
    FOREIGN KEY (Cédula) REFERENCES organizadores(Cédula);
    Organizador_Verificado BOOLEAN DEFAULT FALSE,
    Evento_Verificado BOOLEAN DEFAULT FALSE,
);

