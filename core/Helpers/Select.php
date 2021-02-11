<?php
	/*
	 * CLASE DE AYUDA PARA FORMAR DROPDOWNS
	 * GENERADO POR: MIGUEL VALDES
	 * FECHA INICIO: 03 ABRIL 2018 13:45
	 *
	 */

	namespace App\Core\Helpers;
	
	use stdClass;
	use Exception;
	use App\Core\Helpers\Etiqueta;
	
	# Clase Select
	# Para inicializar se pasan los atributos(id, name, class,stye, etc), opciones(catalogo) y el
	# valor seleccionado (Todos opcionales)
	#	|->  $select = new Select($arreglo_atributos, $arreglo_opciones, $opcion_seleccionada);
	#	|->  $select = new Select();
	# Se puede usar el método darForma para asignar los atributos, tienen que estar en un arreglo
	# en el formato [attributo => valor]
	#	|->  $select->darForma($arreglo_atributos);
	# Para imprimir se manda a llamar el método dibujar, acepta como parametros el arreglo de
	# atributos y la opcion seleccionada, o bien ninguno.
	#	|->  $select->dibujar();
	#	|->  $select->dibujar(false, 4);
	#	|->  $select->dibujar($arreglo_atributos, 5);
	
	class Select implements Etiqueta{
		public $opciones = [];
		public $seleccionado = 0;
		
		function __construct($attrs = false, $opciones = false, $seleccionado = false){
			$this->atributos = new stdClass;
			$this->crear($attrs, $opciones, $seleccionado);
		}
		
		public function darForma($attrs){
			$this->atributos = new stdClass;
			if(!is_array($attrs)){
				throw new Exception('El argumento 1 tiene que ser de tipo array [attributo => valor]');
			}
			$this->init($attrs);
			return $this;
		}
		
		public function dibujar($attrs = false, $seleccionado = false){
			$this->crear($attrs, false, $seleccionado);
			
			$this->html = '<select ';
			foreach($this->atributos as $key => $attr){
				$this->html .= sprintf('%s="%s" ', $key, $attr);
			}
			$this->html .= '>';
			foreach($this->opciones as $value){
				if(!is_array($this->seleccionado)) {
					$_selected = $value->clave == $this->seleccionado;
				} else {
					$_selected = in_array($value->clave, $this->seleccionado);
				}
				
				$this->html .= sprintf('<option value="%s" %s>%s (%s)</option>', 
					$value->clave, $_selected ? 'selected' : '', $value->nombre, $value->clave);
			}
			$this->html .= '</select>';
			
			return $this->html;
		}
		
		private function crear($attrs, $opciones, $seleccionado){
			if(is_array($attrs)){
				$this->init($attrs);
			}
			
			if(is_array($opciones)){
				$this->opciones = $opciones;
			}
			
			if($seleccionado !== false){
				$this->seleccionado = $seleccionado;
			}
		}
		
		private function init($attrs){
			if(!is_array($attrs)){
				throw new Exception('El argumento 1 tiene que ser de tipo array [attributo => valor]');
			}
			foreach($attrs as $key => $value){
				$this->atributos->{$key} = $value;
			}
		}
	}