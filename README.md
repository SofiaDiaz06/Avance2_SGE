# Papelería Paraíso S.A.S. — Sistema de Gestión Empresarial (ERP)

Sistema ERP desarrollado en **Laravel** con arquitectura modular bajo enfoque RAD para la gestión integral de **Papelería Paraíso S.A.S.** El sistema cubre el ciclo completo de operaciones: gestión de catálogo, clientes, proveedores, ventas con facturación PDF, órdenes de compra con recepciones parciales/totales, control de inventario mediante Kardex inmutable, auditoría de cambios, control de acceso basado en roles (RBAC con rol activo), API REST autenticada, importación/exportación masiva en Excel, automatización con eventos/colas y suite de pruebas automatizadas.

---

## Requisitos Previos

Para levantar el proyecto en un entorno local mediante **Laravel Sail** solo se requiere tener instalado:

* **Git**
* **Docker y Docker Desktop** (en ejecución; en Windows se recomienda usarlo junto con **WSL2 / Ubuntu**)

> **Nota:** No es necesario tener PHP, Composer, MySQL ni Node.js instalados localmente en el equipo anfitrión, ya que todo se ejecuta dentro de los contenedores de Docker.

---

## Instalación y Puesta en Marcha (Paso a Paso)

Ejecute los siguientes comandos desde una terminal (Ubuntu/WSL2 en Windows, o terminal nativa en Linux/macOS):

### 1. Clonar el repositorio
```bash
git clone [https://github.com/SofiaDiaz06/Avance2_SGE.git](https://github.com/SofiaDiaz06/Avance2_SGE.git)
cd Avance2_SGE
```

### 2. Configurar las variables de entorno
Copie el archivo de ejemplo para generar la configuración local:
```bash
cp .env.example .env
```

### 3. Instalar dependencias de PHP (Composer vía Docker)
Dado que la carpeta `vendor/` no se versiona en Git, utilice el contenedor temporal oficial de Laravel Sail para instalar las dependencias sin requerir PHP local:
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

### 4. Levantar los contenedores de Docker (Laravel Sail)
Inicie los servicios (servidor web/PHP 8.4, MySQL 8.4 y Mailpit) en segundo plano:
```bash
./vendor/bin/sail up -d
```

### 5. Generar clave, migrar base de datos y cargar datos de prueba
```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan storage:link
```

### 6. Compilar los recursos frontend (Vite / Tailwind CSS)
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

---

## Acceso al Sistema y Servicios

Una vez completados los pasos anteriores, los servicios estarán disponibles en el navegador:

* **Aplicación ERP:** http://localhost
* **Mailpit (Bandeja de correos):** http://localhost:8025

### Credenciales de Prueba
La contraseña para todos los usuarios creados por el seeder es: **`password`**

| Rol / Perfil | Correo Electrónico | Permisos y Alcance |
| :--- | :--- | :--- |
| **Administrador** | `admin@test.com` | Acceso total a todos los módulos, configuración, roles, auditoría y reportes. |
| **Vendedor** | `vendedor@test.com` | Consulta de productos, gestión de clientes, creación y exportación de ventas. |
| **Almacenista** | `almacenista@test.com` | Gestión de productos/categorías, proveedores, compras, recepciones y Kardex. |
| **Supervisor (Multirrol)** | `supervisor@test.com` | Posee los roles `vendedor` y `almacenista` (al ingresar solicita elegir rol activo), más el permiso directo `ver-reportes`. |

---

## Procesos en Segundo Plano (Colas y Tareas Programadas)

* **Iniciar el worker de colas** (mantener en una terminal aparte mientras se prueban ventas/compras):
```bash
./vendor/bin/sail artisan queue:work
```

* **Probar el envío manual del resumen diario de gerencia:**
```bash
./vendor/bin/sail artisan erp:resumen-diario
```

* **Simular el programador de tareas (Schedule):**
```bash
./vendor/bin/sail artisan schedule:work
```

---

## Pruebas Automatizadas, Calidad de Código y API REST

* **Suite de pruebas (PHPUnit):**
```bash
./vendor/bin/sail test
```

* **Revisión de estilo de código (Laravel Pint):**
```bash
./vendor/bin/sail pint --test
```

* **Pruebas de la API REST v1 con Newman (Postman CLI):**
```bash
./vendor/bin/sail npx --yes newman run docs/api/ERP_API.postman_collection.json -e docs/api/ERP_Local.postman_environment.json
```

---

## Problemas Comunes

* **Puerto 80 o 3306 ocupado en el equipo anfitrión:** Agregar `APP_PORT=8080` y/o `FORWARD_DB_PORT=3307` en el archivo `.env` y reiniciar con `./vendor/bin/sail down && ./vendor/bin/sail up -d`.
* **Error `Unknown database 'testing'` al correr los tests:** Ejecutar `./vendor/bin/sail mysql -e "CREATE DATABASE IF NOT EXISTS testing;"`.
* **Los correos no aparecen en Mailpit:** Verificar que el worker `./vendor/bin/sail artisan queue:work` esté corriendo en otra terminal.
* **Detener los contenedores al finalizar:** Ejecutar `./vendor/bin/sail down`.