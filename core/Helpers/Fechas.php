<?php
	/*
	 * CLASE CON FUNCIONES DE FECHAS
	 * GENERADO POR: MIGUEL VALDES
	 * FECHA INICIO: 10 ABRIL 2018 11:07
	 *
	 */

	namespace App\Core\Helpers;
	
	use App\core\Helpers\Validador;
	
	class Fechas{
		public $formatoSitio = 'd/m/Y';
		public $formatoDB = 'Y-m-d H:i:s';
		
		static function convertir($fecha){
			if(!empty($fecha)){
				if(Validador::fecha($fecha)){
					$obj = new self;
					return date($obj->formatoDB, strtotime(str_replace('/','-',$fecha)));
				}
			}
			return false;
		}
		
		static function imprimir($fecha, $formato = ''){
			$obj = new self;
			if(empty($fecha)) return '';
			return date($formato ? $formato : $obj->formatoSitio, strtotime($fecha));
		}
		
		static function tiempo(){
			$obj = new self;
			return date($obj->formatoDB, time());
		}
		
		static function definir($fecha){
			$obj = new self;
			$fecha = strtotime($fecha) ? : 0;
			return $fecha ? date($obj->formatoSitio, $fecha) : '';
		}
		
		static function timestampFecha($fecha, $formato = ''){
			$obj = new self;
			if(!empty($fecha)){
				return date($formato ? : $obj->formatoDB, $fecha);
			}
			return null;
		}
		
		static function mesNombre($mes) {
			$meses = [
				'01'=>'Enero',
				'02'=>'Febrero',
				'03'=>'Marzo',
				'04'=>'Abril',
				'05'=>'Mayo',
				'06'=>'Junio',
				'07'=>'Julio',
				'08'=>'Agosto',
				'09'=>'Septiembre',
				'10'=>'Octubre',
				'11'=>'Noviembre',
				'12'=>'Diciembre'
			];
			
			if (array_key_exists($mes, $meses)) {
				return $meses[$mes];
			}
			
			return '';
		}
		
		static function fechaFormatoMexCompleto() {
			$obj = new self;
			
			return sprintf("%s de %s de %s", date("d"), $obj->mesNombre(date("m")), date("Y"));
		}
	}