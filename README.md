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
