<?php

	namespace App\Core;
	
	use App\Core\Service;
	use App\Core\Database;
	use League\Plates\Engine;
	use Illuminate\Database\Capsule\Manager as DB;
	
	/*
	 * Clase con todo lo necesario para generar una pagina en radar
	 */
	class Webpage {
		function __construct() {
			$this->route = '/web/';
			
			$remote = $_SERVER['REMOTE_ADDR'];
			$document = $_SERVER['DOCUMENT_ROOT'];
			
			$this->local = $remote == '127.0.0.1' || $remote == ':::1' ? true : false;
			$this->path = $document . ($this->local == 1 ? $this->route : '/');
			$this->link = $this->local == 1 ? $this->route : '/';
			$this->connection = $this->route == '/web/' ? 'default' : 'pruebas';
			
			$this->title = 'PAGINA';
		}
		
		public function getSession(){
			$this->session = $_SESSION;
			
			return $this;
		}
		
		public function getDatabase() {
			$init = (new Database())->init();
			$this->query = $this->db = DB::connection($this->connection);
			
			return $this;
		}
		
		public function getParams() {
			try {
				if(!empty($_GET['p']))
					return Service::decode($_GET['p']);
				else
					return (object) $_GET;
			}
			catch(\Exception $ex) { throw $ex; }
		}
		
		public function redirect($page = 'index.php') {
			$page = $page == 'error' ? 'error.php' : $page;
			
			die(header(sprintf('Location: %s%s', $this->link, $page)));
		}
		
		static public function error() {
			$self = new Self;
			$self->redirect('error');
		}
		
		/*
		 * Metodo para dibujar vista
		 * @page - Nombre del archivo php del template
		 * @data - Variables a pasar al template
		 * @path - Ruta a template
		 */
		public function view($page = 'index.php', $data = [], $path = 'vistas') {
			$template = new Engine($path);
			
			(array) $data;
			$data['navbar'] = $this->navbar();
			$data['web'] = get_object_vars($this);
			// Se quita Query para evitar pasar la capsula
			if(!empty($data['web']['query'])) unset($data['web']['query']);
			$data['template']['web'] = $data['web'];
			// Titulo ya sea por config o por atributo
			if(empty($data['template']['title'])) $data['template']['title'] = $this->title;
			
			echo $template->render($page, $data);
		}
	}