export class Auto {
    public color: string;
    public ruedas: number;

    public constructor(color: string, ruedas: number) {
        this.color = color;
        this.ruedas = ruedas
    }
    public GetRuedas(): number {
        return this.ruedas;
    }

    /**
     * Getters o Setters. Accesores
     */

    public get Color(): string {
        return this.color;
    }

    public set Color(color: string) {
        this.color = color;
    }

    public set Ruedas(cantidad: number) {
        this.ruedas = cantidad;
    }

    public ToString():string{
        return `Es la muestra del auto ${this.color}`;
    }
}

