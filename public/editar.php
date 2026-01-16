<?php
session_start();
require_once "../config/Database.php";
require_once "../models/Empleado.php";

$db = (new Database())->connect();
$empleado = new Empleado($db);

$edit = isset($_GET['id']);
$data = $edit ? $empleado->obtener($_GET['id']) : [];
$rolesSel = $edit ? $empleado->obtenerRoles($_GET['id']) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title><?= $edit?'Editar':'Crear' ?> empleado</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<div class="container mt-5 col-md-6">
<h3><?= $edit?'Editar':'Crear' ?> empleado</h3>

<form method="POST" action="../controllers/EmpleadoController.php" onsubmit="return validar()">
<?php if($edit): ?><input type="hidden" name="id" value="<?= $data['id'] ?>"><?php endif; ?>

<input class="form-control mb-2" name="nombre" placeholder="Nombre" value="<?= $data['nombre']??'' ?>">
<input class="form-control mb-2" name="email" placeholder="Email" value="<?= $data['email']??'' ?>">

<div class="mb-2">
<input type="radio" name="sexo" value="M" <?= ($data['sexo']??'')=='M'?'checked':'' ?>> Masculino
<input type="radio" name="sexo" value="F" <?= ($data['sexo']??'')=='F'?'checked':'' ?>> Femenino
</div>

<select name="area_id" class="form-select mb-2">
<option value="">Seleccione área</option>
<?php foreach($db->query("SELECT * FROM areas") as $a): ?>
<option value="<?= $a['id'] ?>" <?= ($data['area_id']??'')==$a['id']?'selected':'' ?>>
<?= $a['nombre'] ?>
</option>
<?php endforeach; ?>
</select>

<textarea name="descripcion" class="form-control mb-2"><?= $data['descripcion']??'' ?></textarea>

<label><input type="checkbox" name="boletin" <?= ($data['boletin']??0)?'checked':'' ?>> Recibir boletín</label>

<hr>
<?php foreach($db->query("SELECT * FROM roles") as $r): ?>
<label>
<input type="checkbox" name="roles[]" value="<?= $r['id'] ?>" <?= in_array($r['id'],$rolesSel)?'checked':'' ?>>
<?= $r['nombre'] ?>
</label><br>
<?php endforeach; ?>

<button class="btn btn-primary mt-3">Guardar</button>
<a href="index.php" class="btn btn-secondary mt-3">Cancelar</a>
</form>
</div>

<script>
function validar() {

    const nombre = document.querySelector('input[name="nombre"]').value.trim();
    const email = document.querySelector('input[name="email"]').value.trim();
    const sexo = document.querySelector('input[name="sexo"]:checked');
    const area = document.querySelector('select[name="area_id"]').value;
    const descripcion = document.querySelector('textarea[name="descripcion"]').value.trim();
    const roles = document.querySelectorAll('input[name="roles[]"]:checked');

    // VALIDAR CAMPOS OBLIGATORIOS
    if (
        nombre === '' ||
        email === '' ||
        !sexo ||
        area === '' ||
        descripcion === '' ||
        roles.length === 0
    ) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Debe completar todos los campos obligatorios',
            confirmButtonText: 'OK'
        });
        return false;
    }

    // VALIDAR EMAIL
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ingrese un correo electrónico válido',
            confirmButtonText: 'OK'
        });
        return false;
    }

    return true;
}
</script>

</body>
</html>
