<?php
	/*
	 * CLASE CON UTILERIA PARA VALIDAR DATOS
	 * GENERADO POR: MIGUEL VALDES
	 * FECHA INICIO: 10 ABRIL 2018 10:55
	 *
	 */

	namespace App\Core\Helpers;
	
	class Validador{
		
		# Metodo validar fechas
		# Valida que sea una feha en formato tradiciional latino
		# @$fecha string d/m/Y
		# return bool
		static function fecha($fecha){
			if(!empty($fecha)){
				$es_fecha = strtotime(str_replace('/','-',$fecha));
			
				preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/', $fecha, $aplica);
			
				if($es_fecha && $aplica) 
					return true;
			}
			return false;
		}
	}