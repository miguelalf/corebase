<?php
	/*
	 * CLASE DE AYUDA PARA TRAER CATALOGOS VARIADOS
	 * GENERADO POR: MIGUEL VALDES
	 * FECHA INICIO: 02 ABRIL 2018 10:45
	 * TABLA: catalogos_variados
	 *
	 */

	namespace App\Core\Helpers;
	
	use stdClass;
	use App\Core\Database;
	use App\Core\Helpers\Select;
	use Illuminate\Database\Capsule\Manager as DB;
	
	# Clase Catalogos.
	# Para inicializar se llama al método lista pasando un arreglo en formato [[alias => nombre_tabla],...]
	# Crea un objeto de tipo Catalogos con el atributo listas que contiene los catálogos en formato {clave, nombre}
	# Modo de acceder a las listas: $obj->listas->alias
	# Cada $obj->listas->alias ya contiene un objeto de tipo Select (Ver clase Select)
	
	class Catalogos {
		public $compatible = false;
		public $targets; // [alias => nombre_tabla]
		public $listas; // alias{tabla, lista}
		
		private $conexion = 'default';
		private $table = 'catalogos_variados';
		private $driver;
		
		function __construct($lista = []){
			$this->listas = new stdClass;
			$this->targets = [];
			
			$this->agregarLista($lista);
			
			if(count($this->targets) > 0){
				$this->crearListas();
			}
		}
		
		function __destruct(){
			$this->listas = new stdClass;
			$this->targets = [];
			$this->driver = null;
		}
		
		// Agrega y busca los catalogos
		public function lista($lista){
			$this->agregarLista($lista);
			$this->crearListas();
			return $this->listas;
		}
		
		// Se inicializa el driver de eloquent dentro de la clase para prevenir conflictos.
		public function modoCompatible(){
			$this->compatible = true;
			$this->driver = (new Database)->init();
			return $this;
		}
		
		// Recibe el nombre de la conexion a usar
		public function cambiarConexion($nombre){
			if(is_string($nombre)){
				$this->conexion = $nombre;
			}
			return $this;
		}
		
		// Recibe un catalogo y en la prop nombre se hace encode a utf8
		static public function encode($catalogo){
			foreach($catalogo as $clave => $elemento){
				$catalogo[$clave]->nombre = utf8_encode($elemento->nombre);
			}
			return $catalogo;
		}
		
		private function agregarLista($lista){
			if(!is_array($lista)){
				$this->targets[] = $lista;
			}else{
				$this->targets = array_merge($this->targets, $lista);
			}
		}
		
		private function crearListas(){
			try{
				$tablas = $this->traerTablas();
				
				foreach($this->targets as $alias => $tabla){
					if(!is_numeric($alias) && !empty($tablas[$tabla])){
						$_inicio = [];
						$_lista = $tablas[$tabla];
						
						// Si tiene valor por defecto guardarlo
						if($_lista[0]->clave == 0) { 
							$_inicio = $_lista[0]; 
							unset($_lista[0]);
						}
						
						// Ordena la lista segun el nombre
						$_lista = collect($_lista)->sortBy('nombre')->all();
						
						// Vuelve a poner valor por defecto en el arreglo
						if(!empty($_inicio)) { array_unshift($_lista, $_inicio); }
						
						$this->listas->{$alias} = new stdClass;
						$this->listas->{$alias}->tabla = $tabla;
						$this->listas->{$alias}->lista = $tablas[$tabla];
						$this->listas->{$alias}->select = new Select(false, $_lista);
					}
				}
			}
			catch(\PDOException $ex){ throw($ex); }
			catch(\Exception $ex){ throw($ex); }
		}
		
		private function traerTablas(){
			try{
				return DB::connection($this->conexion)->table($this->table)
					->select('nombre','detalle')
					->whereIn('nombre',array_values($this->targets))
					->where('estatus','A')
					->get()
					->mapWithKeys(function($catalogo){
						return [$catalogo->nombre => json_decode(utf8_encode($catalogo->detalle))];
					})
					->all();
			}
			catch(\PDOException $ex){ throw($ex); }
			catch(\Exception $ex){ throw($ex); }
		}
	}