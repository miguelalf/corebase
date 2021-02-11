<?php

namespace App\Modelos;

use App\Modelos\MyModel;
use Illuminate\Database\Capsule\Manager as DB;

class Cliente extends MyModel{
	
	protected $primaryKey = 'id';
	protected $table = 'cliente';
	protected $connection = 'default';
	
	public $timestamps = false;
	public $incrementing = true;
}