export abstract class Vehiculo{
    protected marca:string;

    public constructor(marca:string)
    {
        this.marca = marca;
    }
    public abstract Acelerar():void;

}

export class Autito extends Vehiculo{
    protected ruedas:number;

    public constructor(marca:string, ruedas:number){
        super(marca);
        this.ruedas= ruedas;
    }

    public Acelerar():void{
        console.log('está acelerando!');
    }
}