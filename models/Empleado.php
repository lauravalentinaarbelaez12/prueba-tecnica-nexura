<?php

class Empleado {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listar() {
        $sql = "
        SELECT e.id, e.nombre, e.email, e.sexo, e.boletin, e.descripcion,
               a.nombre AS area,
               GROUP_CONCAT(r.nombre SEPARATOR ', ') AS roles
        FROM empleados e
        INNER JOIN areas a ON e.area_id = a.id
        LEFT JOIN empleado_rol er ON e.id = er.empleado_id
        LEFT JOIN roles r ON er.rol_id = r.id
        GROUP BY e.id
        ORDER BY e.id DESC
        ";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $stmt = $this->conn->prepare("SELECT * FROM empleados WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerRoles($id) {
        $stmt = $this->conn->prepare("SELECT rol_id FROM empleado_rol WHERE empleado_id=?");
        $stmt->execute([$id]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'rol_id');
    }

    public function crear($data) {
        $sql = "INSERT INTO empleados (nombre,email,sexo,area_id,boletin,descripcion)
                VALUES (?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        return $this->conn->lastInsertId();
    }

    public function actualizar($data) {
        $sql = "UPDATE empleados SET nombre=?, email=?, sexo=?, area_id=?, boletin=?, descripcion=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
    }

    public function limpiarRoles($id) {
        $stmt = $this->conn->prepare("DELETE FROM empleado_rol WHERE empleado_id=?");
        $stmt->execute([$id]);
    }

    public function asignarRol($empleado, $rol) {
        $stmt = $this->conn->prepare("INSERT INTO empleado_rol VALUES (?,?)");
        $stmt->execute([$empleado, $rol]);
    }

    public function eliminar($id) {
        $this->limpiarRoles($id);
        $stmt = $this->conn->prepare("DELETE FROM empleados WHERE id=?");
        $stmt->execute([$id]);
    }
    
    public function emailExiste($email)
{
    $stmt = $this->conn->prepare("SELECT id FROM empleados WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
