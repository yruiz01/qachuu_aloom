<?php
session_start();
require_once '../config/Conexion.php'; 

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el tipo de acción (crear, actualizar o eliminar)
$action = $_POST['action'] ?? '';

if ($action == 'create') {
    // Insertar nuevo evento
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? '';
    $ubicacion = $_POST['ubicacion'] ?? '';
    $organizador = $_POST['organizador'] ?? '';
    $contacto = $_POST['contacto'] ?? '';
    $estado = $_POST['estado'] ?? '';

    $stmt = $conexion->prepare("INSERT INTO eventos (titulo, descripcion, fecha_inicio, fecha_fin, ubicacion, organizador, contacto, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $titulo, $descripcion, $fecha_inicio, $fecha_fin, $ubicacion, $organizador, $contacto, $estado);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

} elseif ($action == 'update') {
    // Actualizar evento existente
    $id = $_POST['id'] ?? null;
    if ($id) {
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $fecha_inicio = $_POST['fecha_inicio'] ?? '';
        $fecha_fin = $_POST['fecha_fin'] ?? '';
        $ubicacion = $_POST['ubicacion'] ?? '';
        $organizador = $_POST['organizador'] ?? '';
        $contacto = $_POST['contacto'] ?? '';
        $estado = $_POST['estado'] ?? '';

        $stmt = $conexion->prepare("UPDATE eventos SET titulo=?, descripcion=?, fecha_inicio=?, fecha_fin=?, ubicacion=?, organizador=?, contacto=?, estado=? WHERE id=?");
        $stmt->bind_param("ssssssssi", $titulo, $descripcion, $fecha_inicio, $fecha_fin, $ubicacion, $organizador, $contacto, $estado, $id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
    }

} elseif ($action == 'delete') {
    // Eliminar evento
    $id = $_POST['id'] ?? null;
    
    if ($id) {
        $stmt = $conexion->prepare("DELETE FROM eventos WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
}
?>
