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


}