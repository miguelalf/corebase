<?php
	/*
	 * CLASE PARA SUBIR DOCUMENTOS RADAR
	 * GENERADO POR: MIGUEL VALDES
	 * FECHA INICIO: 03 DICIEMBRE 2018 15:44
	 *
	 */

	namespace App\Core\Helpers;
	
	use stdClass;
	use SoapFault;
	use SoapClient;
	use App\Modelos\Parametro;
	
	class Documento{
		public $parametros;
		protected $datosWsdl;
		protected $opcionesWsdl = [
			'soap_version' => SOAP_1_2,
			'exceptions' => true,
			'trace' => 1,
			'cache_wsdl' => WSDL_CACHE_NONE
		];
		
		// Constructor
		public function __construct($tipo = false){
			$this->_parametros($tipo);
		}
		
		// Obtiene del modelo los parametros requeridos
		protected function _parametros($tipo = false){
			try{
				$this->parametros = Parametro::valoresDocumentos($tipo);
			} catch(\Exception $ex) { throw $ex; }
		}
		
		protected function _validarParametros(){
			if(!is_object($this->parametros)){
				throw new \Exception('No se puede preparar la solicitud sin los parametros adecuados');
			}
		}
		
		protected function _validarDatos(){
			if(!is_object($this->datosWsdl)){
				throw new \Exception('No se puede subir el documento si no se prepara con anterioridad');
			}
		}
		
		// Prepara los datos a grabar
		public function prepararEnCarpeta($nombre, $contenido){
			$this->_validarParametros();
			
			if(empty($nombre) || !is_string($nombre)){
				throw new \Exception('Nombre del documento es requerido como string');
			}
			
			if(empty($contenido) || !is_string($contenido)){
				throw new \Exception('Contenido del documento es requerido');
			}
			
			$this->datosWsdl = new stdClass();
			$this->datosWsdl->messageId = sprintf('%s%s', date('YmdHis'), substr(str_replace('.', '', microtime()), 0, 5));
			$this->datosWsdl->nombreArchivo = $this->parametros->path . $nombre;
			$this->datosWsdl->contenidoArchivo = $contenido;
			$this->datosWsdl->origenBDId = $this->parametros->parametro;
		}
		
		// Manda la solicitud para subir el documento
		public function subirDocumento(){
			$this->_validarParametros();
			$this->_validarDatos();
			
			try{
				$consulta = new SoapClient($this->parametros->url, $this->opcionesWsdl);
				$respuesta = $consulta->subirDocumento(get_object_vars($this->datosWsdl));
				$this->respuesta = explode('|', $respuesta->return);
				return $this->respuesta;
			}
			catch (SoapFault $ex){ throw $ex; }
			catch (\Exception $ex){ throw $ex; }
		}
	}
	
