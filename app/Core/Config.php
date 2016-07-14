<?php namespace App\Core;

/**
* Config
*/
class Config
{
	public static $instance;

	private $DB_HOST;

	private $DB_USER;

	private $DB_PASSWORD;

	private $DB_NAME;

	
	function __construct()
	{		
	}


	/**
	 * Gets the singleton instance
	 * @return Config instance
	 */
	public static function get_instance()
	{
		if ( !static::$instance ) {
			static::$instance = new static;
		}
		return static::$instance;
	}


	/**
	 * Stores config data from .config file
	 * @return void 
	 */		
	public static function setup()
	{
		$instance = static::get_instance();

		$instance->setup_paths();
		$instance->setup_env_config();
	}


	/**
	 * Sets up directory path constants
	 * @return void
	 */
	private function setup_paths()
	{
		define('ROOT_DIR', dirname(dirname(dirname(__FILE__))));
		define('APP_DIR', ROOT_DIR."/app");
		define('PUBLIC_DIR', ROOT_DIR."/public");
		define('ASSETS_DIR', ROOT_DIR."/assets");
	}


	/**
	 * Parse environment configuration from .config file
	 * @return [type] [description]
	 */
	private function setup_env_config()
	{
		$file_path = ROOT_DIR.'/.config';

		if ( file_exists($file_path) ) {

			$contents = file_get_contents($file_path);
			$config = json_decode($contents);

			foreach (get_object_vars($config) as $key => $value) {
				static::set($key,$value);				
			}

			return;
		}

		throw new \Exception("No config file found");
	}


	/**
	 * Sets a private config property through the instance
	 * @param string $key 
	 * @param mixed $value 
	 */
	public function _set($key,$value)
	{
		$this->$key = $value;
	}


	/**
	 * GEts a config property through the instance
	 * @param string $key 
	 * @param mixed $value 
	 */
	public function _get($key)
	{
		return $this->$key;
	}


	/**
	 * Sets a private config property statically through the Config class
	 * @param string $key 
	 * @param mixed $value 
	 */
	private function set($key,$value)
	{
		static::get_instance()->_set($key,$value);
	}


	/**
	 * Gets a config value statically through the Config class
	 * @param  string $key
	 * @return void 
	 */
	public static function get($key)
	{
		return static::get_instance()->_get($key);
	}
}