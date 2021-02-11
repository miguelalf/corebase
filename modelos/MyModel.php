<?php

namespace App\Modelos;

use App\Core\Database;
use Illuminate\Database\Eloquent\Model;
use App\Modelos\Dependencia\OperacionReferencia;

abstract class MyModel extends Model {
	protected static $driver;
	
	public function __construct($conexion) {
		$this->bootIfNotBooted();
		$this->syncOriginal();
		
		if (!empty($conexion) && !is_null($conexion)) {
			$this->connection = $conexion;
		}
	}
	
	/**
	 * Retorna un array que contiene la lista completa del modelo ordenado por su clave
	 * Formato de retorno: ['clave_objeto' => 'objeto_original'].
	 * @param boolean $status Retornar solo los registros con estatus activo (default: false)
	 * @return array() (collection)
	 */
	public static function lista($status = false) {
		if ($status) {
			$object = self::where('estatus','A')->get(); 
		}
		else {
			$object = self::all();
		}
		
		return $object->mapWithKeys(function($object, $key) {
				return [$object->clave => $object->original];
			})->all();
	}
	
	/**
	 * Crea registro en el origen seleccionado.
	 * @param array $datos Mapa de datos a insertar.
	 * @return this
	 */
	public function crear($datos){
		foreach($datos as $cve => $dato){ $this->{$cve} = $dato; }
		return $this->save();
	}
	
	/**
	 * Crear o actualiza un modelo con una conexion configurable.
	 * @param array $unico Arreglo del valor unico en la DB.
	 * @param array $info Arreglo con los campos a insertar.
	 * @param string $conexion Nombre de la conexion a usar.
	 * @return objeto instancia del modelo usado.
	 */
	static public function crearConOtraConexion($unico,$info,$conexion = 'default'){
		$self = new static;
		$self->connection = $conexion;
		return self::updateOrCreate($unico,$info);
	}
	
	// Se inicializa el driver de eloquent dentro de la clase para prevenir conflictos.
	public function modoCompatible(){
		self::$driver = (new Database)->init();
		return new static();
	}
}
