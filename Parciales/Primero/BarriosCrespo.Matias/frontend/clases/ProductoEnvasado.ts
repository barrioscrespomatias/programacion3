/// <reference path="Producto.ts" />

namespace Entidades
{
    export class ProductoEnvasado extends Producto
    {
        public id: number;
        public codigoBarra:string;
        public precio:number;
        public pathFoto:string;

        //Si hubiese algun parámetro opcional único, este debe ir al final.
        //En este caso los parámetros NO son opcionales, sino predeterminados.
        //Para que sean opcionales debería ser ->  nombre?:string. El problema surge que cuando es opcional 
        //Puede tener dos estados, el tipo de dato  o undefined.
        
        public constructor(nombre: string = "", origen: string="", id: number = 0, codigoBarra: string = "", precio: number=0, pathFoto: string="")
        {
            super(nombre,origen);
            this.id = id;
            this.codigoBarra = codigoBarra;
            this.precio = precio;
            this.pathFoto = pathFoto;        
        }
        
        public ToString():string
        {
            let salida = "";
            
            // para convertirlo a json los string deben ir entre comillas dobles            
            //id y precio son number.
            salida += `{"nombre":"${this.nombre}", "origen":"${this.origen}", "id":${this.id}, "codigoBarra":"${this.codigoBarra}", "precio":${this.precio}, "pathFoto":"${this.pathFoto}"}`; 
            return salida;
        }
                
    }

}