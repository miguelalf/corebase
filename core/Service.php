<?php
	/*
	 * SERVICIOS PARA URL
	 * GENERADO POR: MIGUEL VALDES
	 * FECHA INICIO: 03 DICIEMBRE 2018 15:44
	 */

	namespace App\Core;
	
	use \Exception;
	
	class Service{
		// Crea string de parametro en base64
		static public function encode($value){
			return base64_encode(json_encode($value));
		}
		
		// Decodificar parametros
		static public function decode($value){
			$self = new Self;
			return $self->_json($self->_base64($value));
		}
		
		// Decodifica la base
		protected function _base64($value){
			$value = base64_decode($value);
			
			if(!$value){
				throw new Exception('No es una cadena valida');
			}
			
			return $value;
		}
		
		// Decodifica el json
		protected function _json($value){
			$value = json_decode($value);
			
			if($err = json_last_error() !== JSON_ERROR_NONE){
				throw new Exception('Error de json - No ' . $err);
			}
			
			return $value;
		}
	}
	
