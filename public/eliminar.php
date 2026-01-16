<?php
session_start();
require_once "../config/Database.php";
require_once "../models/Empleado.php";

$db=(new Database())->connect();
$empleado=new Empleado($db);

$empleado->eliminar($_GET['id']);
$_SESSION['mensaje']="Empleado eliminado correctamente ✅";
header("Location: index.php");
