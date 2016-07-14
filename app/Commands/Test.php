<?php namespace App\Commands;

use App\Core\Config;
use App\Core\Database;

/**
* 
*/
class Test extends BaseCommand
{	
	private $failed_asserts = 0;

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

		if ( $this->failed_asserts > 0 ) {
			$this->_echo("\r\n\033[41;1;37m\r\n   {$this->failed_asserts} ASSERTION".($this->failed_asserts>1?'S':'')." FAILED!  ");
		} else {
			$this->_echo("\r\n\033[32m\r\n   ALL ASSERTIONS PASSED!");
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


	/**
	 * Runs all the tests
	 */
	private function all()
	{
		// $this->assert('Some Test Here...',TRUE);
	}


	private function config()
	{
		Config::setup();

		$paths = defined('ROOT_DIR')
				&& 	defined('APP_DIR')
				&& 	defined('ASSETS_DIR')
				&& 	defined('PUBLIC_DIR');

		$this->assert('Config should set directory path constants',$paths);
	}


	private function db()
	{
		Config::setup();
		
		$file_exists = file_exists(ROOT_DIR.'/.config');
		$this->assert('A config file should be existing',$file_exists);

		if ( $file_exists ) {
			$db_config = Config::get('DB_HOST')
						&& Config::get('DB_USER')
						&& Config::get('DB_PASSWORD')
						&& Config::get('DB_NAME');
			$this->assert('Should have basic database connection variables',$db_config);
		}

		if ( $db_config ) {
			$this->assert('Should connect to database using correct settings',
							Database::get_instance()->pdo instanceof \PDO);
		}

	}

}