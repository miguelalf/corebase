<?php
	/*
	 * CLASE STRINGS
	 * GENERADO POR: MIGUEL VALDES
	 * FECHA INICIO: 24 SEPTIEMBRE 2018 11:00
	 *
	 */

	namespace App\Core\Helpers;
	
	class Strings{
		/*
		 * Método traerEntre Regresa cualquier string delimitado por otros dos
		 */
		static function entre($string, $inicio = '', $fin = ''){
			if(strpos($string, $inicio) !== false){
				$contador_inicio = strpos($string, $inicio) + strlen($inicio);
				$substr = substr($string, $contador_inicio, strlen($string));
				$contador_final = strpos($substr, $fin);
				if($contador_final == 0){
					$contador_final = strlen($substr);
				}
				return substr($substr, 0, $contador_final);
			} else {
				return '';
			}
		}
	}