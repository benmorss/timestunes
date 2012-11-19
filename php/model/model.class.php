<?php

include_once ("../config/config.php");

class Model {

	private $dbHost;
	private $dbUser;
	private $dbPass;
	private $dbDatabase;

	private $where;
	private $orderBy;
	private $limit;

	public function __construct() {
		global $DB_HOST, $DB_USER, $DB_PASS, $DB_DATABASE;

		$this->dbHost = $DB_HOST;
		$this->dbUser = $DB_USER;
		$this->dbPass = $DB_PASS;
		$this->dbDatabase = $DB_DATABASE;
	}

	protected function connect() {
		if (!mysql_connect($this->dbHost, $this->dbUser, $this->dbPass))
			throw new Exception('Could not connect to mysql');
		if (!mysql_select_db($this->dbDatabase))
			throw new Exception("Could not open database {$this->dbDatabase}");
	}

	protected function execute($query) {
		$this->connect(); 		print "$query\n";
		if (!($dbResult = mysql_query($query)))
			throw new Exception("Could not execute query '$query'. Error: " . mysql_error());
		return $dbResult;
	}

	protected function getSingleton($query) {
		if ($dbResult = $this->execute($query))
			return mysql_result($dbResult, 0);
	}

	protected function getRow($query) {
		$dbResult = $this->execute($query);
		return mysql_get_assoc($dbResult);	
	}

	protected function getArray($query) {
		$dbResult = $this->execute($query);
		while ($retval[] = mysql_get_assoc($dbResult))
			;
		return $retval;
	}	

	public function deleteAll() {
		$this->connect();
		return $this->execute("DELETE FROM {$this->table}");
	}

	public function selectAll() {
		$this->connect();
		return getArray("SELECT * FROM {$this->table}");
	}
}


?>