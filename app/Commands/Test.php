<?php namespace App\Commands;

/**
* 
*/
class Test extends BaseCommand
{	
	function __construct($options)
	{
		parent::__construct($options);
	}


	public function run($param)
	{
		$method = $param;

		if ( method_exists($this, $method) ) {
			call_user_func_array([$this,$method], [$this->options]);
		} else {
			$this->_echo("\033[31m\r\nInvalid test method.\r\n");
		}
	}


	private function config()
	{
		// var_dump(ROOT_DIR);
		// var_dump(APP_DIR);
		// var_dump(ASSETS_DIR);
		// var_dump(PUBLIC_DIR);

		var_dump(\App\Core\Config::get('DB_HOST'));
	}
}