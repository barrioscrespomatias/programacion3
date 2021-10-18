namespace Entidades
{
    export class Producto
    {
        public nombre : string;
        public origen : string;

        public constructor(nombre: string, origen: string) 
        {
            this.nombre = nombre;
            this.origen = origen;
        }

        public ToString():string
        {
            let salida = "";
            
            // para convertirlo a json los string deben ir entre comillas dobles
            salida += `{"nombre":"${this.nombre}", "origen":"${this.origen}"}`; 
            return salida;
        }

        // Un método de instancia, ToJSON(), que retorne la representación de la instancia en formato de
        // cadena JSON válido. Reutilizar código.
        public ToJSON():JSON
        {
            return JSON.parse(this.ToString());
        }
        
    }
}