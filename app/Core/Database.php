<?php namespace App\Core;

/**
* Database
*/
class Database
{
	public static $instance;

	/**
	 * CONFIG VARS
	 */
	private $host;

	private $user;

	private $password;

	private $database;

	/**
	 * DB connection
	 */
	private $pdo;
	

	function __construct()
	{
		$this->host		= Config::get('DB_HOST');
		$this->user		= Config::get('DB_USER');
		$this->password	= Config::get('DB_PASSWORD');
		$this->database	= Config::get('DB_NAME');

		$this->pdo = new \PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8mb4", $this->user, $this->password);
	}


	public static function get_instance()
	{
		if ( !static::$instance ) {
			static::$instance = new static;
		}
		return static::$instance;
	}
}