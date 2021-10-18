/// <reference path="Producto.ts" />
/// <reference path="ProductoEnvasado.ts" />
/// <reference path="../interfaces/IParte2.ts" />


namespace PrimerParcial
{
    // export class Manejadora implements IParte2
    export class Manejadora
    {


        // nombre: string = "", origen: string="", id: number = 0, codigoBarra: string = "", precio: number=0, pathFoto: string=""

        public static AgregarProductoJSON()
        {

            const nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            const origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;         
          
            let nuevoProducto : Entidades.Producto = new Entidades.ProductoEnvasado(nombre,origen);
            
            // Archivo subido por Ajax
            const xmlHttp : XMLHttpRequest = new XMLHttpRequest();

            const form : FormData = new FormData();            

            form.append('nombre', nombre);
            form.append('origen', origen);

            xmlHttp.open('POST','./BACKEND/AltaProductoJSON.php',true);
            xmlHttp.setRequestHeader('enctype','multipart/form-data');
            xmlHttp.send(form);
            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    //Response text desde backend
                    const respuesta : any = JSON.parse(xmlHttp.responseText);                    
                    console.log(respuesta.mensaje);
                    alert(respuesta.mensaje);             
                }
            }

        }

        // Recuperará (por AJAX) todos los productos del archivo productos.json y generará un
        // listado dinámico, crear una tabla HTML con cabecera (en el FRONTEND) que mostrará toda la información de
        // cada uno de los productos. Invocar a “./BACKEND/ListadoProductosJSON.php”, recibe la petición (por GET) y
        // retornará el listado de todos los productos en formato JSON.
        // Informar por consola el mensaje recibido y mostrar el listado en la página (div id='divTabla')

        public static MostrarProductosJSON()
        {

            const xmlHttp : XMLHttpRequest = new XMLHttpRequest();

            xmlHttp.open('GET','./BACKEND/ListadoProductosJSON.php',true);            
            xmlHttp.send();

            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    //Response text desde backend
                    const respuesta : any = JSON.parse(xmlHttp.responseText);  
                    
                    
                    let tabla: string = "";
                    tabla += "<table border=1>";

                    tabla += "<thead>";
                    tabla += "<tr>";
                    tabla += "<td>Nombre</td>";
                    tabla += "<td>Origen</td>";                    
                    tabla += "</tr>";
                    tabla += "</thead>";


                    for (let i = 0; i < respuesta.length; i++) 
                    {
                        tabla += "<tr>";

                            tabla += "<td>";
                            tabla += respuesta[i].nombre;
                            tabla += "</td>";

                            tabla += "<td>";
                            tabla += respuesta[i].origen;
                            tabla += "</td>";

                        tabla += "</tr>";
                    }

                    tabla += "</table>";
                    
                    PrimerParcial.Manejadora.ActualizarDivs();
                    (<HTMLInputElement>document.getElementById("divTabla")).innerHTML = tabla;
                                                 
                }
            }

        }

        // Se invocará (por AJAX) a “./BACKEND/VerificarProductoJSON.php”. Se recibe por POST el
        // nombre y el origen, si coinciden con algún registro del archivo JSON (VerificarProductoJSON), crear una COOKIE nombrada con el
        // nombre y el origen del producto, separado con un guión bajo (limon_tucuman) que guardará la fecha actual (con horas, minutos y
        // segundos) más el retorno del mensaje del método estático VerificarProductoJSON de la clase Producto.

        public static VerificarProductoJSON()
        {
            const nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            const origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;           

            
            let nuevoProducto : Entidades.Producto = new Entidades.ProductoEnvasado(nombre,origen);            
            const xmlHttp : XMLHttpRequest = new XMLHttpRequest();
            const form : FormData = new FormData();

            // form.append('producto_json', JSON.stringify(nuevoProducto));

            form.append('nombre', nombre);
            form.append('origen', origen);

            xmlHttp.open('POST','./BACKEND/VerificarProductoJSON.php',true);
            xmlHttp.setRequestHeader('enctype','multipart/form-data');
            xmlHttp.send(form);
            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    //Response text desde backend
                    const respuesta : any = JSON.parse(xmlHttp.responseText);                    
                    console.log(respuesta.mensaje);
                    alert(respuesta.mensaje);             
                }
            }

        }

        // Se realizará una petición (por AJAX) a “./BACKEND/MostrarCookie.php” que recibe por GET
        // el nombre y el origen del producto y se verificará si existe una cookie con el mismo nombre, de ser así, retornará un JSON que
        // contendrá: éxito(bool) y mensaje(string), dónde se mostrará el contenido de la cookie. Caso contrario, false y el mensaje indicando lo
        // acontecido.
        // Informar por consola el mensaje recibido y mostrar el mensaje en la página (div id='divInfo').

        public static MostrarInfoCookie()
        {

            const nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            const origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;

            const xmlHttp : XMLHttpRequest = new XMLHttpRequest();

            xmlHttp.open('GET', `./BACKEND/MostrarCookie.php?nombre=${nombre}&origen=${origen}`, true);
            xmlHttp.send();

            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    //Response text desde backend
                    const respuesta: any = JSON.parse(xmlHttp.responseText);
                    console.log(respuesta.mensaje);
                    PrimerParcial.Manejadora.ActualizarDivs();
                    (<HTMLInputElement>document.getElementById("divTabla")).innerHTML = respuesta.mensaje;
                }
            }
        }

        // AgregarProductoSinFoto. Obtiene el código de barra, el nombre, el origen y el precio desde la página
        // producto.html, y se enviará (por AJAX) hacia “./BACKEND/AgregarProductoSinFoto.php” que recibe por POST el
        // parámetro producto_json (codigoBarra, nombre, origen y precio), en formato de cadena JSON. Se invocará al método Agregar.
        // Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        // Informar por consola y alert el mensaje recibido.

        public static AgregarProductoSinFoto()
        {
            const nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            const origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;            
            const codigoBarra: string = (<HTMLInputElement>document.getElementById('codigoBarra')).value;
            const precio: string = (<HTMLInputElement>document.getElementById('precio')).value;

            let nuevoProducto : Entidades.ProductoEnvasado = new Entidades.ProductoEnvasado(nombre,origen,null,codigoBarra,parseFloat(precio));
            // let nuevoProducto : Entidades.Producto = new Entidades.ProductoEnvasado(nombre,origen);
            // Archivo subido por Ajax
            const xmlHttp : XMLHttpRequest = new XMLHttpRequest();

            const form : FormData = new FormData();
            form.append('producto_json', JSON.stringify(nuevoProducto));

            // form.append('nombre', nombre);
            // form.append('origen', origen);

            xmlHttp.open('POST','./BACKEND/AgregarProductoSinFoto.php',true);
            xmlHttp.setRequestHeader('enctype','multipart/form-data');
            xmlHttp.send(form);
            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    //Response text desde backend
                    const respuesta : any = JSON.parse(xmlHttp.responseText);                    
                    console.log(respuesta.mensaje);
                    alert(respuesta.mensaje);             
                }
            }

        }

        // MostrarProductosEnvasados. Recuperará (por AJAX) todas los productos envasados de la base de datos,
        // invocando a “./BACKEND/ListadoProductosEnvasados.php”, que recibirá el parámetro tabla con el valor 'json', para
        // que retorne un array de objetos con formato JSON.
        // Crear una tabla HTML con cabecera (en el FRONTEND) para mostrar la información de cada uno de los
        // productos envasados. Preparar la tabla para que muestre la imagen, si es que la tiene. Todas las imagenes
        // deben tener 50px por 50px de dimensiones.
        // Informar por consola el mensaje recibido y mostrar el listado en la página (div id='divTabla')

        //  NOTA: Adecuar el método MostrarProductosEnvasados para que, de acuerdo desde que página se invoque,
        //  cambie el manejador de eventos de los botones que permiten Eliminar y Modificar al producto elegido. Para
        //  ello, agregue la lógica necesaria para que, desde producto_envasado.html, invoquen a las funciones
        //  EliminarProductoFoto y ModificarProductoFoto, respectivamente. Mantener en funcionamiento los
        //  manejadores de la página producto.html.

        public static MostrarProductosEnvasados(parametro?:string)
        {

            const xmlHttp : XMLHttpRequest = new XMLHttpRequest();

            xmlHttp.open('GET','./BACKEND/ListadoProductosEnvasados.php?tabla=json',true);            
            xmlHttp.send();

            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    //Response text desde backend
                    const respuesta : any = JSON.parse(xmlHttp.responseText);  
                    
                    
                    let tabla: string = "";
                    tabla += "<table border=1>";

                    tabla += "<thead>";
                    tabla += "<tr>";
                    tabla += "<td>Cod. Barra</td>";
                    tabla += "<td>Nombre</td>";
                    tabla += "<td>Origen</td>";                    
                    tabla += "<td>Precio</td>";
                    tabla += "<td>Imagen</td>";
                    tabla += "<td colspan='2'>Acciones</td>";
                    tabla += "</tr>";
                    tabla += "</thead>";


                    for (let i = 0; i < respuesta.length; i++) 
                    {
                        tabla += "<tr>";

                            tabla += "<td>";
                            tabla += respuesta[i].codigoBarra;
                            tabla += "</td>";

                            tabla += "<td>";
                            tabla += respuesta[i].nombre;
                            tabla += "</td>";

                            tabla += "<td>";
                            tabla += respuesta[i].origen;
                            tabla += "</td>";

                            tabla += "<td>";
                            tabla += respuesta[i].precio;
                            tabla += "</td>";

                            //compruebo si existe la imagen
                            tabla+="<td>";                            
                            var img = new Image();
                            let path : string = respuesta[i].pathFoto ; 
                            img.src ="./BACKEND/fotos/"+ path ;                                 
                            tabla+="<img src='./BACKEND/" + respuesta[i].pathFoto + "' height=50 width=50 ></img>";
                            tabla+="</td>";

                            tabla+= "<td>";
                            tabla+= "<input type='button' value='Eliminar' onclick='PrimerParcial.Manejadora.EliminarProducto("+JSON.stringify(respuesta[i])+")'</td>"
                            tabla+= "<td><input type='button' value='Modificar' onclick='PrimerParcial.Manejadora.ModificarProducto("+JSON.stringify(respuesta[i])+")'></td>";
                            tabla+="</td>";                                
                        tabla += "</tr>";
                    }

                    tabla += "</table>";

                    PrimerParcial.Manejadora.ActualizarDivs();
                    (<HTMLInputElement>document.getElementById("divTabla")).innerHTML = tabla;
                                                 
                }
            }

        }

        /**
         * Interface IParte2
         */


        // Si se confirma se invocará (por AJAX) a “./BACKEND/EliminarProductoEnvasado.php” pasándole cómo parámetro
        // producto_json (id, nombre y origen, en formato de cadena JSON) por POST y se deberá borrar el producto envasado (invocando al
        // método Eliminar).
        // Si se pudo borrar en la base de datos, invocar al método GuardarJSON y pasarle './BACKEND/archivos/productos_eliminados.json'
        // cómo parámetro.
        // Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        // Informar por consola y alert lo acontecido. Refrescar el listado para visualizar los cambios.

               
        
        public static EliminarProducto(obj_json:JSON)
        {
            // EliminarProducto. Recibe como parámetro al objeto JSON que se ha de eliminar. Pedir confirmación,
            // mostrando nombre y origen, antes de eliminar.

            const productoEliminar : any = obj_json;          
            
            
            if(confirm("Esta seguro que desea eliminar al producto - Nombre: "+productoEliminar.nombre+" - Origen: "+productoEliminar.origen))
            {                
                // Archivo subido por Ajax
                const xmlHttp : XMLHttpRequest = new XMLHttpRequest();
    
                const form : FormData = new FormData();
                form.append('producto_json', JSON.stringify(productoEliminar));  
    
                xmlHttp.open('POST','./BACKEND/EliminarProductoEnvasado.php',true);
                xmlHttp.setRequestHeader('enctype','multipart/form-data');
                xmlHttp.send(form);
                xmlHttp.onreadystatechange = () =>{
                    if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                    {
                        //Response text desde backend
                        const respuesta : any = JSON.parse(xmlHttp.responseText);                    
                        console.log(respuesta.mensaje);
                        alert(respuesta.mensaje);

                        //refrescar la tabla
                        PrimerParcial.Manejadora.ActualizarDivs();
                        PrimerParcial.Manejadora.MostrarProductosEnvasados();             
                    }
                }
            }
            else
            {
                alert("Se ha cancelado la operación!");
            }
        }

        // ModificarProducto. Mostrará todos los datos del producto que recibe por parámetro (objeto JSON), en el
        // formulario, de tener foto, incluirla en “imgFoto”. Permitirá modificar cualquier campo, a excepción del id.
        

        public static ModificarProducto(obj_json:JSON)
        {
            const productoModificar : any = obj_json;            

            (<HTMLInputElement>document.getElementById('idProducto')).value = productoModificar.id;
            (<HTMLInputElement>document.getElementById('idProducto')).readOnly  = true;            
            (<HTMLInputElement>document.getElementById('nombre')).value = productoModificar.nombre;
            (<HTMLInputElement>document.getElementById('cboOrigen')).value = productoModificar.origen;
            (<HTMLInputElement>document.getElementById('codigoBarra')).value = productoModificar.codigoBarra;
            (<HTMLInputElement>document.getElementById('precio')).value = productoModificar.precio;
            (<HTMLImageElement>document.getElementById("imgFoto")).src=`./backend/${productoModificar.pathFoto}`;   
                  

        }

        // Al pulsar el botón Modificar sin foto (de la página) se invocará (por AJAX) a
        // “./BACKEND/ModificarProductoEnvadado.php” Se recibirán por POST los siguientes valores: producto_json (id,
        // codigoBarra, nombre, origen y precio, en formato de cadena JSON) para modificar un producto envasado en la base de datos.
        // Invocar al método Modificar.
        // Nota: El valor del id, será el id del producto envasado 'original', mientras que el resto de los valores serán los del producto envasado
        // a ser modificado.
        // Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        // Refrescar el listado solo si se pudo modificar, caso contrario, informar (por alert y consola) de lo acontecido.

        public static ModificarSinFoto()
        {
            const id: number = parseInt((<HTMLInputElement>document.getElementById('idProducto')).value, 10);
            const nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            const origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;            
            const codigoBarra: string = (<HTMLInputElement>document.getElementById('codigoBarra')).value;
            const precio: string = (<HTMLInputElement>document.getElementById('precio')).value;

            let nuevoProducto : Entidades.ProductoEnvasado = new Entidades.ProductoEnvasado(nombre,origen,id,codigoBarra,parseFloat(precio));            
            // Archivo subido por Ajax
            const xmlHttp : XMLHttpRequest = new XMLHttpRequest();

            const form : FormData = new FormData();
            form.append('producto_json', JSON.stringify(nuevoProducto));

            xmlHttp.open('POST','./BACKEND/ModificarProductoEnvadado.php',true);
            xmlHttp.setRequestHeader('enctype','multipart/form-data');
            xmlHttp.send(form);
            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    //Response text desde backend
                    const respuesta : any = JSON.parse(xmlHttp.responseText);                    
                    console.log(respuesta.mensaje);
                    alert(respuesta.mensaje);
                    
                    //Actualizar                    
                    PrimerParcial.Manejadora.MostrarProductosEnvasados();                 
                }
            }
        }

        /**
         * IParte3
         */

         
        //  En la clase Manejadora, agregar la interface Iparte3, con los siguientes métodos:
        //  VerificarProductoEnvasado. Se recupera el nombre y el origen del producto envasado desde la página
        //  producto_envasado.html y se invoca (por AJAX) a
        //  “./BACKEND/VerificarProductoEnvadado.php” que recibe por POST el parámetro obj_producto, que será una cadena
        //  JSON (nombre y origen), si coincide con algún registro de la base de datos (invocar al método Traer) retornará los datos del objeto
        //  (invocar al ToJSON). Caso contrario, un JSON vacío ({}).
        //  Informar por consola lo acontecido y mostrar el objeto recibido en la página (div id='divInfo').

        public static VerificarProductoEnvasado()
        {

            const nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            const origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;

            let nuevoProducto : Entidades.ProductoEnvasado = new Entidades.ProductoEnvasado(nombre,origen,null,null,null,null);            
            // Archivo subido por Ajax
            const xmlHttp : XMLHttpRequest = new XMLHttpRequest();

            const form : FormData = new FormData();
            form.append('obj_producto', JSON.stringify(nuevoProducto));

            xmlHttp.open('POST','./BACKEND/VerificarProductoEnvasado.php',true);
            xmlHttp.setRequestHeader('enctype','multipart/form-data');
            xmlHttp.send(form);
            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    //Response text desde backend
                    const producto : any = JSON.parse(xmlHttp.responseText);    
                    // Informar por consola lo acontecido y mostrar el objeto recibido en la página (div id='divInfo')                
                    if(producto.nombre.length > 0)
                    {
                        console.log(`Se ha verificado el producto "${producto.nombre}" de la base de datos.`);

                        PrimerParcial.Manejadora.ActualizarDivs();
                        (<HTMLInputElement>document.getElementById("divInfo")).innerHTML += `El producto existe en la base de datos. 
                                                                                            <br> Id: ${producto.id}
                                                                                            <br> Cod Barra: ${producto.codigoBarra}
                                                                                            <br> Nombre: ${producto.nombre}
                                                                                            <br> Origen: ${producto.origen}
                                                                                            <br> Precio: ${producto.precio}`;

                    }
                }
            }

        }



        //  AgregarProductoFoto. Obtiene el código de barra, el nombre, el origen, el precio y la foto desde la página
        //  producto_envasado.html y se enviará (por AJAX) hacia “./BACKEND/AgregarProductoEnvasado.php” que
        //  recibirá por POST todos los valores: codigoBarra, nombre, origen, precio y la foto para registrar un producto envasado en la base de
        //  datos.
        //  Verificar la previa existencia del producto envasado invocando al método Existe. Se le pasará como parámetro el array que retorna el
        //  método Traer.
        //  Si el producto envasado ya existe en la base de datos, se retornará un mensaje que indique lo acontecido.
        //  Si el producto envasado no existe, se invocará al método Agregar. La imagen se guardará en “./BACKEND/productos/imagenes/”,
        //  con el nombre formado por el nombre punto origen punto hora, minutos y segundos del alta (Ejemplo:
        //  tomate.argentina.105905.jpg).
        //  Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        //  Informar por consola y alert el mensaje recibido. Refrescar el listado de productos reutilizando el método
        //  MostrarProductosEnvasados.

        public static AgregarProductoFoto()
        {           

            // const id: number = parseInt((<HTMLInputElement>document.getElementById('idProducto')).value, 10);
            const nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            const origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;            
            const codigoBarra: string = (<HTMLInputElement>document.getElementById('codigoBarra')).value;
            const precio: string = (<HTMLInputElement>document.getElementById('precio')).value;

            // foto
            const file: any = (<HTMLInputElement>document.getElementById('foto'));

            // let nuevoProducto : Entidades.ProductoEnvasado = new Entidades.ProductoEnvasado(nombre,origen,id,codigoBarra,precio);            
            // Archivo subido por Ajax
            const xmlHttp : XMLHttpRequest = new XMLHttpRequest();

            const form : FormData = new FormData();
            // form.append('producto_json', JSON.stringify(nuevoProducto));
            form.append('nombre', nombre);
            form.append('origen', origen);
            form.append('precio', precio);
            form.append('codigoBarra', codigoBarra);

            //foto
            form.append('foto', file.files[0]);

            xmlHttp.open('POST','./BACKEND/AgregarProductoEnvasado.php',true);
            xmlHttp.setRequestHeader('enctype','multipart/form-data');
            xmlHttp.send(form);
            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    //Response text desde backend
                    const respuesta : any = JSON.parse(xmlHttp.responseText);                    
                    console.log(respuesta.mensaje);
                    alert(respuesta.mensaje);                                     
                    PrimerParcial.Manejadora.MostrarProductosEnvasados();
                }
            }

        }



        //  BorrarProductoFoto. Recibe como parámetro al objeto JSON que se ha de eliminar. Pedir confirmación,
        //  mostrando nombre y código de barra, antes de eliminar.
        //  Si se confirma se invocará (por AJAX) a “./BACKEND/BorrarProductoEnvasado.php” que recibe el parámetro
        //  producto_json (id, codigoBarra, nombre, origen, precio y pathFoto en formato de cadena JSON) por POST. Se deberá borrar el
        //  producto envasado (invocando al método Eliminar).
        //  Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        //  Informar por consola y alert lo acontecido. Refrescar el listado para visualizar los cambios.

        public static BorrarProductoFoto(obj_json:JSON)
        {
            const productoEliminar : any = obj_json;          
            
            
            if(confirm("Esta seguro que desea eliminar al producto - Nombre: "+productoEliminar.nombre+" - Cod Barra: "+productoEliminar.codigoBarra))
            {                
                // Archivo subido por Ajax
                const xmlHttp : XMLHttpRequest = new XMLHttpRequest();
    
                const form : FormData = new FormData();
                form.append('producto_json', JSON.stringify(productoEliminar));  
    
                xmlHttp.open('POST','./BACKEND/BorrarProductoEnvasado.php',true);
                xmlHttp.setRequestHeader('enctype','multipart/form-data');
                xmlHttp.send(form);
                xmlHttp.onreadystatechange = () =>{
                    if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                    {
                        //Response text desde backend
                        const respuesta : any = JSON.parse(xmlHttp.responseText);                    
                        console.log(respuesta.mensaje);
                        alert(respuesta.mensaje);
                        
                        //Refrescar la tabla.
                        PrimerParcial.Manejadora.MostrarProductosEnvasados();             
                    }
                }
            }
            else
            {
                alert("Se ha cancelado la operación!");
            }
            
        }


        //  ModificarProductoFoto. Mostrará todos los datos del producto que recibe por parámetro (objeto JSON), en el
        //  formulario, de tener foto, incluirla en “imgFoto”. Permitirá modificar cualquier campo (incluyendo la foto), a
        //  excepción del id.
        //  Al pulsar el botón Modificar (de la página) se invocará (por AJAX) a
        //  “./BACKEND/ModificarProductoEnvadadoFoto.php” dónde se recibirán por POST los siguientes valores: producto_json
        //  (id, codigoBarra, nombre, origen y precio, en formato de cadena JSON) y la foto (para modificar un producto envasado en la base de
        //  datos. Invocar al método Modificar.
        //  Nota: El valor del id, será el id del producto envasado 'original', mientras que el resto de los valores serán los del producto envasado
        //  a ser modificado.
        //  Si se pudo modificar en la base de datos, la foto original del registro modificado se moverá al subdirectorio
        //  “./BACKEND/productosModificados/”, con el nombre formado por el nombre punto origen punto 'modificado' punto hora, minutos y
        //  segundos de la modificación (Ejemplo: aceite.italia.modificado.105905.jpg).
        //  Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.Refrescar el listado solo si se pudo modificar, caso contrario, informar (por alert y consola) de lo acontecido.

        //  NOTA: Adecuar el método MostrarProductosEnvasados para que, de acuerdo desde que página se invoque,
        //  cambie el manejador de eventos de los botones que permiten Eliminar y Modificar al producto elegido. Para
        //  ello, agregue la lógica necesaria para que, desde producto_envasado.html, invoquen a las funciones
        //  EliminarProductoFoto y ModificarProductoFoto, respectivamente. Mantener en funcionamiento los
        //  manejadores de la página producto.html.

        public static ModificarProductoFoto(obj_json:JSON)
        {
                const id: number = parseInt((<HTMLInputElement>document.getElementById('idProducto')).value, 10);
                const nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
                const origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;            
                const codigoBarra: string = (<HTMLInputElement>document.getElementById('codigoBarra')).value;
                const precio: number = parseInt((<HTMLInputElement>document.getElementById('precio')).value, 10);
                // foto
                const file: any = (<HTMLInputElement>document.getElementById('foto'));
                

                let productoModificar : Entidades.ProductoEnvasado = new Entidades.ProductoEnvasado(nombre,origen,id,codigoBarra,precio);            
                // Archivo subido por Ajax
                const xmlHttp : XMLHttpRequest = new XMLHttpRequest();
    
                const form : FormData = new FormData();
                form.append('producto_json', JSON.stringify(productoModificar));
                //foto
                form.append('foto', file.files[0]);  
    
                xmlHttp.open('POST','./BACKEND/ModificarProductoEnvadadoFoto.php',true);
                xmlHttp.setRequestHeader('enctype','multipart/form-data');
                xmlHttp.send(form);
                xmlHttp.onreadystatechange = () =>{
                    if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                    {
                        //Response text desde backend
                        const respuesta : any = JSON.parse(xmlHttp.responseText);                    
                        console.log(respuesta.mensaje);
                        alert(respuesta.mensaje);
                        
                        if(respuesta.exito)
                        //Refrescar la tabla.
                        PrimerParcial.Manejadora.MostrarProductosEnvasados();             
                    }
                }                 

        }

        // En la clase Manejadora, agregar la interface Iparte4 con los métodos:

        // MostrarBorradosJSON: Invocará (por AJAX) a “./BACKEND/MostrarBorradosJSON.php” que muestra todo lo
        // registrado en el archivo “productos_eliminados.json”. Para ello, agregar un método estático (en ProductoEnvasado), llamado
        // MostrarBorradosJSON.
        // Informar por consola el mensaje recibido y en la página (div id='divInfo').

        public static MostrarBorradosJSON()
        {             
            
            const xmlHttp : XMLHttpRequest = new XMLHttpRequest();

            xmlHttp.open('GET', `./BACKEND/MostrarBorradosJSON.php`, true);
            xmlHttp.send();

            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    //Response text desde backend
                    let listado = JSON.parse(xmlHttp.responseText);

                    //limparDiv
                    PrimerParcial.Manejadora.ActualizarDivs();
                    

                    for (let i = 0; i < listado.length; i++) 
                    {
                        (<HTMLInputElement>document.getElementById("divInfo")).innerHTML += listado[i].id + " - ";
                        (<HTMLInputElement>document.getElementById("divInfo")).innerHTML += listado[i].nombre + " - ";
                        (<HTMLInputElement>document.getElementById("divInfo")).innerHTML += listado[i].origen + "<br>";
                    }
                }
            }

        }


        // MostrarFotosModificados: Invocará (por AJAX) a “./BACKEND/MostrarFotosDeModificados.php” que muestra (en
        // una tabla HTML) todas las imagenes (50px X 50px) de los productos envasados registrados en el directorio
        // “./BACKEND/productosModificados/”. Para ello, agregar un método estático (en ProductoEnvasado), llamado MostrarModificados.
        // Mostrar el listado en la página (div id='divTabla').

        public static MostrarFotosModificados()
        {

            const xmlHttp : XMLHttpRequest = new XMLHttpRequest();

            xmlHttp.open('GET','./BACKEND/MostrarFotosDeModificados.php',true);            
            xmlHttp.send();

            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    //Response text desde backend
                    const tablaModificados : any = xmlHttp.responseText; 
                    
                    PrimerParcial.Manejadora.ActualizarDivs();
                    (<HTMLInputElement>document.getElementById("divInfo")).innerHTML += tablaModificados;

                }
            }
        }

        // FiltrarListado: Invocará (por AJAX) a “./BACKEND/FiltrarProductos.php” que recibe por POST el origen, se mostrarán
        // en una tabla (HTML) los productos envasados cuyo origen coincidan con el pasado por parámetro.
        // Si se recibe por POST el nombre, se mostrarán en una tabla (HTML) los productos envasados cuyo nombre coincida con el pasado
        // por parámetro.
        // Si se recibe por POST el nombre y el origen, se mostrarán en una tabla (HTML) los productos envasados cuyo nombre y origen
        // coincidan con los pasados por parámetro.
        // Mostrar el listado en la página (div id='divTabla').

        public static FiltrarListado()
        {
            
            const nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            const origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;  
            
                       
            // Archivo subido por Ajax
            const xmlHttp : XMLHttpRequest = new XMLHttpRequest();

            const form : FormData = new FormData();
            form.append('nombre', nombre);
            form.append('origen', origen);

            xmlHttp.open('POST','./BACKEND/FiltrarProductos.php',true);
            xmlHttp.setRequestHeader('enctype','multipart/form-data');

            xmlHttp.send(form);
            xmlHttp.onreadystatechange = () =>{
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    //Response text desde backend
                    const listado : any = JSON.parse(xmlHttp.responseText);  
                    
                    
                    let tabla: string = "";
                    tabla += "<table border=1>";

                    tabla += "<thead>";
                    tabla += "<tr>";
                    tabla += "<td>Cod. Barra</td>";
                    tabla += "<td>Nombre</td>";
                    tabla += "<td>Origen</td>";                    
                    tabla += "<td>Precio</td>";
                    tabla += "<td>Imagen</td>";
                    tabla += "</tr>";
                    tabla += "</thead>";


                    for (let i = 0; i < listado.length; i++) 
                    {
                        tabla += "<tr>";

                            tabla += "<td>";
                            tabla += listado[i].codigoBarra;
                            tabla += "</td>";

                            tabla += "<td>";
                            tabla += listado[i].nombre;
                            tabla += "</td>";

                            tabla += "<td>";
                            tabla += listado[i].origen;
                            tabla += "</td>";

                            tabla += "<td>";
                            tabla += listado[i].precio;
                            tabla += "</td>";

                            //compruebo si existe la imagen
                            tabla+="<td>";                            
                            var img = new Image();
                            let path : string = listado[i].pathFoto ; 
                            img.src ="./BACKEND/"+ path ;                                 
                            tabla+="<img src='./BACKEND/" + listado[i].pathFoto + "' height=50 width=50 ></img>";
                            tabla+="</td>";

                        tabla += "</tr>";
                    }

                    tabla += "</table>";

                    PrimerParcial.Manejadora.ActualizarDivs();
                    (<HTMLInputElement>document.getElementById("divTabla")).innerHTML = tabla;

                    
                    
                }
            }                 
        }

        public static ActualizarDivs()
        {
            (<HTMLInputElement>document.getElementById("divInfo")).innerHTML = "";
            (<HTMLInputElement>document.getElementById("divTabla")).innerHTML = "";
        }


    }
}