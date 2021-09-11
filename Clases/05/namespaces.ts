namespace Entidades {
    export class Perro {
        protected color: string;
        public constructor(color: string) {
            this.color = color;
        }

        public Acelerar(): string {
            return 'Estoy ladrando!';
        }
    }
}