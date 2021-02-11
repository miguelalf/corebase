<?php
	namespace App;
	
	require_once __DIR__ . '/vendor/autoload.php';
	
	use App\Core\Webpage;
	use App\Core\Helpers\Dump;
	
	class Prueba extends Webpage {
		private $data;
		
		function __construct() {
			parent::__construct();
			
			$this->getSession();
			$this->getDatabase();
			
			$this->data = [];
			
			$this->data->registros = $this->db->table('test')
				->get()
				->all();
		}
		
		public function panel($target = 'default') {
			$this->view($target, $this->data);
			die();
		}
	}
	
	try { $panel = (new Prueba)->panel(); } 
	catch(\Exception $ex) { Dump::dx($ex->getMessage()); }