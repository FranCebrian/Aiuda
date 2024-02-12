<?php
require("Libros.php");
// Esta API tiene dos posibilidades; Mostrar una lista de autores o mostrar la información de un autor específico.

$servidor = 'localhost';
$usuario = 'dwes';
$contrasena = 'dwes';
$basedatos = 'Libros';

function get_datos_autor($id) {
    global $servidor, $usuario, $contrasena, $basedatos;
    $libros = new Libros();
    $con = $libros -> conexion($servidor, $usuario, $contrasena, $basedatos);
    
    $datos_autor = new stdClass();
    // consultarAutores devuelve un objeto
    $datos_autor->datos = $libros->consultarAutores($con,$id); 
    // Devuelve una array de objetos de tipo libro
    $datos_autor->libros = $libros->consultarLibros($con,$id);
    return $datos_autor;
}

function get_listado_autores() {
    global $servidor, $usuario, $contrasena, $basedatos;
    $libros = new Libros();
    $con = $libros->conexion($servidor, $basedatos, $usuario, $contrasena);
    
    $lista_autores = $libros->consultarAutores($con, null); // Obtener todos los autores
    return $lista_autores;
}


function get_listado_libros() {
    global $servidor, $usuario, $contrasena, $basedatos;
    $libros = new Libros();
    $con = $libros -> conexion($servidor, $usuario, $contrasena, $basedatos);

    $libros = $libros->consultarLibros($con, null);
    $array_datos_libros = array();
    
    foreach ($libros as $libro) {
        $libro_id_titulo = array(
            'id' => $libro->id,
            'titulo' => $libro->titulo,
        );
        $array_datos_libros[] = $libro_id_titulo;
    }
	
    return $array_datos_libros;
}

function get_datos_libro($id_libro) {
    global $servidor, $usuario, $contrasena, $basedatos;
    $libros = new Libros();
    $con = $libros->conexion($servidor, $basedatos, $usuario, $contrasena);
    
    $datos_libro = new stdClass();

    // Obtener información del libro
    $libro = $libros->consultarDatosLibro($con, $id_libro);
    if ($libro) {
        $datos_libro->titulo = $libro->titulo;
        $datos_libro->f_publicacion = $libro->f_publicacion;
        $datos_libro->id_autor = $libro->id_autor;

        // Obtener información del autor
        $autor = $libros->consultarAutores($con, $libro->id_autor);
        if ($autor) {
            $datos_libro->nombre_autor = $autor->nombre;
            $datos_libro->apellidos_autor = $autor->apellidos;
        } else {
            $datos_libro->nombre_autor = "Autor no encontrado";
            $datos_libro->apellidos_autor = "Autor no encontrado";
        }
    } else {
        $datos_libro->titulo = "Libro no encontrado";
        $datos_libro->f_publicacion = "";
        $datos_libro->id_autor = "";
        $datos_libro->nombre_autor = "Autor no encontrado";
        $datos_libro->apellidos_autor = "Autor no encontrado";
    }

    return $datos_libro;
}


$posibles_URL = array("get_listado_autores", "get_datos_autor", "get_listado_libros", "get_datos_libro");

$valor = "Ha ocurrido un error";

if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL))
{
  switch ($_GET["action"]) {
    case "get_datos_autor":
        if (isset($_GET["id"]))
            $valor = get_datos_autor($_GET["id"]);
        else
            $valor = "Argumento no encontrado";
        break;

    case "get_listado_autores":
            $valor = get_listado_autores();
            break;
        
    case "get_listado_libros":
        $valor = get_listado_libros();  
        break;    

    case "get_datos_libro":
        if (isset($_GET["id"])) {
            $valor = get_datos_libro($_GET["id"]);
        } else {
            $valor = "Argumento no encontrado";
        }
        break;
    }
}

//devolvemos los datos serializados en JSON
exit(json_encode($valor));
?>
