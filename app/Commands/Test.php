<?php namespace App\Commands;

use App\Core\Config;
use App\Core\Database;

/**
* 
*/
class Test extends BaseCommand
{	
	private $assertions = 0;

	private $passed_asserts = 0;

	function __construct($arguments)
	{
		parent::__construct($arguments);
	}


	public function run($param)
	{
		$method = $param ? $param : 'all';

		$this->_echo("\r\n");

		if ( method_exists($this, $method) ) {
			call_user_func_array([$this,$method], [$this->arguments]);
		} else {
			$this->_echo("\033[31m\r\nInvalid test method.\r\n");
		}

		if ( $this->assertions > 0 ) {
			if ( $this->failed_asserts != $this->assertions ) {
				$this->_echo("\r\n\033[41;1;37m\r\n   {$this->failed_asserts} ASSERTION".($this->failed_asserts>1?'S':'')." FAILED!  ");
			} else {
				$this->_echo("\r\n\033[32m\r\n   ALL ASSERTIONS PASSED!");
			}
		}		

		$this->_echo("\r\n\r\n");
		
	}


	/**
	 * Assert function
	 * @param  string $assertion Assertion message ('be able to fetch data')
	 * @param  bool $test result of test
	 * @return [type] [description]
	 */
	private function assert( $assertion, $test = FALSE)
	{
		$this->_echo("\033[1;30m\r\n  {$assertion}");

		if ( $test === NULL || $test === FALSE || empty($test) ) {			
			$this->_echo("\033[31m  ✕ FAIL");
			$this->failed_asserts++;
		} else {
			$this->_echo("\033[32m  ✓ PASS");
		}
	}

}