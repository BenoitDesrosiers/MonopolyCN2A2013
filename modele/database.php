<?php
class Database {
	private static $dsn = 'mysql:host=localhost;dbname=monopoly';
	private static $username = 'monop';
	private static $password = 'monopoly';
	private static $db;
	private static $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
									PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"); // pour que la bd soit lu en utf-8
	
	private function __construct() {}
	
	public static function getDB () {
		if (!isset(self::$db)) {
			try {
				self::$db = new PDO(self::$dsn,
									self::$username,
									self::$password,
									self::$options);
			} catch (PDOException $e) {
				$msg_erreur = $e->getMessage();
				include('erreurs/db_erreur_connect.php');
				exit();
			}
		}
		return self::$db;
	}
}
?>