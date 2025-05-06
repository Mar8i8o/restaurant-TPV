
# Cook Code Systems - Restaurante

Dashboard de la parte de restaurante de la aplicación. Sus funciones principales son mostrar estadísticas de uso y eficiencia de los productos, gestión del stock, actuar de API para pistolas escáner, mostrar recetas disponibles, mostrar pedidos realizados y su estado.

## RoadMap
En general falta una gran cantidad de trabajo por la parte de backend.
 - [ ] Dashboard
	 - [x] Maquetado
	 - [ ] Gráficos *(Los gráficos están preparados para que solo quede hacer el fetch de los datos e incluirlos)*
 - [ ] Analytics
 	 - [ ] Maquetado
	 - [x] Tabla de log en DB
	 - [ ] Registrar todo cambio en stock
 - [ ] Stock
	 - [x] Visualización
	 - [ ] Modificación
	 - [ ] Filtrado
 - [ ] Receipts
	 - [ ] Fetch de recetas de la parte de cocina
	 - [ ] Mostrar rápidamente si hay stock para realizar x receta
 - [ ] Orders
	 - [ ] Conexión con WooCommerce 
 - [ ] TPV
 - [ ] Settings
	 - [x] Cerrar sesión
	 - [ ] Información relevante
	 - [ ] Cambiar contraseña/correo
- [x] Base de datos
	- [x] Tablas principales para stock, usuarios, estadísticas...
	- [x] Tablas de tipado (unidades, monedas...)
	- [x] Relación de tablas

## Ya realizado
Algunas de las herramientas/scritps que se han hecho ya para no tener que repetir trabajo:
- [x] Creación de ventanas popup (createWindow)
- [x] Componente para las recetas (Recipe)
- [x] Componente para los logins de los restaurantes en restaurants (RestaurantLogin)
- [ ] Utils
	- [x] Login a restaurante
	- [x] Login a restaurante como admin
	- [x] Fetch de datos de usuario
	- [x] Crear usuario
	- [x] Fetch de todos los usuarios de un restaurante
	- [x] LogOut
	- [x] Fetch de stock de restaurante
	- [x] Eliminar stock por ID
- [x] Verificar usuario loggeado (php/verifyLogged.php)
- [ ] Clases para DB
	- [x] Fetch todo el stock de un restaurante
	- [x] Fetch 1 stock en concreto
	- [x] Eliminar 1 stock 
	- [x] Crear usuario
	- [x] Leer usuario
	- [x] Login usuario
	- [x] Login Admin

## Estructura de carpetas
```plaintext
/restaurant/
|-- db/
|   |-- Entity/        * Clases para tareas de cada tabla
|   |-- autoload.php   * Importar esto importa todas las herramientas necesarias
|	|-- Database.php   * Clase principal de la base de datos
|
|-- php/               * "Utils" para backend
|-- services/          * Conexión a servicios externos (broker mqtt)
|-- public/           
|   |-- css/
|   |-- js/
|   |-- api/           * APIs PHP
|   |-- fonts/
|   |-- img/
|   |-- svg/
|
|-- index.php          * Control de acceso inicial
```

## Tecnologías usadas

- Frontend JS
- Backend PHP
- SASS En los estilos
- MySQL
- Apache/wampp

Librerías:
- ChartJs: Para los gráficos del dashboard. (instalado con composer por tema de versiones, podría usarse con npm)
- php-mqtt: Para el cliente mqtt (Debería substituirse en un futuro con un broker que redirija los mensajes a una API HTTP.
- monolog: Logger. (AppLog.log)

## Instalación

1. Clonar repositorio en el para que la ruta quede: "localhost/restaurant/public/..."
2. Instalar dependencias de composer

