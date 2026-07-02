# insurancePdf

## Requisitos

- PHP 8.2+
- Composer
- Node.js 18+
- pnpm
- MySQL o una base de datos compatible con Laravel

## Instalación

1. Clona el repositorio y entra al proyecto.
2. Instala las dependencias de PHP:
   ```bash
   composer install
   ```
3. Instala las dependencias de JavaScript:
   ```bash
   pnpm install
   ```
4. Copia el archivo de entorno:
   ```bash
   cp .env.example .env
   ```
   Si no existe .env.example, crea un archivo .env manualmente con la configuración básica de Laravel.
5. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```
6. Configura la base de datos en el archivo .env.
7. Ejecuta las migraciones:
   ```bash
   php artisan migrate
   ```

## Ejecutar el proyecto

Inicia el servidor de Laravel:
```bash
php artisan serve
```

En otra terminal, inicia Vite para los assets frontend:
```bash
pnpm dev
```

La aplicación quedará disponible en la URL que muestre Artisan, normalmente http://127.0.0.1:8000.

## Uso del script Python para unir PDFs

El proyecto incluye el script `scripts/merge_pdf.py` para combinar varios archivos PDF en uno solo.

1. Instala la dependencia de Python `pikepdf`:
   ```bash
   pip3 install pikepdf --break-system-packages
   ```

## Comandos útiles

- Ejecutar pruebas:
  ```bash
  php artisan test
  ```
- Formatear código PHP:
  ```bash
  ./vendor/bin/pint
  ```
