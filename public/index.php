<?php
session_start();
require_once "../config/Database.php";
require_once "../models/Empleado.php";

$db = (new Database())->connect();
$empleado = new Empleado($db);
$lista = $empleado->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Lista de empleados</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<div class="container mt-5">

<div class="d-flex justify-content-between mb-3">
<h3>Lista de empleados</h3>
<a href="crear.php" class="btn btn-primary"><i class="fa fa-plus"></i> Crear</a>
</div>

<table class="table table-striped">
<thead>
<tr>
<th>Nombre</th><th>Email</th><th>Sexo</th><th>Área</th>
<th>Boletín</th><th>Roles</th><th>Modificar</th><th>Eliminar</th>
</tr>
</thead>
<tbody>
<?php foreach($lista as $e): ?>
<tr>
<td><?= $e['nombre'] ?></td>
<td><?= $e['email'] ?></td>
<td><?= $e['sexo']=='F'?'Femenino':'Masculino' ?></td>
<td><?= $e['area'] ?></td>
<td><?= $e['boletin']?'Sí':'No' ?></td>
<td><?= $e['roles'] ?></td>
<td class="text-center">
<a href="editar.php?id=<?= $e['id'] ?>" class="text-primary"><i class="fa fa-pen"></i></a>
</td>
<td class="text-center">
<button onclick="eliminar(<?= $e['id'] ?>)" class="btn btn-link text-danger">
<i class="fa fa-trash"></i>
</button>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<?php if(isset($_SESSION['mensaje'])): ?>
<script>
Swal.fire({
    icon:'success',
    title:'<?= $_SESSION['mensaje'] ?>'
});
</script>
<?php unset($_SESSION['mensaje']); endif; ?>

<script>
function eliminar(id){
Swal.fire({
title:'¿Eliminar empleado?',
input:'text',
inputPlaceholder:'Escriba eliminar',
showCancelButton:true,
preConfirm:(v)=>{ if(v!=='eliminar') Swal.showValidationMessage('Debe escribir eliminar') }
}).then(r=>{
if(r.isConfirmed) location.href='eliminar.php?id='+id;
});
}
</script>
</body>
</html>
