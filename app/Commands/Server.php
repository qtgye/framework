<?php namespace App\Commands;

/**
* 
*/
class Server extends BaseCommand
{	
	function __construct($options)
	{
		parent::__construct($options);
	}


	public function run($param)
	{
		$param = empty($param) ? 'up' : $param;
		$this->$param();
	}


	private function up()
	{
		$pid = $this->get_serve_pid();

		if ( $pid ) {
			$this->_echo("\033[32m\r\nServer is already running.\r\n");
		} else {
			shell_exec('php -S localhost:8000 -t public/ &> /dev/null &');
			$this->_echo("\033[0;36m\r\nStarting built-in server on localhost:8000" . PHP_EOL);
		}
		
	}


	private function down()
	{
		$pid = $this->get_serve_pid();		

		if ( $pid ) {
			$this->_echo("\033[36m\r\nStopping server...\r\n");
			shell_exec("kill {$pid}");
			$this->_echo("\033[37m\r\nServer stopped.\r\n");
		}
	}


	private function get_serve_pid()
	{
		$result = shell_exec('ps -ef | grep php');
		$result = explode(PHP_EOL, $result);
		$result = array_filter($result,function ($item)
		{
			return preg_match('/php -S localhost/i', $item);
		});

		if ( isset($result[0]) ) {
			preg_match('/\s?[0-9]{4,9}\s?/', $result[0], $matches);
			$pid = !empty($matches[0]) ? trim($matches[0]) : NULL;
			return $pid;
		}

		return NULL;
	}
}