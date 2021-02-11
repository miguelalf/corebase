<?php
	/*
	 * CLASE CORREOS
	 * GENERADO POR: MIGUEL VALDES
	 * FECHA INICIO: 06 JULIO 2018 12:53
	 *
	 */

	namespace App\Core\Helpers;
	
	include __DIR__ . '/../../comun/correo/class.phpmailer.php';
	
	use App\Modelos\Parametro;
	
	class Correo extends \PHPMailer{
		private $server_values;
		
		public function __construct(){
			parent::__construct();
			
			$this->server_values = Parametro::valoresCorreo();
			
			$this->Host = $this->server_values->servidor;
			$this->Port = $this->server_values->puerto;
			$this->Username = $this->server_values->correo;
			$this->Password = $this->server_values->pass;
			$this->From = $this->server_values->correo;
			$this->FromName = 'SERVICIOS';
			$this->SMTPAuth = true;
		}
		
		public function agregarCC($data){
			if (is_array($data)) {
				foreach ($data as $correo => $nombre) {
					if (strlen(trim($correo)) > 0) {
						$this->AddCC($correo, $nombre);
					}
				}
			}
			
			return $this;
		}
		
		public function agregarPara($data){
			if (is_array($data)) {
				foreach ($data as $correo => $nombre) {
					if (strlen(trim($correo)) > 0) {
						$this->AddAddress($correo, $nombre);
					}
				}
			}
				
			return $this;
		}
	}