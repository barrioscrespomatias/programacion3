<?php
class Usuario
{
    private $email;
    private $clave;

    public function __construct($email, $clave)
    {
        $this->email = $email;
        $this->clave = $clave;
    }

    public function ToJSON()
    {
        $newObj = new stdClass();
        $newObj->email = $this->email;
        $newObj->clave = $this->clave;

        return json_encode($newObj);
    }

    public function GetEmail()
    {
        return $this->email;
    }

    public function GetClave()
    {
        return $this->clave;
    }


    // Método de instancia GuardarEnArchivo(), que agregará al usuario en ./archivos/usuarios.json. Retornará un JSON
    // que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
    public function GuardarEnArchivo()
    {
        $stdObj = new stdClass();
        $stdObj->exito = false;
        $stdObj->mensaje = "No se ha guardado en el archivo";

        $file = fopen('./archivos/usuarios.json', "a");
        $save = fwrite($file, $this->ToJSON() . PHP_EOL);
        fclose($file);

        if ($save > 0) {
            $stdObj->exito = true;
            $stdObj->mensaje = "Se ha guardado en el archivo";
        }
        return json_encode($stdObj);
    }

    // Método de clase TraerTodos(), que retornará un array de objetos de tipo Usuario.
    public static function TraerTodos(): array
    {
        $listaUsuarios = [];
        //Controlar las lineas en un archivo

        if (file_exists('./archivos/usuarios.json')) {
            $file = new \SplFileObject('./archivos/usuarios.json', 'r');
            $file->seek(PHP_INT_MAX);
            $cantidadLineas =  $file->key();
            $i = 0;

            $file = fopen('./archivos/usuarios.json', "r");
            while (!feof($file) && $i < $cantidadLineas) {
                //Trim lo uso para eliminar espacios en blanco
                $line = trim(fgets($file));
                $arrayProducto = explode('\n\r', $line);

                //El archivo contiene json, entonces se debe decodificarlo.
                $stdProducto = json_decode($arrayProducto[0]);
                $usuario = new Usuario($stdProducto->email, $stdProducto->clave);

                //posicion cero porque explode retorna un array con una posición en este caso.         
                array_push($listaUsuarios, $usuario);
                $i++;
            }
            fclose($file);
        }
        return $listaUsuarios;
    }

    // Método de clase VerificarExistencia($usuario), retornará true, si el usuario está registrado (invocar a TraerTodos),
    // caso contrario retornará false.

    public static function VerificarExistencia($usuario)
    {
        $listaUsuarios = Usuario::TraerTodos();
        $retorno = false;


        foreach ($listaUsuarios as $aux) {
            if ($aux->email == $usuario->email && $aux->clave == $usuario->clave) {
                $retorno =  true;
                break;
            }
        }

        return $retorno;
    }
}
