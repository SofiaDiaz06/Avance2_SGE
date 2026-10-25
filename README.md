# Papelería Paraíso S.A.S.
El repositorio tiene el desarrollo del segundo corte de software de gestion empresarial. Es un sistema erp hecho en laravel usando una arquitectura modular, control de roles con permisos y un dashboard con kpis para la distribuidora de productos de papelería Paraíso.

## Requisitos
Antes se debe tener instalado
**Docker y docker desktop** (para correr el laravel sail)
**Composer** (para las dependencias de php)

## Pasos para levantar el proyecto
### 1. Clonar el repositorio
Se clona este repositorio y entra a la carpeta del proyecto
```bash
git clone https://github.com/SofiaDiaz06/Avance2-SGE.git
cd Avance2-SGE
```
### 2. Configurar el archivo `.env`
Copia el archivo de configuración base para crear el propio archivo de entorno
```bash
cp .env.example .env
```

### 3. Instalar las dependencias 
Se instala las dependencias de composer
```bash
composer install
```
Se genera la llave de seguridad de la aplicación:
```bash
php artisan key:generate
```
### 4. Levantar los contenedores
Se enciende docker en segundo plano:
```bash
./vendor/bin/sail up -d
```
### 5. Migraciones y seeders
Comando para crear las tablas en la base de datos e insertar los usuarios y roles de prueba
```bash
./vendor/bin/sail artisan migrate --seed
```
Para abrir en el navegador `http://localhost`.

## Usuarios de prueba
Para probar el acceso al sistema con los diferentes roles
| Rol | Correo electrónico | Contraseña | ¿Qué puede hacer? |
| :--- | :--- | :--- | :--- |
| **Administrador** | `admin@paraiso.test` | `password` | Control total del ERP, gestión de usuarios, roles, matriz de permisos y el panel de configuración global. |
| **Almacenista** | `almacenista@test.com` | `password` | Gestión del inventario, productos, categorías, proveedores y recepción de órdenes de compra. |
| **Vendedor** | `vendedor@test.com` | `password` | Registro de ventas a clientes y consulta del catálogo de productos activos. |
