<?php 
include("conexion.php");
$con = conectar();

// Obtener todos los alumnos
$sql = "SELECT * FROM alumnos ORDER BY nombre";
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Cargar Alumnos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <style>
         header {
            width: 100%;
            background-color: #e3f2fd;
            border-bottom: 2px solid #007BFF; /* Borde celeste */
            display: flex;
            align-items: center;
            padding: 10px;
        }
        .logo {
            width: 150px;
            margin-right: 20px; /* Margen más alejado del logo */
        }
        .header-line {
            flex-grow: 1;
            height: 13vh;
            background-color: #007BFF; /* Color del borde */
            display: flex;
            justify-content: center;
            align-items: center; /* Centrar vertical y horizontalmente */
            color: white; /* Color del texto */
        }
        
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $.ajax({
                    url: "buscar.php",
                    type: "POST",
                    data: {search: value},
                    success: function(data){
                        $("#tabla").html(data);
                    }
                });
            });
        });
    </script>
</head>
<body><header>
        <img src="logo.jpeg" alt="Logo" class="logo">
        <div class="header-line"><h2>Instituto</h2></div>
    </header>
    <div class="container mt-5">
        <div class="row"> 
            <div class="col-md-3">
                <h1>Ingrese datos</h1>
                <form action="insertar.php" method="POST">
                    <input type="text" class="form-control mb-3" name="dni" placeholder="Dni" required>
                    <input type="text" class="form-control mb-3" name="nombre" placeholder="Nombres y Apellido" required>
                    <input type="text" class="form-control mb-3" name="telefono" placeholder="Telefono" required>
                    <input type="text" class="form-control mb-3" name="direccion" placeholder="Dirección" required>
                    <input type="text" class="form-control mb-3" name="carrera" placeholder="Carrera" required>
                    <input type="submit" class="btn btn-primary">
                </form>
            </div>

            <div class="col-md-8">
                <div style="display: flex; align-items: center;">
                    <h4 style="margin-right: 20px;">Buscar</h4>
                    <input type="text" id="search" placeholder="nombre o dni">
                </div>
                
                <table class="table" id="tabla">
                    <thead class="table-success table-striped">
                        <tr>
                            <th>Dni</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th>Dirección</th>
                            <th>Carrera</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($query && mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row["dni"]) . "</td>
                                        <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                        <td>" . htmlspecialchars($row["telefono"]) . "</td>
                                        <td>" . htmlspecialchars($row["direccion"]) . "</td>
                                        <td>" . htmlspecialchars($row["carrera"]) . "</td>
                                        <td>
                                            <a href='actualizar.php?id=" . $row['id'] . "' class='btn btn-info'>Editar</a>
                                            <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger'>Eliminar</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No se encontraron resultados</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
