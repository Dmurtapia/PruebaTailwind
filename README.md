## Ejecutar proyecto
- abrir cmd y:
cd C:\Users\Dmur\Documents\proyectosPHP\pruebaTailwind
npm run dev

## Seguido en la terminal de VS CODE
php artisan serve

## Borrar cache
php artisan optimize:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear
php artisan serve


## Comandos para iniciar repositorio en GitHub 
git init
git add .
git commit -m "Primer commit"
git branch -M main
git remote add origin https://github.com/Dmurtapia/PruebaTailwind.git
git push -u origin main

## Comandos para subir cambios a GitHub
git add .
git commit -m "Descripción de los cambios"
git push

## Recibir cambios
git pull 
git pull origin main

## Comandos para instalar Laravel
php -v
composer -V

composer global require laravel/installer
laravel new miProyecto

cd miProyecto
php artisan serve

## Instalar Tailwind
npm install
npm run dev

## Comandos para base de datos 
php artisan make:migration create_tickets_table
php artisan migrate
