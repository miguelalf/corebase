<?php
	/*
	 * CLASE DUMP
	 * GENERADO POR: MIGUEL VALDES
	 * FECHA INICIO: 04 ABRIL 2018 12:17
	 *
	 */

	namespace App\Core\Helpers;
	
	/*
	 *
	 * Método dx devuelve el dump de la variable y termina el programa
	 * Método dd devuelve el dump y continua el programa
	 *
	 */
	class Dump{
		static function dx($var){
			echo '<pre>';
			die(var_dump($var));
		}
		
		static function dd($var){
			echo '<pre>';
			var_dump($var);
			echo '</pre>';
		}
	}