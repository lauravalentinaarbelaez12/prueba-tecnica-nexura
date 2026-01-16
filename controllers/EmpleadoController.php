<?php
session_start();
require_once "../config/Database.php";
require_once "../models/Empleado.php";

$db = (new Database())->connect();
$empleado = new Empleado($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        empty($_POST['nombre']) ||
        !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ||
        empty($_POST['sexo']) ||
        empty($_POST['area_id']) ||
        empty($_POST['descripcion']) ||
        empty($_POST['roles'])
    ) {
        $_SESSION['mensaje'] = "Debe completar todos los campos ❌";
        header("Location: ../public/crear.php");
        exit;
    }

    $data = [
        $_POST['nombre'],
        $_POST['email'],
        $_POST['sexo'],
        $_POST['area_id'],
        isset($_POST['boletin']) ? 1 : 0,
        $_POST['descripcion']
    ];

    if (isset($_POST['id'])) {
        $data[] = $_POST['id'];
        $empleado->actualizar($data);
        $empleado->limpiarRoles($_POST['id']);
        $id = $_POST['id'];
        $msg = "Empleado actualizado correctamente ✅";
    } else {
        $id = $empleado->crear($data);
        $msg = "Empleado creado correctamente ✅";
    }

    foreach ($_POST['roles'] as $rol) {
        $empleado->asignarRol($id, $rol);
    }

    $_SESSION['mensaje'] = $msg;
    header("Location: ../public/index.php");
    
    // VALIDAR EMAIL DUPLICADO
if ($empleado->emailExiste($_POST['email'])) {
    $_SESSION['mensaje'] = 'El correo electrónico ya está registrado ❌';
    $_SESSION['tipo'] = 'error';
    header("Location: ../public/crear.php");
    exit;
}

}
