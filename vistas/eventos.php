<?php
session_start();
require_once '../config/Conexion.php'; 

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener eventos
$query = "SELECT * FROM eventos"; 
$result = mysqli_query($conexion, $query); 
$events = [];
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos - QACHUU ALOOM</title>
    <link rel="stylesheet" href="../public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/fullcalendar.min.css">
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/bootstrap.min.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="container">
    <h2 class="text-center">Eventos</h2>
    
    <!-- Formulario para agregar/editar eventos -->
    <form id="eventForm">
        <input type="hidden" id="eventId" name="id">
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
        </div>
        <div class="form-group">
            <label for="fecha_inicio">Fecha Inicio</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
        </div>
        <div class="form-group">
            <label for="fecha_fin">Fecha Fin</label>
            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
        </div>
        <div class="form-group">
            <label for="ubicacion">Ubicación</label>
            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
        </div>
        <div class="form-group">
            <label for="organizador">Organizador</label>
            <input type="text" class="form-control" id="organizador" name="organizador" required>
        </div>
        <div class="form-group">
            <label for="contacto">Contacto</label>
            <input type="text" class="form-control" id="contacto" name="contacto" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="Pendiente">Pendiente</option>
                <option value="Confirmado">Confirmado</option>
                <option value="Cancelado">Cancelado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Evento</button>
    </form>

    <hr>

    <h3>Lista de Eventos</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Ubicación</th>
                <th>Organizador</th>
                <th>Contacto</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="eventList">
            <?php foreach ($events as $event): ?>
            <tr data-id="<?= $event['id'] ?>">
                <td><?= htmlspecialchars($event['titulo']) ?></td>
                <td><?= htmlspecialchars($event['descripcion']) ?></td>
                <td><?= htmlspecialchars($event['fecha_inicio']) ?></td>
                <td><?= htmlspecialchars($event['fecha_fin']) ?></td>
                <td><?= htmlspecialchars($event['ubicacion']) ?></td>
                <td><?= htmlspecialchars($event['organizador']) ?></td>
                <td><?= htmlspecialchars($event['contacto']) ?></td>
                <td><?= htmlspecialchars($event['estado']) ?></td>
                <td>
                    <button class="btn btn-warning btn-edit">Editar</button>
                    <button class="btn btn-danger btn-delete">Eliminar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    // Manejo del formulario de eventos
    $('#eventForm').on('submit', function(e) {
        e.preventDefault();

        const id = $('#eventId').val();
        const action = id ? 'update' : 'create'; // Define si es creación o actualización

        $.ajax({
            url: '../ajax/cargar_eventos.php',
            method: 'POST',
            data: $(this).serialize() + '&action=' + action, // Agrega la acción a los datos enviados
            success: function(response) {
                try {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert("Evento guardado exitosamente!");
                        location.reload();
                    } else {
                        alert("Error: " + res.message);
                    }
                } catch (e) {
                    alert("Error en la respuesta del servidor. Respuesta: " + response);
                }
            },
            error: function(xhr, status, error) {
                alert("Error en la solicitud: " + xhr.status + " " + xhr.statusText);
            }
        });
    });

    // Editar evento
    $(document).on('click', '.btn-edit', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const titulo = row.find('td:eq(0)').text();
        const descripcion = row.find('td:eq(1)').text();
        const fecha_inicio = row.find('td:eq(2)').text();
        const fecha_fin = row.find('td:eq(3)').text();
        const ubicacion = row.find('td:eq(4)').text();
        const organizador = row.find('td:eq(5)').text();
        const contacto = row.find('td:eq(6)').text();
        const estado = row.find('td:eq(7)').text();

        // Set the values in the form for editing
        $('#eventId').val(id);
        $('#titulo').val(titulo);
        $('#descripcion').val(descripcion);
        $('#fecha_inicio').val(fecha_inicio);
        $('#fecha_fin').val(fecha_fin);
        $('#ubicacion').val(ubicacion);
        $('#organizador').val(organizador);
        $('#contacto').val(contacto);
        $('#estado').val(estado);
    });

    // Eliminar evento
    $(document).on('click', '.btn-delete', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        eliminarEvento(id);
    });

    function eliminarEvento(id) {
        if (confirm("¿Estás seguro de que quieres eliminar este evento?")) {
            $.ajax({
                type: 'POST',
                url: '../ajax/cargar_eventos.php',
                data: { id: id, action: 'delete' }, // Asegúrate de que tu backend maneje este método
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert("Evento eliminado con éxito");
                        $('tr[data-id="' + id + '"]').remove(); // Elimina la fila de la tabla
                    } else {
                        alert("Error al eliminar el evento: " + response.message);
                    }
                },
                error: function() {
                    alert("Error en la conexión. Intenta nuevamente.");
                }
            });
        }
    }
});
</script>
</body>
</html>
