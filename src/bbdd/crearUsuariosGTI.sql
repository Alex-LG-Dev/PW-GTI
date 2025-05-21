-- crearUsuariosGTI.sql


CREATE TABLE `UsuariosGTI` (
                            `id` int(11) NOT NULL,
                            `nombre` varchar(60) NOT NULL,
                            `email` varchar(254) NOT NULL,
                            `password` varchar(64) NOT NULL,
                            `estado` tinyint(1) NOT NULL DEFAULT 0,
                            `token` varchar(36) DEFAULT NULL,
                            `validez_token` datetime DEFAULT NULL
)