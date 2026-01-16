# Prueba Técnica Nexura

Aplicación CRUD de empleados desarrollada en PHP y MySQL.

## Requisitos
- PHP 8+
- MySQL
- XAMPP
- Navegador web

## Instalación
1. Clonar el repositorio:
   git clone https://github.com/tu-usuario/prueba-tecnica-nexura.git

2. Copiar el proyecto en:
   C:\xampp\htdocs\

3. Iniciar Apache y MySQL desde XAMPP

4. Importar la base de datos:
   - Abrir phpMyAdmin
   - Crear base de datos `nexura`
   - Importar `database/database.sql`

5. Configurar conexión:
   Archivo `config/Database.php`

6. Acceder desde el navegador:
   http://localhost/prueba-tecnica-nexura/public

## Tecnologías
- PHP (POO)
- MySQL
- HTML
- CSS
- JavaScript
- Bootstrap
- SweetAlert2

## Funcionalidades
- Crear empleado
- Editar empleado
- Eliminar empleado
- Validaciones cliente y servidor
- Relación N–N con roles

## Diccionario de Base de Datos

### Tabla: areas

| Columna | Tipo | Descripción |
|------|------|------------|
| id | int(11) | Identificador del área |
| nombre | varchar(255) | Nombre del área |

---

### Tabla: roles

| Columna | Tipo | Descripción |
|------|------|------------|
| id | int(11) | Identificador del rol |
| nombre | varchar(255) | Nombre del rol |

---

### Tabla: empleados

| Columna | Tipo | Descripción |
|------|------|------------|
| id | int(11) | Identificador del empleado |
| nombre | varchar(255) | Nombre completo del empleado |
| email | varchar(255) | Correo electrónico (único) |
| sexo | char(1) | M = Masculino, F = Femenino |
| area_id | int(11) | Área del empleado |
| boletin | int(1) | 1 = recibe boletín, 0 = no |
| descripcion | text | Experiencia del empleado |

---

### Tabla: empleado_rol

| Columna | Tipo | Descripción |
|------|------|------------|
| empleado_id | int(11) | Empleado |
| rol_id | int(11) | Rol |

---

### Relaciones
- Un empleado pertenece a un área
- Un empleado puede tener múltiples roles
- Relación N–N implementada con empleado_rol
