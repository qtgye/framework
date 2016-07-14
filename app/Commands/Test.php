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
		$method = $param ? $param : 'all';

		if ( method_exists($this, $method) ) {
			call_user_func_array([$this,$method], [$this->options]);
		} else {
			$this->_echo("\033[31m\r\nInvalid test method.\r\n");
		}
	}


	/**
	 * Assert function
	 * @param  string $assertion Assertion message ('be able to fetch data')
	 * @param  bool $test result of test
	 * @return [type] [description]
	 */
	private function assert( $assertion, $test = FALSE)
	{
		$this->_echo("\033[36m\r\n{$assertion}");

		if ( $test === NULL || $test === FALSE || empty($test) ) {
			$this->_echo("\033[31m  ✕ FAIL\r\n\r\n");
		} else {
			$this->_echo("\033[32m  ✓ PASS\r\n\r\n");
		}
	}


	/**
	 * Runs all the tests
	 */
	private function all()
	{
		// $this->assert('Some Test Here...',TRUE);
	}


	private function config()
	{
		$paths = defined('ROOT_DIR')
				&& 	defined('APP_DIR')
				&& 	defined('ASSETS_DIR')
				&& 	defined('PUBLIC_DIR');

var_dump(ROOT_DIR);
var_dump(APP_DIR);
var_dump(ASSETS_DIR);
var_dump(PUBLIC_DIR)		;

		$this->assert('Config should set directory path constants',$paths);
	}


	private function db()
	{
		var_dump(\App\Core\Database::get_instance());
	}

}