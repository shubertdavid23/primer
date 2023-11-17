<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="estilomenuempresa.css">
    <title>Menu Empresa</title>
</head>

<body>
    <header>
        <div class="logo-container">
            <img class="logo" src="logo_empresa.png" alt="Logo de la Empresa">
        </div>
        <div class="header-center">
            <h1>Empresas</h1>
        </div>
        <div class="header-right">
            <button class="dropdown-btn">Opciones</button>
            <div class="dropdown-content">
                <a href="#">Contacto</a>
                <a href="#">Mi Perfil</a>
            </div>
        </div>
    </header>

    <section class="publicar-oferta">
        <h2>Publicar Oferta Laboral</h2>
        <form id="publicar-oferta-form" action="procesar_oferta.php" method="POST" onClick="() => alert(2)">
            <!-- Campos del formulario para publicar una oferta -->
            <label for="titulo">Título de la Oferta:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="tareas">Tareas a Desempeñar:</label>
            <textarea id="tareas" name="tareas" rows="4" required></textarea>

            <label for="remuneracion">Remuneración:</label>
            <input type="text" id="remuneracion" name="remuneracion" required>

            <label for="area">Área:</label>
            <select id="area" name="area" required>
                <option value="informatica">Informática</option>
                <option value="industrial">Industrial</option>
                <option value="administracion">Administración</option>
            </select>

            <label for="fecha_inicio">Fecha de Inicio Estimado:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_final">Fecha Final:</label>
            <input type="date" id="fecha_final" name="fecha_final" required>

            <label for="duracion">Duración:</label>
            <input type="text" id="duracion" name="duracion" required>

            <label for="detalles">Detalles:</label>
            <textarea id="detalles" name="detalles" rows="4" required></textarea>

            <button type="submit">Publicar Oferta</button>
        </form>
    </section>

    <section class="ofertas-publicadas">
        <h2>Ofertas Publicadas</h2>
        <?php 
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        session_start();
        include("conexion.php");

        $sqlOfertas = "select * from ofertas";
        $sqlJoin = "SELECT ofertas.*, postulantes.* FROM ofertas JOIN postulantes ON ofertas.id = postulantes.oferta_id";
        $sqlResult = $conexion->query($sqlJoin);
        $ofertasData = $conexion->query($sqlOfertas);

        while($filaJoin = $sqlResult->fetch_assoc()) {
            $name = $filaJoin["nombre_apellido"];
            echo $name;
        }

        while($fila = $ofertasData->fetch_assoc()) {
            $titulo = $fila["titulo"];
            $tareas = $fila["tareas"];
            echo "<div class='oferta-box' style='border: 1px solid black; padding: 20px; border-radius:10px; margin-bottom: 10px; width: 30rem'>";
            echo "<h1>" . $titulo . "</h1>";
            echo "<p>" . $tareas . "</p>";
            echo "</div>";
        }

        ?>
    </section>

    <section class="detalle-ofertas">
        <!-- Modal con detalles de ofertas (cuando clickeas una oferta) -->
        <div id="modal-oferta" style="display: none; backdrop-filter: blur(5px); align-items: center; justify-content: center; 
        position: fixed; top: 0; left:0; width: 100%; height: 100vh">
        <div style="border: 1px solid black;background:white;border-radius:10px;width:fit-content;padding:20px">
        <span>Titulo</span>

        <button id="closeModal" style="background:#46e722;border:none;padding:10px">Cerrar</button>
        </div>
        </div>

    <h2> Detalle Ofertas</h2>
        <!-- Aquí se mostraría la información detallada de la oferta al hacer clic en un enlace -->
        <!-- Ejemplo de sección detallada: <div id="detalle-oferta1">Detalle de la oferta</div> -->
    </section>

    <footer>
        <!-- Contenido del pie de página -->
    </footer>

    <script>
        const els = document.querySelectorAll(".oferta-box")
        const modalBox = document.getElementById("modal-oferta")
        document.getElementById("closeModal").addEventListener("click", () => {
            modalBox.style.display = "none"
        })
        els.forEach(el => {
            el.addEventListener("click", () => {
                modalBox.children[0].children[0].innerText = el.children[0].innerText
                document.getElementById("modal-oferta").style.display = "flex"
            })
        })
    </script>
</body>

</html>

