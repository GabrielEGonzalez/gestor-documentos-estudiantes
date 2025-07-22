¡Genial, Gabo! Ya lo tenés clarísimo y estás bien motivado. Vamos a **reordenar, corregir y dejarte el proyecto limpio, realista y sin usar MVC**, pero con buena organización modular.

---

## 📦 Estructura Final del Proyecto (Sin usar MVC, pero limpio)

```
gestor-documentos-estudiantes/
│
├── config.php                 # Conexión a la base de datos
│
├── login.php                  # Login + lógica y formulario
├── register.php               # Registro + lógica y formulario
├── dashboard.php              # Panel del estudiante
├── admin.php                  # Panel del profesor (admin)
├── upload.php                 # Procesamiento de subida de archivos
├── delete.php                 # Procesamiento de borrado de archivos
├── logout.php                 # Cerrar sesión
│
├── uploads/                   # Carpeta donde se guardan archivos subidos
│
├── includes/
│   ├── header.php             # Encabezado y navbar
│   └── footer.php             # Pie de página
│
├── css/
│   └── styles.css             # Estilos CSS
│
├── js/
│   └── scripts.js             # Validaciones JS (opcional)
│
└── index.php                  # Redirección según sesión
```



---

## 🔐 Flujo del Sistema

1. `index.php`: Detecta si el usuario está logueado y redirige a `dashboard.php` o `admin.php` según el rol.
2. `register.php`: Formulario de registro y lógica de inserción a la tabla `usuarios`.
3. `login.php`: Validación del login y almacenamiento en `$_SESSION`.
4. `dashboard.php`: Panel de estudiante para subir/ver/borrar archivos propios.
5. `admin.php`: Panel de profesor que lista todos los archivos subidos por todos.
6. `upload.php`: Lógica para subir archivo, renombrar si ya existe y guardar en BD.
7. `delete.php`: Lógica para eliminar archivo físico y en BD.
8. `logout.php`: Destruye la sesión.
9. `includes/header.php` y `footer.php`: Incluidos para no repetir HTML base.

---

## 🧾 CheckList Etapas de Desarrollo

### Etapa 1: Autenticación (login & registro)

* [ ] Formulario de login (`login.php`)
* [ ] Formulario de registro (`register.php`)
* [ ] Validaciones básicas (correo único, contraseña mínima)
* [ ] Iniciar sesión y guardar `$_SESSION['usuario_id']` y `$_SESSION['rol']`
* [ ] Redirigir según rol

---

### Etapa 2: Subida de archivos (estudiante)

* [ ] Crear formulario de subida en `dashboard.php`
* [ ] Validar tipo (`pdf`, `doc`, `docx`) y tamaño (<10MB)
* [ ] Renombrar si existe (añadir timestamp o sufijo)
* [ ] Mover a `/uploads` y guardar en BD
* [ ] Mostrar mensaje de éxito

---

### Etapa 3: Listar archivos del estudiante

* [ ] Mostrar tabla con sus archivos
* [ ] Mostrar fecha de subida
* [ ] Botón de eliminar archivo
* [ ] Lógica en `delete.php` para eliminar físicamente + en BD

---

### Etapa 4: Panel del profesor (admin)

* [ ] Listar todos los archivos
* [ ] Mostrar nombre del estudiante (JOIN entre archivos y usuarios)
* [ ] Filtro por estudiante (opcional)
* [ ] Descarga de archivos

---

### Etapa 5 (Opcional): PHPMailer

* [ ] Enviar correo al subir archivo
* [ ] Usar cuenta SMTP (Gmail, por ejemplo)

---

### Etapa 6 (Opcional): Diseño

* [ ] Agregar Bootstrap o Tailwind
* [ ] Hacer responsive los paneles
* [ ] Mejorar UI para CV y GitHub

---

## 🧑‍💻 ¿Cómo seguimos?

### ✅ Si querés iniciar ya:

Puedo ayudarte con el primer archivo: `config.php`, luego el `register.php` (formulario + lógica).

### ✍️ O si preferís avanzar solo:

Te doy los archivos base vacíos con `// TODO` y tú los vas llenando.

---

¿Querés que comencemos ya por la **base de datos + archivo de conexión `config.php`**, y luego pasamos al **registro con hash de contraseña y sesión**? ¿O preferís primero que te prepare todos los archivos iniciales vacíos con estructura limpia?

Vos decidís el ritmo.
