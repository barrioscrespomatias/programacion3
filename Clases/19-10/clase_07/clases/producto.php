<?php
class Producto
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	private $codBarra;
 	private $nombre;
  	private $pathFoto;
//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
	public function GetCodBarra()
	{
		return $this->codBarra;
	}
	public function GetNombre()
	{
		return $this->nombre;
	}
	public function GetPathFoto()
	{
		return $this->pathFoto;
	}

	public function SetCodBarra($valor)
	{
		$this->codBarra = $valor;
	}
	public function SetNombre($valor)
	{
		$this->nombre = $valor;
	}
	public function SetPathFoto($valor)
	{
		$this->pathFoto = $valor;
	}

//--------------------------------------------------------------------------------//
//--CONSTRUCTOR
	public function __construct($codBarra=NULL, $nombre=NULL, $pathFoto=NULL)
	{
		if($codBarra !== NULL && $nombre !== NULL){
			$this->codBarra = $codBarra;
			$this->nombre = $nombre;
			$this->pathFoto = $pathFoto;
		}
	}

//--------------------------------------------------------------------------------//
//--TOSTRING	
  	public function ToString()
	{
	  	return $this->codBarra." - ".$this->nombre." - ".$this->pathFoto."\r\n";
	}
//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--METODOS DE CLASE
	public static function Guardar($obj)
	{
		$resultado = FALSE;
		
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/productos.txt", "a");
		
		//ESCRIBO EN EL ARCHIVO
		$cant = fwrite($ar, $obj->ToString());
		
		if($cant > 0)
		{
			$resultado = TRUE;			
		}
		//CIERRO EL ARCHIVO
		fclose($ar);
		
		return $resultado;
	}
	public static function TraerTodosLosProductos()
	{

		$ListaDeProductosLeidos = array();

		//leo todos los productos del archivo
		$archivo=fopen("./archivos/productos.txt", "r");
		
		if( ! $archivo){
			echo "no se conecto...";
		}
		else{
			while(!feof($archivo))
			{
				$archAux = fgets($archivo);
				$productos = explode(" - ", $archAux);
				//http://www.w3schools.com/php/func_string_explode.asp
				$productos[0] = trim($productos[0]);
				if($productos[0] != ""){
					$ListaDeProductosLeidos[] = new Producto($productos[0], $productos[1],$productos[2]);
				}
			}
			fclose($archivo);
		}
		return $ListaDeProductosLeidos;
		
	}
	public static function Modificar($obj)
	{
		$resultado = TRUE;
		
		$ListaDeProductosLeidos = Producto::TraerTodosLosProductos();
		$ListaDeProductos = array();
		$imagenParaBorrar = NULL;
		
		for($i=0; $i<count($ListaDeProductosLeidos); $i++){
			if($ListaDeProductosLeidos[$i]->codBarra == $obj->codBarra){//encontre el modificado, lo excluyo
				$imagenParaBorrar = trim($ListaDeProductosLeidos[$i]->pathFoto);
				$ListaDeProductosLeidos[$i] = $obj;
				//continue;
			}
			//$ListaDeProductos[$i] = $ListaDeProductosLeidos[$i];
		}

		//array_push($ListaDeProductos, $obj);//agrego el producto modificado
		
		//BORRO LA IMAGEN ANTERIOR
		unlink("./archivos/".$imagenParaBorrar);
		
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/productos.txt", "w");
		
		//ESCRIBO EN EL ARCHIVO
		foreach($ListaDeProductosLeidos AS $item){
			$cant = fwrite($ar, $item->ToString());
			
			if($cant < 1)
			{
				$resultado = FALSE;
				break;
			}
		}
		
		//CIERRO EL ARCHIVO
		fclose($ar);
		
		return $resultado;
	}
	public static function Eliminar($codBarra)
	{
		if($codBarra === NULL)
			return FALSE;
			
		$resultado = TRUE;
		
		$ListaDeProductosLeidos = Producto::TraerTodosLosProductos();
		$ListaDeProductos = array();
		$imagenParaBorrar = NULL;
		
		for($i=0; $i<count($ListaDeProductosLeidos); $i++){
			if($ListaDeProductosLeidos[$i]->codBarra == $codBarra){//encontre el borrado, lo excluyo
				$imagenParaBorrar = trim($ListaDeProductosLeidos[$i]->pathFoto);
				continue;
			}
			$ListaDeProductos[$i] = $ListaDeProductosLeidos[$i];
		}

		//BORRO LA IMAGEN ANTERIOR
		unlink("./archivos/".$imagenParaBorrar);
		
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/productos.txt", "w");
		
		//ESCRIBO EN EL ARCHIVO
		foreach($ListaDeProductos AS $item){
			$cant = fwrite($ar, $item->ToString());
			
			if($cant < 1)
			{
				$resultado = FALSE;
				break;
			}
		}
		
		//CIERRO EL ARCHIVO
		fclose($ar);
		
		return $resultado;
	}
//--------------------------------------------------------------------------------//
}