<?php
	/*
	 * ADMINISTRADOR DE LAS CONEXIONES DE LAS BASES DE DATOS.
	 * GENERADO POR: MIGUEL VALDES
	 * FECHA INICIO: 25 MAYO 2017 18:29
	 */
	namespace App\Core;
	use \PDO;

	use Illuminate\Database\Capsule\Manager as Capsule;
	
	class Database {
		private $config =
			[
				['driver'  => 'mysql',
				'host'      => 'localhost',
				'database'  => 'prod',
				'username'  => 'root',
				'password'  => '',
				'charset'   => 'utf8',
				'options'   => [
						PDO::MYSQL_ATTR_SSL_CA => '/etc/httpd/conf.d/certs/rds-combined-ca-bundle.pem'
					]
				// Produccion
				],
				['driver'  => 'mysql',
				'host'      => 'localhost',
				'database'  => 'pruebas',
				'username'  => 'radar',
				'password'  => '',
				'charset'   => 'utf8',
				'options'   => [
						PDO::MYSQL_ATTR_SSL_CA => '/etc/httpd/conf.d/certs/rds-combined-ca-bundle.pem'
					]
				// Pruebas
				]
			];
		
		public $capsule;
		
		public $schema;
		
		public function init() {
			$this->capsule = new Capsule;
			
			$this->capsule->addConnection($this->config[0]);
			$this->capsule->addConnection($this->config[1],'pruebas');
			$this->capsule->bootEloquent();
			$this->capsule->setAsGlobal();
			$this->schema = $this->capsule->schema();
			
			return $this;
		}
	}
