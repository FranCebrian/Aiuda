<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API DWES</title>
</head>
<body>

<h1>Bienvenido a la API DWES</h1>

<!-- Enlace para ver la lista de autores -->
<a href="http://localhost/actividad7/cliente.php?action=get_listado_autores">Ver Lista de Autores</a><br>

<!-- Enlace para ver la lista de libros -->
<a href="http://localhost/actividad7/cliente.php?action=get_listado_libros">Ver Lista de Libros</a><br><br>

<!-- Incluir la verificación de la conexión -->
<?php
include 'verificar_conexion.php';

$servidor = 'localhost';
$usuario = 'dwes';
$contrasena = 'dwes';
$basedatos = 'libros';

// Verificar la conexión a la base de datos
echo verificar_conexion($servidor, $usuario, $contrasena, $basedatos);
?>

<!-- Incluir el contenido del cliente.php -->
<?php include 'cliente.php'; ?>

</body>
</html>
