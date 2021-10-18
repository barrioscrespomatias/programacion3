// En la clase Manejadora, agregar la interface Iparte2 con los métodos EliminarProducto y ModificarProducto.
namespace PrimerParcial
{    
    export interface IParte2 
    {
        // EliminarProducto. Recibe como parámetro al objeto JSON que se ha de eliminar. Pedir confirmación,
        // mostrando nombre y origen, antes de eliminar.
        // Si se confirma se invocará (por AJAX) a “./BACKEND/EliminarProductoEnvasado.php” pasándole cómo parámetro
        // producto_json (id, nombre y origen, en formato de cadena JSON) por POST y se deberá borrar el producto envasado (invocando al
        // método Eliminar).
        // Si se pudo borrar en la base de datos, invocar al método GuardarJSON y pasarle './BACKEND/archivos/productos_eliminados.json'
        // cómo parámetro.
        // Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        // Informar por consola y alert lo acontecido. Refrescar el listado para visualizar los cambios.
    
        EliminarProducto(obj_json:JSON);
    
        // ModificarProducto. Mostrará todos los datos del producto que recibe por parámetro (objeto JSON), en el
        // formulario, de tener foto, incluirla en “imgFoto”. Permitirá modificar cualquier campo, a excepción del id.
        // Al pulsar el botón Modificar sin foto (de la página) se invocará (por AJAX) a
        // “./BACKEND/ModificarProductoEnvadado.php” Se recibirán por POST los siguientes valores: producto_json (id,
        // codigoBarra, nombre, origen y precio, en formato de cadena JSON) para modificar un producto envasado en la base de datos.
        // Invocar al método Modificar.
        // Nota: El valor del id, será el id del producto envasado 'original', mientras que el resto de los valores serán los del producto envasado
        // a ser modificado.
        // Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        // Refrescar el listado solo si se pudo modificar, caso contrario, informar (por alert y consola) de lo acontecido.
    
        ModificarProducto(obj_json:JSON);
       
    }
}