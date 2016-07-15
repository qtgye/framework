<?php namespace App\Commands;

/**
* 
*/
class Make extends BaseCommand
{
	private $makeClasses = [
				'command' 		=> 'Commands',
				'model' 		=> 'Models',
				'controller' 	=> 'Controllers',
				'helper' 		=> 'Helpers'
			];
	
	function __construct($options)
	{
		parent::__construct($options);
	}


	private function createClassFile($type,$class)
	{
		$contents = $this->getClassFileContents($type);
		$contents = str_replace('{{'.$type.'}}', $class, $contents);	

		$this->_echo("\r\n\033[1;30mGenerating {$type}: {$class}...\033[0m\r\n\r\n");

		if ( file_put_contents($this->appDir."/{$this->makeClasses[$type]}/{$class}.php", $contents) ) {
			die("\033[32mSuccess!\033[0m\r\n\r\n");
		}
	}


	private function getClassFileContents($type)
	{
		$contents = file_get_contents($this->appDir."/Helpers/class_templates/{$type}.php");
		return $contents;
	}


	public function run($param)
	{
		if ( $param && array_key_exists($param, $this->makeClasses) ) {
			$classname = array_shift($this->arguments);

			if ( !$classname ) {
				$this->_echo("\033[31mPlease provide a class name.\033[37m" . PHP_EOL);
				exit();
			}

			$this->createClassFile($param,$classname);
		}
	}
}