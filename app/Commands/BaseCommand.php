<?php namespace App\Commands;

/**
* 
*/
class BaseCommand
{
	protected $options;

	protected $appDir;
	
	function __construct($options)
	{
		$this->options = $options;
		$this->appDir = dirname(__DIR__);
	}


	public function run($param)
	{
		
	}

	/**
	 * Prints to CLI
	 * @param  string $output The string to display
	 * @return void 
	 */
	public function printOut($output)
	{
		echo $output;
	}
}