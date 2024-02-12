<?php
/**
 * Clase Libros que proporciona funcionalidades relacionadas con autores y libros.
 */
class Libros {
    // Configuración base de datos
    
    /**
     * Establece una conexión a la base de datos.
     *
     * @param string $servidor   El servidor de la base de datos.
     * @param string $base_de_datos   El nombre de la base de datos.
     * @param string $usuario   El nombre de usuario de la base de datos.
     * @param string $contrasena   La contraseña de la base de datos.
     *
     * @return mysqli|null   Retorna la conexión establecida o null si hay un error.
     */
    public function conexion($servidor, $basedatos, $usuario, $contrasena) {
        
        // Se crea la conexión a la base de datos
        try {
            $mysqli = new mysqli($servidor, $usuario, $contrasena, $basedatos);
        } catch (mysqli_sql_exception $e) {
            # error_log($e->__toString());
            return null;
        }
        return $mysqli;
    }
  
    /**
     * Consulta la información de un autor específico.
     *
     * @param mysqli $con   La conexión a la base de datos.
     * @param int $id_autor   El ID del autor a consultar.
     *
     * @return object|null   Retorna un objeto con la información del autor o null si no se encuentra.
     */
    public function consultarAutores($con, $id_autor) {
        $query = "SELECT * FROM autor";
        if ($id_autor !== null) {
            $query .= " WHERE id='$id_autor'";
        }
        $resultado = $con -> query($query);
        $autor = $resultado -> fetch_object();
        return $autor;
    }
    
    /**
     * Consulta la lista de libros de un autor específico.
     *
     * @param mysqli $con   La conexión a la base de datos.
     * @param int $id_autor   El ID del autor cuyos libros se quieren consultar.
     *
     * @return array|null   Retorna un array de objetos con la información de los libros o null si no hay libros.
     */
    public function consultarLibros($con, $id_autor) {
        try {
            if ($con === null) {
                // Manejar el caso en que la conexión sea null
                return null;
            }
            
            $query = "SELECT * FROM Libro";
            if ($id_autor !== null) {
                $query .= " WHERE id_autor='$id_autor'";
            }
            $resultado = $con->query($query);
            $datos = array();
            while ($fila = $resultado->fetch_object()){
                $fila->f_publicacion = date('d/m/Y', strtotime($fila->f_publicacion));
                $datos[] = $fila;
            }
            return $datos;
        } catch (mysqli_sql_exception $e) {
            # error_log($e->__toString());
            return null;
        }
    }

    /**
     * Consulta la información de un libro específico.
     *
     * @param mysqli $con   La conexión a la base de datos.
     * @param int $id_libro   El ID del libro a consultar.
     *
     * @return object|null   Retorna un objeto con la información del libro o null si no se encuentra.
     */
    public function consultarDatosLibro($con, $id_libro) {
        try {
            $query = "SELECT * FROM Libro where id='$id_libro'";
            $resultado = $con -> query($query);
            if ($resultado->num_rows > 0) {
                $datosLibro = $resultado->fetch_object();
                $datosLibro->f_publicacion = date('d/m/Y', strtotime($datosLibro->f_publicacion));
                return $datosLibro;
            } else {
                return null; // No se encontraron datos para el libro con el ID especificado
            }
        } catch (mysqli_sql_exception $e) {
            # error_log($e->__toString());
            return null;
        }
    }

    /**
     * Borra un autor y sus libros asociados.
     *
     * @param mysqli $con   La conexión a la base de datos.
     * @param int $id_autor   El ID del autor a borrar.
     *
     * @return bool   Retorna true si la operación es exitosa, false si hay un error.
     */
    public function borrarAutor($con, $id_autor) {
        try {
            // Borrar libros asociados al autor
            $queryBorrarLibros = "DELETE FROM Libro WHERE id_autor='$id_autor'";
            $con->query($queryBorrarLibros);
    
            // Después, borrar al autor
            $queryBorrarAutor = "DELETE FROM Autor WHERE id='$id_autor'";
            $resultado = $con->query($queryBorrarAutor);
    
            return $resultado;
        } catch (mysqli_sql_exception $e) {
            # error_log($e->__toString());
            return false;
        }
    }

    /**
     * Borra un libro específico.
     *
     * @param mysqli $con   La conexión a la base de datos.
     * @param int $id_libro   El ID del libro a borrar.
     *
     * @return bool   Retorna true si la operación es exitosa, false si hay un error.
     */
    public function borrarLibro($con, $id_libro) {
        try {
            $query = "DELETE FROM Libro WHERE id='$id_libro'";
            $resultado = $con->query($query);
            return $resultado;
        } catch (mysqli_sql_exception $e) {
            # error_log($e->__toString());
            return false;
        }
    }

}
?>
