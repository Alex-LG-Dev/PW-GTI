<?php
session_start();
include("../bbdd/conexionbasesPROA.php");

// Validación de sesión
if (!isset($_SESSION['dni']) || $_SESSION['rol'] !== 'profesor') {
    echo "<p>Error: Sesión no iniciada.</p>";
    exit();
}

$dni = $_SESSION['dni'];
?>

<header class="encabezado">
    <!-- Logo -->
    <div class="contenedor-logo">
        <a href="home-page-profesor.php"><img src="../img/Logo-Proa.png" alt="Logo de PROA" class="logotipo"></a>
    </div>

    <!-- Menú desplegable de asignaturas -->
    <nav class="navegacion">
        <details class="desplegable">
            <summary class="boton-desplegable" id="boton-desplegable-header">ASIGNATURAS</summary>

            <div class="panel-asignaturas">
                <h3>Asignaturas Matriculadas 24/25</h3>

                <!-- Curso 1º -->
                <details class="curso">
                    <summary class="titulo-curso">1º</summary>

                    <?php
                    $sql = "
                        SELECT a.ID_asignatura, a.nombre 
                        FROM asignaturas a
                        INNER JOIN matriculas_profesor mp ON mp.ID_asignatura = a.ID_asignatura
                        WHERE mp.DNI = ?
                        ORDER BY a.nombre ASC
                    ";
                    $stmt = $conex->prepare($sql);
                    $stmt->bind_param("s", $dni);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    while ($asig = $res->fetch_assoc()):
                    ?>
                        <a href="Asignatura_Seleccionada_Profesor.php?id=<?= $asig['ID_asignatura'] ?>">
                            <?= htmlspecialchars($asig['nombre']) ?>
                        </a>
                    <?php endwhile; ?>
                </details>
            </div>
        </details>
    </nav>
    <!-- Info usuario -->
    <div class="contenedor-usuario">
        <a class="username"><?= isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Profesor' ?></a>
        <img src="../img/user.png" alt="Avatar de usuario" class="icono">
        <a href="loginPROA.php"><img src="../img/cerrarsesionGTI.png" alt="Cerrar sesión" class="icono icono-cerrar-sesion"></a>
    </div>
</header>
