Tennis Tournament Simulation

Este proyecto simula un torneo de tenis. Permite ingresar una cantidad de jugadores y ver el desarrollo del torneo, incluyendo las rondas, juegos y el ganador final.

Requisitos:
- PHP >= 8.0
- Composer
- Node.js y NPM

Instalación:
1. Clonar el repositorio:
   git clone https://github.com/NahuelSavedra/tennis-tournament.git
   cd tennis-tournament

2. Instalar dependencias de PHP:
   composer install

3. Instalar dependencias de Node.js:
   npm install
   npm run dev

4. Configurar el archivo .env:
   cp .env.example .env

5. Generar la clave de la aplicación:
   php artisan key:generate

6. Migrar la base de datos:
   php artisan migrate

7. Levantar el servidor:
   php artisan serve
   El servidor estará disponible en http://localhost:8000.

Simulación del Torneo:
Se puede probar la simulación del torneo accediendo a la ruta /tournament.

1. Ingresar el número de jugadores:
   Visita http://localhost:8000/tournament para ingresar la cantidad de jugadores. Asegúrate de que el número sea una potencia de 2 (2, 4, 8, 16, etc.).

2. Ver el desarrollo del torneo:
   Después de ingresar el número de jugadores, se mostrará el desarrollo del torneo, incluyendo las rondas, juegos y el ganador final.
