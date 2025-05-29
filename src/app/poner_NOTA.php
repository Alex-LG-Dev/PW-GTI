<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proa | Poner Nota</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <script src="../js/code.js" defer></script>
    <script src="../js/nombrecabezera.js" defer></script>
    <link rel="stylesheet" href="css/estilos_combinados.css">
</head>
<body>

    <?php include('encabezadoPROAprofesor.php'); ?>

<main>
<!-- ============================  MIGAS DE PAN  ============================= -->
<nav class="migas-de-pan">
  <p><a href="home-page-profesor.php">Inicio</a> &gt; Poner nota</p>
</nav>
<div class="contenedor">
    <h1>Calificar tareas Matemáticas</h1>

    <div class="encabezado-tarea">
        <h2>Tarea 1. Conjuntos y vectores</h2>
    </div>
    <!-- sistema de calificacion en cuadricula-->
    <div class="cuadricula-calificacion">
        <!-- Columna Izquierda alumnos-->
        <div class="columna-calificacion">
            <!--tarjeta de alumno 1 -->
            <div class="nombre-alumno">Nombre Alumno 1</div>
            <div class="contenedor-entrega">
                <div class="caja-entrega">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl.</p>
                </div>
                <div class="nota-wrapper">          
                    <input type="number" value="7" min="0" max="10">
                    <button class="btn-asignar">Asignar nota</button>
                </div>
            </div>
            <!--tarjeta de alumno 2 -->
            <div class="nombre-alumno">Nombre Alumno 2</div>
            <div class="contenedor-entrega">
                <div class="caja-entrega">
                    <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nullam auctor, nisl eget ultricies tincidunt.</p>
                </div>
                <div class="nota-wrapper">          
                    <input type="number" value="7" min="0" max="10">
                    <button class="btn-asignar">Asignar nota</button>
                </div>
            </div>
        </div>
        <!-- Columna Derecha -->
        <div class="columna-calificacion">
            <!--tarjeta de alumno 3 -->
            <div class="nombre-alumno">Nombre Alumno 3</div>
            <div class="contenedor-entrega">
                <div class="caja-entrega">
                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec auctor, nisl eget ultricies tincidunt.</p>
                </div>
                <div class="nota-wrapper">          
                    <input type="number" value="7" min="0" max="10">
                    <button class="btn-asignar">Asignar nota</button>
                </div>
            </div>
            <!--tarjeta de alumno 4 -->
            <div class="nombre-alumno">Nombre Alumno 4</div>
            <div class="contenedor-entrega">
                <div class="caja-entrega">
                    <p>Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Vivamus suscipit tortor eget felis porttitor volutpat.</p>
                </div>
                <div class="nota-wrapper">          
                    <input type="number" value="7" min="0" max="10">
                    <button class="btn-asignar">Asignar nota</button>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<!-- Script externo -->
</body>
</html>