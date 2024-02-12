<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API DWES</title>
</head>
<body>

<?php
if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_autor") 
{
    // Obtener información del autor
    $app_info = file_get_contents('http://localhost/actividad7/api.php?action=get_datos_autor&id=' . $_GET["id"]);
    $app_info = json_decode($app_info);
?>
    <p>
        <strong>Nombre:</strong> <?php echo $app_info->datos->nombre; ?><br>
        <strong>Apellidos:</strong> <?php echo $app_info->datos->apellidos; ?><br>
        <strong>Nacionalidad:</strong> <?php echo $app_info->datos->nacionalidad; ?><br>
    </p>
    <h3>Libros del Autor</h3>
    <ul>
    <?php foreach($app_info->libros as $libro): ?>
        <li>
            <a href="<?php echo "http://localhost/actividad7/cliente.php?action=get_datos_libro&id=" . $libro->id ?>">
                <?php echo $libro->titulo ?>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
    <br />
    <a href="http://localhost/actividad7/cliente.php?action=get_listado_autores" alt="Lista de autores">Volver a la lista de autores</a>
<?php
}
else if (isset($_GET["action"]) && $_GET["action"] == "get_datos_libro") 
{
    // Obtener información del libro
    $app_info = file_get_contents('http://localhost/actividad7/api.php?action=get_datos_libro&id=' . $_GET["id"]);
    $app_info = json_decode($app_info);
?>
    <p>
        <strong>Título del libro:</strong> <?php echo $app_info->datos->titulo; ?><br>
        <strong>Fecha de Publicación:</strong> <?php echo $app_info->datos->f_publicacion; ?><br>
        <strong>ID del Autor:</strong> <?php echo $app_info->datos->id_autor; ?><br>
        <strong>Nombre del Autor:</strong> 
        <!-- Enlazar el nombre del autor con su información específica -->
        <a href="<?php echo "http://localhost/actividad7/cliente.php?action=get_datos_autor&id=" . $app_info->datos->id_autor ?>">
            <?php echo $app_info->nombre_autor . " " . $app_info->apellidos_autor; ?>
        </a>
    </p>
    <br />
    <a href="http://localhost/actividad7/cliente.php?action=get_listado_autores" alt="Lista de autores">Volver a la lista de autores</a>
<?php
}
else //sino muestra la lista de autores
{
    // Obtener lista de autores de la API
    $lista_autores = file_get_contents('http://localhost/actividad7/api.php?action=get_listado_autores');
    $lista_autores = json_decode($lista_autores);
?>
    <h2>Lista de Autores</h2>
    <ul>
    <?php foreach($lista_autores as $autor): ?>
        <li>
            <a href="<?php echo "http://localhost/actividad7/cliente.php?action=get_datos_autor&id=" . $autor->id  ?>">
                <?php echo $autor->nombre . " " . $autor->apellidos ?>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>

    <!-- Agregar lista de libros -->
    <?php
    $lista_libros = file_get_contents('http://localhost/actividad7/api.php?action=get_listado_libros');
    $lista_libros = json_decode($lista_libros);
    ?>
    
    <h2>Lista de Libros</h2>

    <ul>
        <?php foreach($lista_libros as $libro): ?>
            <li>
                <a href="<?php echo "http://localhost/actividad7/cliente.php?action=get_datos_libro&id=" . $libro->id ?>">
                    <?php echo $libro->titulo ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    
<?php
} ?>
</body>
</html>
