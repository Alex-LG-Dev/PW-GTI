-- insertarPersonas.sql

INSERT INTO `UsuariosGTI` (`id`, `nombre`, `email`, `password`, `estado`, `token`, `validez_token`) 
VALUES 
(1, 'prueba1', 'prueba1@gmail.es', 'prueba1pass', 1, '123e4567-e89b-12d3-a456-426614174001', '2025-06-01 12:00:00'),
(2, 'prueba2', 'prueba2@gmail.es', 'prueba2pass', 0, '123e4567-e89b-12d3-a456-426614174002', '2025-06-01 12:00:00'),
(3, 'prueba3', 'prueba3@gmail.es', 'prueba3pass', 1, '123e4567-e89b-12d3-a456-426614174003', '2025-06-01 12:00:00');

